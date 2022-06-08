<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Classes\Cleaner;
use App\Models\{Forum, ForumStatus, Category, CategoryStatus};
use App\View\Components\Admin\Archives\{DeleteCategoryViewer, DeleteForumViewer};

class ArchivesController extends Controller
{
    public function archived_forums_page() {
        $archived_status_id = ForumStatus::where('slug', 'archived')->first()->id;
        $archivedforums = Forum::withoutGlobalScopes()->with(['approver', 'creator'])->where('status_id', $archived_status_id)->get();
        $candelete = auth()->user()->can('able_to_delete_forum', [Forum::class]);

        return view('admin.forums-and-categories.forums.archives')
        ->with(compact('archivedforums'))
        ->with(compact('candelete'))
        ;
    }

    public function get_forum_delete_viewer(Request $request) {
        $data = $this->validate($request, [
            'fid'=>'required|exists:forums,id'
        ], [
            'fid.required'=>'Forum is required',
            'fid.exists'=>'The selected forum does not exist in our system'
        ]);

        $forum = Forum::withoutGlobalScopes()->find($data['fid']);

        $viewer = (new DeleteForumViewer($forum));
        return $viewer->render(get_object_vars($viewer))->render();
    }

    public function delete_forum(Request $request) {
        $data = $this->validate($request, [
            'fid'=>'required|exists:forums,id'
        ], [
            'fid.required'=>'Forum is required',
            'fid.exists'=>'The selected forum does not exist in our system'
        ]);

        $forum = Forum::withoutGlobalScopes()->find($data['fid']);
        $this->authorize('delete_forum', [Forum::class, $forum]);

        $start = microtime(true);
        // First we get all categories in this forum and destroy them
        $categories = $forum->categories()->withoutGlobalScopes()->get();
        $cids = $categories->pluck('id')->implode(',');
        
        // Then we'll get all threads ids and thei users ids of all threads in forum to clean their medias
        if($cids == '') $threads_ids_and_user_ids = [];
        else $threads_ids_and_user_ids = \DB::select("SELECT id, user_id FROM threads WHERE category_id IN ($cids)");

        // Destroy forum categories :(
        foreach($categories as $category) {
            $this->cdestroy($category);
        }
        // Then we force delete the forum
        $forum->forceDelete();
        // Cleaning after
        Cleaner::clean_orphaned_records(); 
        Cleaner::clean_orphaned_threads_medias($threads_ids_and_user_ids);
        $time = round(microtime(true) - $start, 4);

        \Session::flash('message', "The forum \"$forum->forum\" has been deleted successfully from the system. (time taken: $time seconds)");
    }
    
    public function archived_categories_page() {
        $archived_status_id = CategoryStatus::where('slug', 'archived')->first()->id;
        $archivedcategories = Category::withoutGlobalScopes()->excludeannouncements()->with(['approver', 'creator', 'forum'])->where('status_id', $archived_status_id)->get();
        $candelete = auth()->user()->can('able_to_delete_category', [Category::class]);

        return view('admin.forums-and-categories.category.archives')
        ->with(compact('archivedcategories'))
        ->with(compact('candelete'))
        ;
    }

    public function get_category_delete_viewer(Request $request) {
        $data = $this->validate($request, [
            'cid'=>'required|exists:categories,id'
        ], [
            'cid.required'=>'Category is required',
            'cid.exists'=>'The selected category does not exist in our system'
        ]);

        $category = Category::withoutGlobalScopes()->find($data['cid']);

        $viewer = (new DeleteCategoryViewer($category));
        return $viewer->render(get_object_vars($viewer))->render();
    }

    public function delete_category(Request $request) {
        $data = $this->validate($request, [
            'cid'=>'required|exists:categories,id'
        ], [
            'cid.required'=>'Category is required',
            'cid.exists'=>'The selected category does not exist in our system'
        ]);

        $category = Category::withoutGlobalScopes()->find($data['cid']);
        $forum = $category->forum()->withoutGlobalScopes()->first();
        $this->authorize('delete_category', [Category::class, $category, $forum]);
        /**
         * We prevent admin from deleting a category if it is the only category in the parent forum; (see reason in delete forum viewer)
         * 
         * Notice that all direct related relashioships with thread table will be deleted using cascading;
         * and so we have to deal with polymorphic relationships and relationships that don't have direct relation to threads
         * Notice : After deleting those, you have to delete medias of threads as well;
         * 
         * We have to deal with the following orpahned records after deleting the category and its related threads: 
         *  . likes (both on threads, and posts)
         *  . votes (both on threads, and posts)
         *  . reports (both on threads, and posts)
         *  . warnings (both on threads, and posts)
         *  . strikes (both on threads, and posts)
         *  . notifications disables on threads
         *  . notifications disables on posts of each thread
         *  . Notifications
         * ----------------------------
         * ==> All these cleaning processes will be done in Cleaner class
         */
        $start = microtime(true);
        $threads_ids_and_user_ids = \DB::select("SELECT id, user_id FROM threads WHERE category_id = $category->id");
        $this->cdestroy($category);
        Cleaner::clean_orphaned_records(); // Clean orphaned rows like in : votes, likes, reports ..
        Cleaner::clean_orphaned_threads_medias($threads_ids_and_user_ids); // Clean deleted threads medias from storage
        $time = round(microtime(true) - $start, 4);

        $message = "The category \"$category->category\" has been deleted successfully from the system. (time taken: $time seconds)";

        \Session::flash('message', $message);
    }

    /**
     * Its really important to note that when we force delete all threads through a relationship,
     * deleting event will not fired because the models will not be loaded to memory, and therefore, we have to clean
     * relationship entities manually before deleting the threads
     */
    private function cdestroy($category) {
        $category->threads()->withoutGlobalScopes()->forceDelete();
        $category->forceDelete();
    }
}
