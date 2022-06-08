<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{Forum, Category, ForumStatus, CategoryStatus, ThreadStatus};
use Carbon\Carbon;
use App\View\Components\Admin\Forumsandcategories\{ForumSection, CategoriesSection};

class ForumAndCategoryController extends Controller
{
    public function dashboard(Request $request) {
        $forums = Forum::withoutGlobalScopes()->excludearchived()->with('status')->get();
        $firstforum = $forums->first();

        return view('admin.forums-and-categories.dashboard')
        ->with(compact('forums'))
        ->with(compact('firstforum'))
        ;
    }

    public function select_forum($forum) {
        $forum = Forum::withoutGlobalScopes()->find($forum);
        $forumsection = (new ForumSection($forum));
        $forumsection = $forumsection->render(get_object_vars($forumsection))->render();

        $categoriessection = (new CategoriesSection($forum));
        $categoriessection = $categoriessection->render(get_object_vars($categoriessection))->render();

        return [
            'forumsection'=>$forumsection,
            'categoriessection'=>$categoriessection
        ];
    }

    public function add_forum() {
        $can_add_forum = auth()->user()->can('add_forum', [Forum::class]);
        $issuperadmin = auth()->user()->isSuperadmin();
        return view('admin.forums-and-categories.forums.add')
            ->with(compact('can_add_forum'))
            ->with(compact('issuperadmin'))
            ;
    }

    public function store_forum(Request $request) {
        $data = $this->validate($request, [
            'forum'=>'required|min:2|max:180|unique:forums,forum',
            'slug'=>'required|min:2|max:180|unique:forums,slug',
            'description'=>'required|min:10|max:2000',
            'icon'=>'sometimes|max:6000',
        ],
        [
            'forum.unique'=>'The forum name is already taken',
            'slug.unique'=>'The forum slug is already taken',
        ]);
        $this->authorize('store_forum', [Forum::class, $data]);
        /**
         * If icon is not submitted either because admin let reviewers set it, or he doesn't have permission
         * then we use the default icon (rocket svg icon)
         */
        if(!isset($data['icon']))
            $data['icon'] = '<path d="M177.77,265.66c-25.43,0-49.33,0-73.22,0a24.55,24.55,0,0,1-9.16-1.37c-9.9-3.91-14.06-14.5-9-24.83,11.68-23.91,23.37-47.82,35.79-71.35,6.82-12.94,18.36-19.72,33.27-19.78,23.1-.09,46.19-.11,69.29.06,3.53,0,5.56-1.06,7.47-4,13-20.22,28.06-38.66,46.79-53.91,29-23.62,62.56-34.66,99.65-35.73,20.84-.6,41.58.33,62.08,4.41C450,61,452.4,63.21,454.08,72.76c5.62,31.86,7,63.85.24,95.66-7.77,36.79-27.87,66.21-56.19,90.37A231.63,231.63,0,0,1,369,280.38c-3.28,2-4.15,4.25-4.13,7.89.16,22.77,0,45.54.1,68.3,0,16.89-7.39,29-22.56,36.54-22.07,11-44,22.17-66.08,33.18-14.8,7.4-27.72-.67-27.74-17.26q0-33.66,0-67.32v-4.8l-1.21-.92c-4.28,4.56-8.46,9.24-12.87,13.68-12.39,12.47-25.68,12.43-38.08,0Q179.7,333,163,316.33c-11.08-11.16-11.11-24.93-.11-36C167.5,275.73,172.16,271.2,177.77,265.66ZM394,148.46a29.11,29.11,0,1,0-29,29A28.9,28.9,0,0,0,394,148.46Z" style="fill:#010101"/><path d="M129.87,331.66c22.7,0,40.25,11.56,47.84,29.58a48.11,48.11,0,0,1-10.48,52.59c-4.92,4.93-11,8.15-17.2,11.18-26.91,13.22-55.36,22.33-83.88,31.23-6.43,2-11.43-3.58-9.37-10.56,3-10.17,6.28-20.27,9.75-30.29,7-20.36,14.24-40.69,24.81-59.59C100.43,339.56,114.91,332.52,129.87,331.66Z"/>';

        $data['created_by'] = auth()->user()->id;
        $data['status_id'] = ForumStatus::where('slug', 'under-review')->first()->id;

        $forum = Forum::create($data);

        return route('admin.forum.and.categories.dashboard') . '?selectforum=' . $forum->id;
    }

    public function manage_forum(Request $request) {
        $forums = collect([]); // used to select a forum to manage
        $forum = $fstatus = null; // Chosen forum to manage
        $canupdate = $canapprove = $issuperadmin = $canupdatestatus = $canignore = false;
        
        if($request->has('forumid')) {
            $forum = Forum::withoutGlobalScopes()->find($request->get('forumid'));
            if($forum) {
                $fstatus = $forum->status;
                $canupdate = auth()->user()->can('edit_forum', [Forum::class]);
                $canupdatestatus = auth()->user()->can('able_to_update_forum_status', [Forum::class]);
                $canapprove = auth()->user()->can('able_to_approve_forum', [Forum::class]);
                $canignore = auth()->user()->can('able_to_ignore_forum', [Forum::class]);
                $issuperadmin = auth()->user()->isSuperadmin();
            }
        }

        if(!$forum)
            $forums = Forum::withoutGlobalScopes()->excludearchived()->with('status')->get();

        return view('admin.forums-and-categories.forums.manage')
            ->with(compact('canupdate'))
            ->with(compact('canupdatestatus'))
            ->with(compact('canapprove'))
            ->with(compact('canignore'))
            ->with(compact('issuperadmin'))
            ->with(compact('forum'))
            ->with(compact('fstatus'))
            ->with(compact('forums'))
        ;
    }

    public function approve_forum(Request $request) {
        $data = $this->validate($request, [
            'fid'=>'required|exists:forums,id',
            'categories'=>'required',
            'categories.*'=>'exists:categories,id', // categories to approve along with forum
            'status'=>[ // Status of forum after approving
                'required',
                Rule::in(['live', 'closed']),
            ],
        ], [
            'fid.required'=>'Error : forum is required',
            'fid.exists'=>'Forum does not exist in our system',
            'categories.required'=>'You need to select at least one category to approve along with forum',
            'categories.*.exists'=>'One of the selected categories does not exist in our system',
            'status.in'=>'Status of forum after approve is invalid'
        ]);

        $forum = Forum::withoutGlobalScopes()->find($data['fid']);
        $this->authorize('approve_forum', [Forum::class, $forum]);

        // We check if the forum has announcements category and fetch it
        $announcements_category = $forum->categories()->withoutGlobalScopes()->where('slug', 'announcements')->first();
        if(is_null($announcements_category))
            abort(422, "The forum doesn't have announcements category. You have to create it to be able to approve this forum");

        /**
         * Here we get all the selected categories (ids) and then use them to check if they all exists in forum categories
         * and get all categories based on these ids
         * The reason why we fetch them from forum because we want to check if those ids of categories are for categories
         * belongs to the forum or not; to check that we compare the result count of fetch along with the array length  of ids
         * If number of categories fetched is less than the number of ids fetched from request, this means the admin
         * involve a category which is not belong to the forum; here we have to raise an error.
         * Notice that we pushed the announcements category separately because it
         * doesn't exists in the selection. (announcements category should be approved whether the user
         * choose to or not.)
         */
        $categories = $forum->categories()->withoutGlobalScopes()->whereIn('id', $data['categories'])->get();
        if($categories->count() < count($data['categories']))
            abort(422, "One of the selected categories does not belong to the approved forum or does not exist at all");

        $categories->push($announcements_category);

        /**
         * Right now all the checks are true which means we are ready to approve the forum
         * First we update the status of forum from under review to the specified status after approving
         * Then we specify the admin (super admin or above) who approve the forum which is the current user
         */
        $forum->update([
            'status_id' => ForumStatus::where('slug', $data['status'])->first()->id,
            'approved_by'=>auth()->user()->id
        ]);
        
        // After that, we make all selected categories live
        $category_live_status = CategoryStatus::where('slug', 'live')->first()->id;
        foreach($categories as $category) {
            $category->update([
                'status_id' => $category_live_status,
                'approved_by'=>auth()->user()->id
            ]);
        }

        $ccount = $categories->count();
        \Session::flash('message', "Forum \"$forum->forum\" has been approved successfully alogn with $ccount categories.");
        return route('admin.forum.and.categories.dashboard') . '?selectforum=' . $forum->id;
    }

    public function ignore_forum(Request $request) {
        $data = $this->validate($request, [
            'fid'=>'required|exists:forums,id'
        ], [
            'fid.required'=>'Forum is required'
        ]);

        $forum = Forum::withoutGlobalScopes()->find($data['fid']);
        $this->authorize('ignore_forum', [Forum::class, $forum]);

        // First we delete categories
        foreach($forum->categories()->withoutGlobalScopes()->get() as $category) {
            $category->forceDelete();
        }
        // Then we delete the forum
        $forum->forceDelete();

        \Session::flash('message', "Forum under review : \"$forum->forum\" has been deleted (ignored) successfully.");
        return route('admin.forum.and.categories.dashboard');
    }

    public function update_forum(Request $request, $forum) {
        $this->authorize('update_forum', [Forum::class]);

        $forum = Forum::withoutGlobalScopes()->find($forum);
        $data = $request->validate([
            'forum'=>'required|min:2|max:180|unique:forums,forum,' . $forum->id,
            'slug'=>'required|min:2|max:180|unique:forums,slug,' . $forum->id,
            'description'=>'required|min:10|max:2000',
            'icon'=>'present|max:6000|nullable', // We use present because if the super admin clear icon, it should be cleared from db too by setting icon value to null
        ]);

        $fname = $forum->forum; // Here we use this in message because we need the old name (in case the admin change the name)
        $forum->update($data);
        \Session::flash('message', "Forum : \"$fname\" informations has been updated successfully.");
    }

    public function update_forum_status(Request $request, $forum) {
        $data = $request->validate([
            'status'=>'required|exists:forum_status,slug|not_in:under-review'
        ]);
        $forum = Forum::withoutGlobalScopes()->find($forum);
        $this->authorize('update_forum_status', [Forum::class, $forum, $data['status']]);

        $fstatus = ForumStatus::where('slug', $data['status'])->first();
        $forum->update(['status_id'=>$fstatus->id]);

        \Session::flash('status-updated', "Forum status has been updated successfully => \"$fstatus->status\".");
    }

    public function forum_archive_page(Request $request) {
        $forum = $fstatus = null;
        $statistics = [];
        $canarchive = false;
        $forums = $categories = collect([]);
        if($request->has('forumid')) {
            $forum = Forum::withoutGlobalScopes()->find($request->get('forumid'));

            if($forum) {
                $canarchive = auth()->user()->can('able_to_archive_forum', [Forum::class]);
                $fstatus = $forum->status;
                $categories = $forum->categories()->withoutGlobalScopes()->with(['status'])->get();

                $statistics['threadscount'] = $forum->threads()->withoutGlobalScopes()->count();
                $statistics['postscount'] = $forum->posts()->withoutGlobalScopes()->count();
                $statistics['threadsvotescount'] = $forum->threadsvotes()->withoutGlobalScopes()->count();
                $statistics['postsvotescount'] = $forum->postsvotes()->withoutGlobalScopes()->count();
                $statistics['threadslikescount'] = $forum->threadslikes()->withoutGlobalScopes()->count();
                $statistics['postslikescount'] = $forum->postslikes()->withoutGlobalScopes()->count();
            }
        }

        if(!$forum)
            /**
             * Here you noticed that we dont escape global scopes because we don't want to display already archived forums
             * and under review forums could not be archived because they need to be approved first
             */
            $forums = Forum::with('status')->get();

        return view('admin.forums-and-categories.forums.archive')
            ->with(compact('forum'))
            ->with(compact('categories'))
            ->with(compact('fstatus'))
            ->with(compact('canarchive'))
            ->with(compact('statistics'))
            ->with(compact('forums'));
    }

    public function archive_forum(Request $request) {
        $data = $request->validate([
            'fid'=>'required|exists:forums,id'
        ]);
        $forum = Forum::withoutGlobalScopes()->find($data['fid']);

        $this->authorize('archive_forum', [Forum::class, $forum]);

        $categories = $forum->categories()->withoutGlobalScopes()->get();
        /**
         * To archive a forum, we archive all its categories, and then we change its status to
         * archived, and finally soft delete it.
         */
        foreach($categories as $category) {
            $this->carchive($category);
        }

        $forum->update(['status_id'=>ForumStatus::where('slug', 'archived')->first()->id]);
        $forum->delete();

        \Session::flash('message', "Forum : \"$forum->forum\" has been archived successfully. Please make sure it is archived by checking it in <a href='" .  route('admin.archives.forums') . "' class=\"blue bold no-underline\">admin archives</a> page.");
        return route('admin.forum.and.categories.dashboard') . '?selectforum=' . $forum->id;
    }

    public function restore_forum_page(Request $request) {
        $canrestore = false;
        $forum = $status = null;
        $forums = $categories = collect([]);
        $statistics = [];

        if($request->has('forumid')) {
            $forum = Forum::withoutGlobalScopes()->find($request->get('forumid'));
            if($forum) {
                $status = $forum->status;
                $categories = $forum->categories()->withoutGlobalScopes()->excludeannouncements()->get();
                $canrestore = auth()->user()->can('able_to_restore_forum', [Forum::class, $forum]);

                $statistics['threadscount'] = $forum->threads()->withoutGlobalScopes()->count();
                $statistics['postscount'] = $forum->posts()->withoutGlobalScopes()->count();
                $statistics['threadsvotescount'] = $forum->threadsvotes()->withoutGlobalScopes()->count();
                $statistics['postsvotescount'] = $forum->postsvotes()->withoutGlobalScopes()->count();
                $statistics['threadslikescount'] = $forum->threadslikes()->withoutGlobalScopes()->count();
                $statistics['postslikescount'] = $forum->postslikes()->withoutGlobalScopes()->count();
            } else
                $forum = null;
        }

        if(is_null($forum)) 
            $forums = Forum::withoutGlobalScopes()
                    ->where('status_id', ForumStatus::where('slug', 'archived')->first()->id)
                    ->get();

        return view('admin.forums-and-categories.forums.restore')
            ->with(compact('forum'))
            ->with(compact('status'))
            ->with(compact('categories'))
            ->with(compact('canrestore'))
            ->with(compact('statistics'))
            ->with(compact('forums'));
    }

    public function restore_forum(Request $request) {
        $data = $this->validate($request, [
            'fid'=>'required|exists:forums,id',
            'categories_to_restore'=>'required',
            'categories_to_restore.*'=>'exists:categories,id',
            'status_after_restore'=> [
                'required',
                Rule::in(['live', 'closed'])
            ]
        ], [
            'categories_to_restore.*.exists'=>'One of the selected categories does not exist in our system'
        ]);
        
        $forum = Forum::withoutGlobalScopes()->find($data['fid']);
        $this->authorize('restore_forum', [Forum::class, $forum]);

        // First we get the category(is) to be restored along with forum and restore them
        $categories = Category::withoutGlobalScopes()->whereIn('id', $data['categories_to_restore'])->get();
        foreach($categories as $category) {
            $this->crestore($category);
        }
        /**
         * Then we restore announcements category (if exists)
         * Notice that we don't have to get announcements category with categories-to-restore in order to
         * restore it. Announcements category is restored by default when a forum is restored
         */
        $announcements = $forum->categories()->withoutGlobalScopes()->where('slug', 'announcements')->first();
        if($announcements) $this->crestore($announcements);

        // Then we restore the forum
        $forum_status_after_restore = ForumStatus::where('slug', $data['status_after_restore'])->first();
        $forum->restore();
        // We set the status
        $forum->update(['status_id'=>$forum_status_after_restore->id]);

        \Session::flash('message', "The forum $forum->forum has been restored successfully. (Its status is set to " . $forum_status_after_restore->status . ")");
        return route('admin.forum.and.categories.dashboard') . '?selectforum=' . $forum->id;
    }

    // ========= CATEGORY MANAGEMENT =========

    public function add_category(Request $request) {
        $canadd = $issuperadmin = false;
        $forum = null;
        $forums = collect([]);
        $categories = collect([]); // Categories of forum selected if the admin select
        if($request->has('forumid')) {
            $forum = Forum::withoutGlobalScopes()->find($request->get('forumid'));
            if($forum) {
                $canadd = auth()->user()->can('able_to_store', [Category::class]);
                $issuperadmin = auth()->user()->isSuperadmin();
                $categories = $forum->categories()->withoutGlobalScopes()->with(['status'])->orderBy('status_id')->get();
            }
        }
        
        if(!$forum)
            $forums = Forum::withoutGlobalScopes()->with(['status'])->excludearchived()->get();
        
        return view('admin.forums-and-categories.category.add')
            ->with(compact('forum'))
            ->with(compact('forums'))
            ->with(compact('categories'))
            ->with(compact('canadd'))
            ->with(compact('issuperadmin'))
        ;
    }

    public function store_category(Request $request) {
        // Two forums could have the same category name (or slug like announcements category)
        $data = $request->validate([
            'forum_id'=>'required|exists:forums,id',
            'category'=>'required|min:2|max:180',
            'slug'=>'required|min:2|max:180',
            'description'=>'required|min:10|max:2000',
            'icon'=>'sometimes|max:6000' // sometimes and not present because normal admin could not include icon
        ]);
        $data['status_id'] = CategoryStatus::where('slug', 'under-review')->first()->id;
        $data['created_by'] = auth()->user()->id;

        $this->authorize('store', [Category::class, $data]);

        Category::create($data);
        return route('admin.forum.and.categories.dashboard') . '?selectforum=' . $data['forum_id'];
    }

    public function manage_category(Request $request) {
        $forum = $category = $cstatus = $fstatus = null;
        $canupdate = $canapprove = $canignore = $canupdatestatus = $issuperadmin = false;
        $forums = collect([]);
        if($request->has('categoryid')) {
            $category = Category::withoutGlobalScopes()->find($request->get('categoryid'));
            if($category) {
                $forum = $category->forum()->withoutGlobalScopes()->first();
                $cstatus = $category->status;
                $fstatus = $forum->status;

                $canupdate = auth()->user()->can('able_to_update_category', [Category::class]);
                $canupdatestatus = auth()->user()->can('able_to_update_category_status', [Category::class]);
                $canapprove = auth()->user()->can('able_to_approve_category', [Category::class]);
                $canignore = auth()->user()->can('able_to_ignore_category', [Category::class]);
                $issuperadmin = auth()->user()->isSuperadmin();
            }
        }
        
        if(!$category)
            $forums = Forum::withoutGlobalScopes()->excludearchived()->get();

        return view('admin.forums-and-categories.category.manage')
            ->with(compact('category'))
            ->with(compact('forum'))
            ->with(compact('forums'))
            ->with(compact('cstatus'))
            ->with(compact('fstatus'))
            ->with(compact('canupdate'))
            ->with(compact('canapprove'))
            ->with(compact('canignore'))
            ->with(compact('canupdatestatus'))
            ->with(compact('issuperadmin'))
        ;
    }

    public function update_category(Request $request) {
        $data = $request->validate([
            'cid'=>'required|exists:categories,id',
            'category'=>'required|min:2|max:180',
            'slug'=>'required|min:2|max:180',
            'description'=>'required|min:2|max:2000',
            'icon'=>'present|max:6000|nullable'
        ]);
        $this->authorize('update_category', [Category::class, $data]);
        
        $cid = $data['cid'];
        unset($data['cid']);
        
        Category::withoutGlobalScopes()->find($cid)->update($data);
        \Session::flash('message', 'Category informations has been updated successfully.');
    }

    public function update_category_status(Request $request) {
        $data = $request->validate([
            'cid'=>'required|exists:categories,id',
            'status'=>[
                'required',
                Rule::in(['live', 'closed'])
            ]
        ]);
        $category = Category::withoutGlobalScopes()->find($data['cid']);

        $this->authorize('update_category_status', [Category::class, $category]);

        $category->update([
            'status_id'=>CategoryStatus::where('slug', $data['status'])->first()->id
        ]);
        \Session::flash('status-updated', 'Category status has been updated successfully.');
    }

    public function approve_category(Request $request) {
        $data = $this->validate($request, [
            'cid'=>'required|exists:categories,id',
            'status'=>[
                'required',
                Rule::in(['live', 'closed'])
            ]
        ]);

        $this->authorize('approve_category', [Category::class, $data]);
        
        $category = Category::withoutGlobalScopes()->find($data['cid']);
        $status = CategoryStatus::where('slug', $data['status'])->first();
        
        $category->update([
            'status_id'=>$status->id,
            'approved_by'=>auth()->user()->id
        ]);

        \Session::flash('message', "Category \"$category->category\" has been approved successfully and it is accessible by public users.");
    }

    public function ignore_category(Request $request) {
        $data = $this->validate($request, 
            ['cid'=>'required|exists:categories,id'], 
            ['cid.required'=>'Category is required']);

        $category = Category::withoutGlobalScopes()->find($data['cid']);
        $this->authorize('ignore_category', [Category::class, $category]);

        $category->forceDelete();
        \Session::flash('message', "Category under review : \"$category->category\" has been deleted (ignored) successfully.");
        return route('admin.forum.and.categories.dashboard') . '?selectforum=' . $category->forum_id;
    }

    public function category_archive_page(Request $request) {
        $forum = $category = $creator = $status = $fstatus = null;
        $canarchive = false;
        $forums = $statistics = collect([]);
        if($request->has('categoryid')) {
            $category = Category::withoutGlobalScopes()->find($request->get('categoryid'));
            if($category) {
                $status = $category->status;
                $forum = $category->forum()->withoutGlobalScopes()->first();
                $fstatus = $forum->status;
                $creator = $category->creator;
                $canarchive = auth()->user()->can('able_to_archive_category', [Category::class]);

                $statistics['threadscount'] = $category->threads()->withoutGlobalScopes()->count();
                $statistics['postscount'] = $category->posts()->withoutGlobalScopes()->count();
                $statistics['threadsvotescount'] = $category->threadsvotes()->withoutGlobalScopes()->count();
                $statistics['postsvotescount'] = $category->postsvotes()->withoutGlobalScopes()->count();
                $statistics['threadslikescount'] = $category->threadslikes()->withoutGlobalScopes()->count();
                $statistics['postslikescount'] = $category->postslikes()->withoutGlobalScopes()->count();
            }
        }
        
        if(!$category)
            $forums = Forum::excludearchived()->excludeunderreview()->get();

        return view('admin.forums-and-categories.category.archive')
            ->with(compact('category'))
            ->with(compact('status'))
            ->with(compact('fstatus'))
            ->with(compact('creator'))
            ->with(compact('statistics'))
            ->with(compact('forum'))
            ->with(compact('forums'))
            ->with(compact('canarchive'))
        ;
    }
    public function archive_category(Request $request) {
        $data = $request->validate([
            'cid'=>'required|exists:categories,id'
        ]);
        $category = Category::withoutGlobalScopes()->find($data['cid']);
        $forum = $category->forum()->withoutGlobalScopes()->first();
        $this->authorize('archive_category', [Category::class, $category, $forum]);

        $categoriescount = $forum->categories()->withoutGlobalScopes()->count();

        $this->carchive($category);

        /**
         * Here we want to check if the forum has at least one live category after archiving this category
         * or not, because If all categories are archived or closed after archive this category, we have to close 
         * or archive the forum as well
         * If the forum has no live categories we'll end up with two choices
         *      1. If all categories are archived we archive the forum as well
         *      2. If all categories are closed we close the forum as well
         */
        $categories_status = \DB::select( // This will hold number of categories per status
            "SELECT CS.slug as slug, (SELECT COUNT(*) FROM categories WHERE forum_id = $forum->id AND status_id=CS.id) as occ
            FROM category_status as CS"
        );
        // Then we change the structure of result to associative array (key is status slug and value is number of categories that have the status)
        $cstatus = [];
        foreach($categories_status as $status) {
            $cstatus[$status->slug] = $status->occ;
        }
        /**
         * Example : 
         *  live => 5
         *  closed => 1
         *  under-review => 0
         *  archived => 2
         */
        $message = 'The category "' . $category->category . '" has been archived successfully.';
        if($cstatus['live'] == 1) { // Means only announcements category is there
            if($cstatus['archived'] == $categoriescount-1) {
                $forum->update(['status_id'=>ForumStatus::where('slug', 'archived')->first()->id]);
                $forum->delete();
                $message = 'The category "' . $category->category . '" as well as the whole parent forum "' . $forum->forum . '" has been archived successfully because the archived category was the only accessible category.';
            }
        }
        
        \Session::flash('message', $message);
        return route('admin.forum.and.categories.dashboard') . '?selectforum=' . $forum->id;
    }

    public function restore_category_page(Request $request) {
        $gcategories = collect([]);
        $forum = $category = $creator = $status = null;
        $statistics = [];
        $canrestore = false;
        $message = '';

        if($request->has('categoryid')) {
            $category = Category::withoutGlobalScopes()->find($request->get('categoryid'));

            if($category) {
                $forum = $category->forum()->withoutGlobalScopes()->first();
                $creator = $category->creator;
                $status = $category->status;

                $canrestore = auth()->user()->can('able_to_restore_category', [Category::class]);
                
                $statistics['threadscount'] = $category->threads()->withoutGlobalScopes()->count();
                $statistics['postscount'] = $category->posts()->withoutGlobalScopes()->count();
                $statistics['threadsvotescount'] = $category->threadsvotes()->withoutGlobalScopes()->count();
                $statistics['postsvotescount'] = $category->postsvotes()->withoutGlobalScopes()->count();
                $statistics['threadslikescount'] = $category->threadslikes()->withoutGlobalScopes()->count();
                $statistics['postslikescount'] = $category->postslikes()->withoutGlobalScopes()->count();
            }
        }

        if(!$category) {
            $forum_archived_status_id = ForumStatus::where('slug', 'archived')->first()->id;
            $category_archived_status_id = CategoryStatus::where('slug', 'archived')->first()->id;

            $archivedforums = Forum::withoutGlobalScopes()->where('status_id', $forum_archived_status_id)->pluck('id');
            // We exclude archived categories when the parent forum is archived because we cannot restore a category with archived parent forum
            $gcategories = Category::withoutGlobalScopes()
                ->whereNotIn('forum_id', $archivedforums)
                ->where('status_id', $category_archived_status_id)
                ->get()
                ->groupBy('forum_id');
        }

        return view('admin.forums-and-categories.category.restore')
            ->with(compact('forum'))
            ->with(compact('category'))
            ->with(compact('status'))
            ->with(compact('canrestore'))
            ->with(compact('gcategories'))
            ->with(compact('statistics'))
            ->with(compact('message'));
    }
    public function restore_category(Request $request) {
        $data = $this->validate($request, [
            'cid'=>'required|exists:categories,id',
            'status_after_restore'=>['required', Rule::in(['live', 'closed'])]
        ], ['status_after_restore.required'=>'you must specify the status of category after restoring it', 'status_after_restore.in'=>'Invalide category status']);

        $category = Category::withoutGlobalScopes()->find($data['cid']);
        $forum = $category->forum()->withoutGlobalScopes()->first();
        $this->authorize('restore_category', [Category::class, $category, $forum]);

        $cs = CategoryStatus::where('slug', $data['status_after_restore'])->first()->id;
        $this->crestore($category, $cs);

        \Session::flash('message', 'The category "' . $category->category . '" has been restored successfully.');
        return route('admin.forum.and.categories.dashboard') . '?selectforum=' . $category->forum_id;
    }

    private function carchive($category) {
        /**
         * Concerning notifications, we won't delete notifications on archived threads or replies or anything
         * related to the archived category. Instead we'll handle the action where the user select a notification
         * for an archived thread. e.g. when a user already have a notification on a thread, and then we
         * decide to archive the category.
         * In this case we have to handle thread show page when user click the notification and display a message
         * says that the thread is archived due to category archive (something like that)
         */

        // Archive all threads within the category and then soft delete them
        $category->threads()->update(['status_id'=>ThreadStatus::where('slug', 'archived')->first()->id]);
        $category->threads()->delete();
        // Archive the category itself
        $category->update(['status_id'=>CategoryStatus::where('slug', 'archived')->first()->id]);
        $category->delete();
    }

    private function crestore($category, $status=null) {
        /**
         * Now we have to only restore threads that are live before archiving the category;
         * meaning before deleting (archive) the category, some threads were deleted, and we don't want
         * to restore those threads
         * So in time of deleting threads we only change the status to archived to live threads
         * Now when restoring threads, we'll restore only archived threads
         * We could pass status as second argument to specify the status of category after restoration (see restore_forum)
         */
        // Restore category
        if(is_null($status))
            $category->update(['status_id'=>CategoryStatus::where('slug', 'live')->first()->id]);
        else
            $category->update(['status_id'=>$status]);

        $category->restore();
        // Restore the threads
        $category->threads()->withoutGlobalScopes()->where('status_id', ThreadStatus::where('slug', 'archived')->first()->id)->restore();
        $category->threads()->withoutGlobalScopes()->update(['status_id'=>ThreadStatus::where('slug', 'live')->first()->id]);
    }

    public function get_forum_categories(Request $request) {
        $data = $request->validate([
            'fid'=>'required|exists:forums,id',
            'status_excluded'=>'sometimes',
            'status_excluded.*'=>'exists:category_status,slug'
        ]);
        $forum = Forum::withoutGlobalScopes()->find($data['fid']);
        
        $query = "SELECT `categories`.id, `categories`.category, `category_status`.status 
                FROM categories INNER JOIN category_status
                ON categories.status_id = category_status.id
                WHERE forum_id=$forum->id";

        if(isset($data['status_excluded']))
            foreach($data['status_excluded'] as $se)
                $query .= " AND category_status.slug != '$se'";
        
        $categories = \DB::select($query);

        return [
            'categories'=>$categories,
            'forum'=>$forum->forum
        ];
    }
}
