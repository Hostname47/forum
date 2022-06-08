<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Exceptions\SearchException;
use App\Models\{Thread, User, Forum, Category, Vote, Like};

class SearchController extends Controller
{
    const TAB_WHITE_LIST = ['all', 'today', 'thisweek'];
    public function search(Request $request) {
        $keyword = "";
        $tab = 'all';
        $tab_title = __('All');
        $pagesize = 10;

        if($request->has('pagesize'))
            $pagesize = $request->validate(['pagesize'=>['numeric', Rule::in([6, 10, 16])]])['pagesize'];
        if($request->has('k'))
            $keyword = $request->validate(['k'=>'max:2000'])['k'];

        $threads = $this->srch(Thread::query(), $keyword, ['subject', 'content'], ['LIKE', 'LIKE']);

        if($request->has('tab')) {
            $tab = $request->validate(['tab'=>Rule::in(self::TAB_WHITE_LIST)])['tab'];
            switch($tab) {
                case 'today':
                    $threads = $threads->today();
                    $tab_title = __('Today');
                    break;
                case 'thisweek':
                    $threads = $threads->where('created_at', '>=', Carbon::now()->subDays(7)->setTime(0, 0));
                    $tab_title = __('This week');
                    break;
            }
        }
        $threads = $threads->orderBy('view_count', 'desc')->orderBy('created_at', 'desc')->paginate($pagesize);
        $users = $this->srch(User::query()->excludedeactivatedaccount(), $keyword, ['username', 'firstname', 'lastname'], ['LIKE', 'LIKE', 'LIKE'])
                      ->orderBy('username', 'asc')
                      ->paginate(4);

        return view('search.search')
            ->with(compact('threads'))
            ->with(compact('users'))
            ->with(compact('pagesize'))
            ->with(compact('keyword'))
            ->with(compact('tab'))
            ->with(compact('tab_title'));
    }

    public function search_advanced(Request $request) {
        $forums = Cache::rememberForever('all-forums', function () {
            return Forum::all();
        });
        
        return view('search.search-advanced')
            ->with(compact('forums'));
    }

    public function search_advanced_results(Request $request) {
        $tab = 'all';
        $tab_title = __('All');
        $pagesize = 10;
        if($request->has('pagesize'))
            $pagesize = $request->validate(['pagesize'=>'numeric'])['pagesize'];

        $filters = [];

        $data = $this->validate($request, [
            'k'=>'sometimes|min:1|max:2000',
            'forum'=> [
                'sometimes',
                function ($attribute, $value, $fail) use (&$filters) {
                    $slugs = Cache::rememberForever('all-forum-slugs', function() { return Forum::pluck('slug'); })->toArray();
                    $slugs[] = 'all';

                    if(!in_array($value, $slugs))
                        $fail(__("Forum does not exists in our records"));
                    else
                        if($value != 'all')
                            $filters[] = [__('Forum'), __(Cache::rememberForever('forum-name-' . $value, function() use ($value) { return Forum::where('slug', $value)->first()->forum; })), 'forum'];
                },
            ],
            'category'=>[
                'sometimes',
                function ($attribute, $value, $fail) use (&$filters) {

                    if(($forumslug = request()->forum) && $forumslug != 'all') {
                        $categories_ids = 
                            Cache::rememberForever('forum-categories-ids-by-slug' . $forumslug, function() use ($forumslug) {
                                return Forum::where('slug', $forumslug)->first()->categories()->pluck('id')->toArray();
                            });
                        $categories_ids[] = 0;

                        if(!in_array($value, $categories_ids))
                            $fail(__("Category does not exists in our records"));
                        else
                            if($value != 0)
                                $filters[] = [__('Category'), Cache::rememberForever('category-name-by-id-' . $value, function() use ($value) { return __(Category::find($value)->category); }), 'category'];
                    } else
                        if($value != 0)
                            $fail(__("You have to select all categories in case of all forums search"));
                },
            ],
            'threads-date-filter'=> [
                'sometimes',
                Rule::in(['anytime', 'past24hours', 'pastweek', 'pastmonth', 'pastyear']),
            ],
            'sorted-by'=>[
                'sometimes',
                Rule::in(['created_at_desc', 'created_at_asc', 'views', 'votes', 'likes']),
            ]
        ], [
            'threads-date-filter.in'=>__('The selected date filter is invalid'),
            'sorted-by.in'=>__('The selected sort filter is invalid')
        ]);

        $keyword = '';
        if($request->has('k'))
            $keyword = $data['k'];
        
        // 1. First fetch threads based on search query
        $threads = $this->srch(Thread::query(), $keyword, ['subject', 'content'], ['LIKE', 'LIKE']);
        if($request->has('tab')) {
            $tab = $request->validate(['tab'=>Rule::in(self::TAB_WHITE_LIST)])['tab'];
            switch($tab) {
                case 'today':
                    $threads = $threads->today();
                    $tab_title = __('Today');
                    break;
                case 'thisweek':
                    $threads = $threads->where(
                        'created_at', 
                        '>=', 
                        Carbon::now()->subDays(7)->setTime(0, 0)
                    );
                    $tab_title = __('This week');
                    break;
            }
        }

        /**
         * In case $data['forum'] does not set or in case it is set and == all we don't
         * have to add any condition to the builder
         */
        if(isset($data['forum']) && ($forumslug = $data['forum']) != 'all') {
            if(isset($data['category']) && ($cid = $data['category']) != 0)
                $threads = $threads->where('category_id', $cid);
            else {
                $categories_ids = Cache::rememberForever('forum-categories-ids-by-slug-' . $forumslug, function() use ($forumslug) {
                    return Forum::where('slug', $forumslug)->first()->categories()->pluck('id');
                })->toArray();

                $threads = $threads->whereIn('category_id', $categories_ids);
            }
        }

        // 3. check if user choose only ticked threads
        if(isset($request->tickedposts)) {
            $tickedposts_filter = $this->validate(
                $request, 
                ['tickedposts'=>[Rule::in(['on', 'off'])]],
                ['tickedposts.in'=>__('The selected ticked posts filter is invalid')]
            )['tickedposts'];
            if($tickedposts_filter == 'on') {
                $filters[] = [__('Ticked posts'), __('on'), 'tickedposts'];
                $threads = $threads->ticked(); // ticked() here is a scope defined in thread model to allow us to fetch only ticked threads
            }
        }

        //4. thread date check
        if(isset($data['threads-date-filter'])) {
            $datefilter = '';
            switch($data['threads-date-filter']) {
                case 'past24hours':
                    $datefilter = __('Past 24 hours');
                    $threads = $threads->where("created_at",">=",Carbon::now()->subDay(1));
                    break;
                case 'pastweek':
                    $datefilter = __('Last week');
                    $threads = $threads->where("created_at",">",Carbon::now()->subDays(7));
                    break;
                case 'pastmonth':
                    $datefilter = __('Last month');
                    $threads = $threads->where("created_at",">",Carbon::now()->subMonth());
                    break;
            }

            if($data['threads-date-filter'] != 'anytime')
                $filters[] = [__('Date'), $datefilter, 'threads-date-filter'];
        }

        if(isset($data['sorted-by'])) {
            $sortfilter = '';

            switch($data['sorted-by']) {
                case 'created_at_desc':
                    $threads = $threads->orderBy('created_at', 'desc');
                    break;
                case 'created_at_asc':
                    $sortfilter = __('creation date (old to new)');
                    $threads = $threads->orderBy('created_at');
                    break;
                case 'views':
                    $sortfilter = __('views');
                    $threads = $threads->orderBy('view_count', 'desc');
                    break;
                case 'votes':
                    $sortfilter = __('votes');

                    $threads = $threads->withCount(['votes as votesvalue'=>function($query) {
                        $query->select(DB::raw('sum(vote)'));
                    }])->orderBy('votesvalue', 'desc');
                    break;
                case 'likes':
                    $sortfilter = __('likes');
                    $threads = $threads->withCount('likes')->orderBy('likes_count', 'desc');
                    break;
            }

            if($sortfilter != '')
                $filters[] = [__('Sort by'), $sortfilter, 'sorted-by'];
        } else
            $threads = $threads->orderBy('created_at', 'desc');

        $threads = $threads->paginate($pagesize);

        return view('search.search-threads')
            ->with(compact('filters'))
            ->with(compact('threads'))
            ->with(compact('pagesize'))
            ->with(compact('tab'))
            ->with(compact('tab_title'))
            ->with(compact('keyword'));
    }

    public function threads_search(Request $request) {
        $keyword = "";
        $tab = 'all';
        $tab_title = __('All');
        $pagesize = 10;
        if($request->has('pagesize'))
            $pagesize = $request->validate(['pagesize'=>['numeric', Rule::in([6, 10, 16])]])['pagesize'];

        if($request->has('k'))
            $keyword = $request->validate(['k'=>'max:2000'])['k'];
        
        $threads = $this->srch(Thread::query(), $keyword, ['subject', 'content'], ['LIKE', 'LIKE']);

        if($request->has('tab')) {
            $tab = $request->validate(['tab'=>Rule::in(self::TAB_WHITE_LIST)])['tab'];
            switch($tab) {
                case 'today':
                    $threads = $threads->today();
                    $tab_title = __('Today');    
                    break;
                case 'thisweek':
                    $threads = $threads->where('created_at', '>=', Carbon::now()->subDays(7)->setTime(0, 0));
                    $tab_title = __('This week');
                    break;
            }
        }

        $threads = $threads->orderBy('view_count', 'desc')->orderBy('created_at', 'desc')->paginate($pagesize);

        return view('search.search-threads')
            ->with(compact('tab'))
            ->with(compact('threads'))
            ->with(compact('pagesize'))
            ->with(compact('tab_title'))
            ->with(compact('keyword'));
    }

    public function users_search(Request $request) {
        $keyword = "";
        if($request->has('k'))
            $keyword = $request->validate(['k'=>'max:2000'])['k'];

        $users = $this->srch(
            User::query()->excludedeactivatedaccount(), $keyword, 
            ['firstname', 'lastname', 'username'], ['LIKE', 'LIKE', 'LIKE']
        )->orderBy('username', 'asc')->paginate(8);

        return view('search.search-users')
            ->with(compact('users'))
            ->with(compact('keyword'));
    }

    /**
     * The reason behind implement search using eloquent is that because I have defined several scopes to several
     * models and at run time we don't knowthe scopes of each table
     * Search with Query builder will search without checking any scope. eg: soft deleted records or deactivated users will also returned by the search
     * and that's because we are using eloquet to do so.
     * 
     * $builder now will hold the query builder of passed model with all its scopes. 
     * eg: eloquent_search(Thread::query(), 'foo boo', ...) will hold Thread builder with all
     * its scopes to allowing us to return the results filtered
     * 
     * NOTICE: local scopes should be passed along with the query builder.
     *      eg: srch(User::query()->excludedeactivatedaccount(), $search_query, ...)
     */
    private function srch(Builder $builder, $search_query, $columns, $operators) {
        $keywords = array_filter(explode(' ', $search_query));

        if($search_query == "") return $builder;

        if(count($operators) != count($columns))
            throw new SearchException('number of operators should be the same as number of columns');

        /**
         * First search for the whole search_query
         */
        $builder = $builder->where(function($bld) use($columns, $operators, $search_query) {
            for($i=0; $i < count($columns); $i++) {
                if($i == 0) {
                    if(strtolower($operators[$i])=='like') $search_query = "%$search_query%";
                    $bld = $bld->where($columns[$i], $operators[$i], $search_query);
                    continue;
                }

                $bld = $bld->orWhere($columns[$i], $operators[$i], $search_query);
            }
        });

        /**
         * If search query has only one keyword; It means it is already processed by the previous where.
         * If It has more than 1 keywords meaning we have already appended wheres to the builder of whole search query
         * and in this case we have to use orWhere
         */
        if(count($keywords) > 1) {
            $builder = $builder->orWhere(function($bld) use($columns, $operators, $keywords) {
                for($i=0; $i < count($columns); $i++) {
                    foreach($keywords as $keyword) {
                        if(strtolower($operators[$i]) == 'like') $keyword = "%$keyword%";
                        $bld = $bld->orWhere($columns[$i], $operators[$i], $keyword);
                    }
                }
            });
        }

        return $builder->orderByRaw("CASE WHEN $columns[0] LIKE ? then 1 else 0 end DESC", [$search_query]);
    }
}
