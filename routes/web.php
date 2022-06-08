<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\
    {RolesController, PermissionsController, ForumController,
    CategoryController, ThreadController, PostController, ExploreController,
    IndexController, UserController, OAuthController, ContactController,
    SearchController, FeedbackController, VoteController, FaqsController,
    LikesController, GeneralController, MultilanguageHelperController,
    NotificationController, FollowController, ReportController, ThreadComponentsFetchController,
    PollController};
use App\Http\Controllers\Admin\{AdminUserController, AdminPostController, AdminSearchController, AdminController, 
    AdminThreadController, FeedbackAndMessage, ForumAndCategoryController, ArchivesController, RolesAndPermissions, VisitController};
use App\Http\Controllers\Admin\{AnnouncementController, InternationalizationController, FaqsController as AdminFaqsController};
use App\Models\{User, Thread, Report};
use App\Http\Middleware\{AccountStatusCheck,XssSanitizer};

Route::get('/test', function() {
    $user = User::withTrashed()->find(41);

    dd((new InternationalizationController)->search_for_keys_in_database());

    return 'hello';
});

Route::get('/freepage', function() {
    return view('freepage');
});

Route::middleware(['superadmin'])->group(function() {
    // The following routes are only allowed to super admins
    Route::delete('/admin/forums/under-review/ignore', [ForumAndCategoryController::class, 'ignore_forum']);
    Route::delete('/admin/categories/under-review/ignore', [ForumAndCategoryController::class, 'ignore_category']);
    Route::patch('/admin/forums/approve', [ForumAndCategoryController::class, 'approve_forum']);
    Route::patch('/admin/categories/approve', [ForumAndCategoryController::class, 'approve_category']);
    Route::delete('/admin/categories', [ArchivesController::class, 'delete_category']);
    Route::delete('/admin/forums', [ArchivesController::class, 'delete_forum']);
});

Route::middleware(['admin'])->group(function() {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/dashboard/statistics/fetch', [AdminController::class, 'get_dashboard_statistics']);
    Route::post('/admin/visits/fetch', [VisitController::class, 'fetch_more_visits']);
    Route::post('/admin/visits/filter', [VisitController::class, 'get_filtered_visits']);
    Route::post('/admin/user/visits/filter', [VisitController::class, 'get_user_filtered_visits']);
    Route::get('/admin/authbreaks/all/viewer', [AdminController::class, 'get_athbreaks_viewer']);
    Route::get('/admin/visitors/all/viewer', [VisitController::class, 'get_visitors_viewer']);
    Route::get('/admin/signups/all/viewer', [AdminUserController::class, 'get_newsignups_viewer']);

    Route::get('/admin/visitors/fetchmore', [VisitController::class, 'fetch_more_visitors']);
    Route::get('/admin/newsignups/fetchmore', [AdminUserController::class, 'fetch_more_newsignups']);
    Route::get('/admin/authbreaks/fetchmore', [AdminController::class, 'fetch_more_authbreaks']);

    Route::get('/admin/rap/hierarchy', [RolesAndPermissions::class, 'hierarchy'])->name('admin.rap.hierarchy');
    Route::get('/admin/rap/overview', [RolesAndPermissions::class, 'roles_and_permissions_overview'])->name('admin.rap.overview');
    Route::get('/admin/roles/manage', [RolesAndPermissions::class, 'manage_role_page'])->name('admin.rap.manage.role');
    Route::get('/admin/permissions/manage', [RolesAndPermissions::class, 'manage_permission_page'])->name('admin.rap.manage.permission');
    Route::get('/admin/rap/user/manage', [RolesAndPermissions::class, 'manage_user_roles_and_permissions'])->name('admin.rap.manage.user');

    Route::post('/admin/roles', [RolesAndPermissions::class, 'create_role']);
    Route::post('/admin/permissions', [RolesAndPermissions::class, 'create_permission']);
    Route::patch('/admin/roles', [RolesAndPermissions::class, 'update_role_informations']);
    Route::patch('/admin/permissions', [RolesAndPermissions::class, 'update_permission_informations']);
    Route::post('/admin/roles/grant/to/users', [RolesAndPermissions::class, 'grant_role_to_users']);
    Route::post('/admin/permissions/grant/to/users', [RolesAndPermissions::class, 'grant_permission_to_users']);
    Route::post('/admin/roles/revoke/from/user', [RolesAndPermissions::class, 'revoke_role_from_user']);
    Route::post('/admin/permissions/revoke/from/users', [RolesAndPermissions::class, 'revoke_permission_from_users']);
    Route::post('/admin/roles/attach/permissions', [RolesAndPermissions::class, 'attach_permissions_to_role']);
    Route::post('/admin/roles/detach/permissions', [RolesAndPermissions::class, 'detach_permissions_from_role']);
    Route::delete('/admin/roles', [RolesAndPermissions::class, 'delete_role']);
    Route::delete('/admin/permission', [RolesAndPermissions::class, 'delete_permission']);

    Route::post('/admin/user/permissions/attach', [RolesAndPermissions::class, 'grant_permissions_to_user']);
    Route::post('/admin/user/permissions/detach', [RolesAndPermissions::class, 'revoke_permissions_from_user']);
    Route::post('/admin/user/roles/grant/viewer', [RolesAndPermissions::class, 'grant_role_to_user_viewer']);

    Route::post('/admin/roles/users/search', [RolesAndPermissions::class, 'search_for_users_to_grant_role']);
    Route::post('/admin/roles/users/search/fetchmore', [RolesAndPermissions::class, 'fetch_more_users_to_grant_role']);
    Route::post('/admin/permissions/users/search', [RolesAndPermissions::class, 'search_for_users_to_grant_permission']);
    Route::post('/admin/permissions/users/search/fetchmore', [RolesAndPermissions::class, 'fetch_more_users_to_grant_permissions']);
    Route::post('/admin/users/rap/search', [RolesAndPermissions::class, 'search_for_users_to_manage_rap']);
    Route::post('/admin/users/rap/search/fetchmore', [RolesAndPermissions::class, 'fetch_more_users_to_manage_rap']);

    Route::get('/admin/permissions/viewers/review', [RolesAndPermissions::class, 'permission_review_viewer']);
    Route::get('/admin/roles/viewers/review', [RolesAndPermissions::class, 'role_review_viewer']);
    Route::get('/admin/roles/viewers/revoke', [RolesAndPermissions::class, 'revoke_role_from_user_viewer']);

    Route::post('/announcement', [AnnouncementController::class, 'store']);
    Route::patch('/announcement/{announcement}', [AnnouncementController::class, 'update']);
    Route::post('/admin/announcements/delete/viewer', [AnnouncementController::class, 'delete_viewer']);
    Route::delete('/announcement/{announcement}', [AnnouncementController::class, 'delete']);
    Route::get('/admin/announcements/create', [AnnouncementController::class, 'create'])->name('admin.announcements.create');
    Route::get('/admin/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('admin.announcements.edit');
    Route::get('/admin/announcements/manage', [AnnouncementController::class, 'manage'])->name('admin.announcements.manage');

    Route::get('/admin/reports/review', [ReportController::class, 'review_page'])->name('admin.reports.review');

    Route::get('/admin/reports/{report}/generate', [ReportController::class, 'generate_resource_reports_components']);
    Route::post('/admin/resource/reports/fetchmore', [ReportController::class, 'fetch_more_resource_reports']);
    Route::post('/admin/resource/reports/raw/fetchmore', [ReportController::class, 'fetch_more_resource_raw_reports']);
    Route::post('/admin/reports/bodyviewer/get', [ReportController::class, 'get_report_bodyviewer']);
    Route::get('/admin/reports/thread/{thread_id}/manageviewer', [ReportController::class, 'generate_thread_manage_viewer']);
    Route::get('/admin/reports/post/{post}/manageviewer', [ReportController::class, 'generate_reply_manage_viewer']);
    
    Route::get('/admin/threads/{thread}/component/generate', [AdminThreadController::class, 'generate_thread_component']);
    Route::get('/admin/posts/{post}/render', [AdminPostController::class, 'generate_post_render']);
    Route::get('/admin/threads/{thread}/render', [AdminThreadController::class, 'generate_thread_render']);

    Route::patch('/admin/threads/close', [AdminThreadController::class, 'closethread']);
    Route::patch('/admin/threads/open', [AdminThreadController::class, 'openthread']);
    Route::patch('/admin/threads/restore', [AdminThreadController::class, 'restorethread']);
    Route::patch('/admin/posts/restore', [AdminPostController::class, 'restore']);
    
    Route::delete('/admin/threads/delete', [AdminThreadController::class, 'deletethread']);
    Route::delete('/admin/threads/delete/force', [AdminThreadController::class, 'delete_thread_permanently']);
    Route::delete('/admin/posts/delete', [AdminPostController::class, 'delete_post']);
    Route::delete('/admin/posts/delete/force', [AdminPostController::class, 'delete_post_permanently']);
    
    Route::post('/admin/users/warn', [AdminUserController::class, 'warn']);
    Route::post('/admin/usersgroup/warn', [AdminUserController::class, 'warn_group']);
    Route::post('/admin/users/strike', [AdminUserController::class, 'strike']);
    Route::post('/admin/usersgroup/strike', [AdminUserController::class, 'strike_group']);
    Route::post('/admin/users/ban', [AdminUserController::class, 'ban_user']);
    Route::post('/admin/users/unban', [AdminUserController::class, 'unban_user']);
    Route::post('/admin/users/bans/clean-expired', [AdminUserController::class, 'clean_expired_ban']);

    Route::delete('/admin/warning', [AdminUserController::class, 'remove_warning']);
    Route::delete('/admin/strike', [AdminUserController::class, 'remove_strike']);

    Route::post('/admin/user/status/set', [AdminUserController::class, 'set_admin_status']);
    Route::patch('/admin/reports/review/patch', [ReportController::class, 'change_resource_reports_review_status']);

    Route::get('/admin/user/manage', [AdminUserController::class, 'manage_user'])->name('admin.user.manage');
    Route::get('/admin/thread/manage', [AdminThreadController::class, 'managethread'])->name('admin.thread.manage');
    Route::get('/admin/post/manage', [AdminPostController::class, 'managepost'])->name('admin.post.manage');

    Route::get('/admin/search/users', [AdminSearchController::class, 'users_search']);
    Route::get('/admin/search/threads', [AdminSearchController::class, 'thread_search']);
    Route::get('/admin/search/post', [AdminSearchController::class, 'post_search']);

    Route::get('/admin/search/threads/fetchmore', [AdminSearchController::class, 'thread_search_fetch_more']);
    Route::get('/admin/search/users/fetchmore', [AdminSearchController::class, 'user_search_fetch_more']);

    Route::get('/admin/resource/check', [AdminUserController::class, 'check_resource']);

    Route::post('/admin/user/threads/review/fetchmore', [AdminThreadController::class, 'generate_threads_review_fetch_more']);
    Route::post('/admin/user/posts/review/fetchmore', [AdminPostController::class, 'generate_posts_review_fetch_more']);
    Route::post('/admin/user/votes/review/fetchmore', [AdminUserController::class, 'fetch_more_user_review_votes']);
    Route::post('/admin/user/visits/review/fetchmore', [VisitController::class, 'fetch_more_user_review_visits']);
    Route::post('/admin/user/authbreaks/review/fetchmore', [AdminUserController::class, 'fetch_more_user_review_authbreaks']);
    Route::post('/admin/user/warnings/review/fetchmore', [AdminUserController::class, 'fetch_more_user_review_warnings']);
    Route::post('/admin/user/strikes/review/fetchmore', [AdminUserController::class, 'fetch_more_user_review_strikes']);
    Route::post('/admin/user/bans/review/fetchmore', [AdminUserController::class, 'fetch_more_user_review_bans']);
    
    Route::get('/admin/users/avatarsviewer', [AdminUserController::class, 'get_avatars_viewer']);
    Route::get('/admin/users/coversviewer', [AdminUserController::class, 'get_covers_viewer']);
    Route::get('/admin/users/threads/review', [AdminUserController::class, 'get_threads_review_viewer']);
    Route::get('/admin/users/posts/review', [AdminUserController::class, 'get_posts_review_viewer']);
    Route::get('/admin/users/votes/review', [AdminUserController::class, 'get_votes_review_viewer']);
    Route::get('/admin/users/visits/review', [AdminUserController::class, 'get_visits_review_viewer']);
    Route::get('/admin/users/authbreaks/review', [AdminUserController::class, 'get_authbreaks_review_viewer']);
    Route::get('/admin/users/warnings/review', [AdminUserController::class, 'get_user_warnings_review_viewer']);
    Route::get('/admin/users/strikes/review', [AdminUserController::class, 'get_user_strikes_review_viewer']);
    
    Route::delete('/admin/users/avatars/delete', [AdminUserController::class, 'delete_avatar']);
    Route::delete('/admin/users/covers/delete', [AdminUserController::class, 'delete_cover']);

    Route::get('/admin/contact/messages', [FeedbackAndMessage::class, 'contactmessages'])->name('admin.contactmessages');
    Route::patch('/admin/contact/messages/{message}/markasread', [FeedbackAndMessage::class, 'mark_message_as_read']);
    Route::patch('/admin/contact/messages/markasread', [FeedbackAndMessage::class, 'mark_all_message_as_read']);
    Route::patch('/admin/contact/messages/markgroupasread', [FeedbackAndMessage::class, 'mark_messages_group_as_read']);
    Route::delete('/admin/contact/messages/group', [FeedbackAndMessage::class, 'delete_messages_group']);
    Route::delete('/admin/contact/feedbacks/group', [FeedbackAndMessage::class, 'delete_feedbacks_group']);
    Route::delete('/admin/contact/messages/{message}', [FeedbackAndMessage::class, 'delete_message']);
    Route::delete('/admin/contact/feedbacks/{feedback}', [FeedbackAndMessage::class, 'delete_feedback']);
    
    Route::get('/admin/contact/messages/fetch', [FeedbackAndMessage::class, 'fetch_more_contact_messages']);
    Route::get('/admin/contact/feedbacks/fetch', [FeedbackAndMessage::class, 'fetch_more_feedbacks']);

    Route::get('/admin/contact/feedbacks', [FeedbackAndMessage::class, 'feedbacks'])->name('admin.feedbacks');
    Route::get('/admin/faqs', [AdminFaqsController::class, 'index'])->name('admin.faqs');
    Route::get('/admin/faqs/fetch-more', [AdminFaqsController::class, 'fetch_more_faqs']);
    Route::patch('/admin/faqs', [AdminFaqsController::class, 'update']);
    Route::patch('/admin/faqs/priorities', [AdminFaqsController::class, 'update_faqs_priorities']);
    Route::delete('/admin/faqs', [AdminFaqsController::class, 'delete']);

    Route::get('/admin/forum-and-categories/dashboard', [ForumAndCategoryController::class, 'dashboard'])->name('admin.forum.and.categories.dashboard');
    
    Route::get('/admin/forum-and-categories/forums/{forum}/select', [ForumAndCategoryController::class, 'select_forum']);
    Route::get('/admin/forums/add', [ForumAndCategoryController::class, 'add_forum'])->name('admin.forum.add');
    Route::post('/admin/forums/add', [ForumAndCategoryController::class, 'store_forum'])->withoutMiddleware([XssSanitizer::class]);
    Route::get('/admin/forums/manage', [ForumAndCategoryController::class, 'manage_forum'])->name('admin.forum.manage');
    Route::patch('/admin/forums/{forum}/patch', [ForumAndCategoryController::class, 'update_forum'])->withoutMiddleware([XssSanitizer::class]);
    Route::patch('/admin/forums/{forum}/status', [ForumAndCategoryController::class, 'update_forum_status']);
    Route::get('/admin/forums/archive', [ForumAndCategoryController::class, 'forum_archive_page'])->name('admin.forum.archive');
    Route::patch('/admin/forums/archive', [ForumAndCategoryController::class, 'archive_forum']);
    Route::get('/admin/forums/restore', [ForumAndCategoryController::class, 'restore_forum_page'])->name('admin.forum.restore');
    Route::patch('/admin/forums/restore', [ForumAndCategoryController::class, 'restore_forum']);

    Route::get('/admin/categories/add', [ForumAndCategoryController::class, 'add_category'])->name('admin.category.add');
    Route::post('/admin/categories/add', [ForumAndCategoryController::class, 'store_category'])->withoutMiddleware([XssSanitizer::class]);
    Route::get('/admin/categories/manage', [ForumAndCategoryController::class, 'manage_category'])->name('admin.category.manage');
    Route::post('/admin/forums/{forum}/categories', [ForumAndCategoryController::class, 'get_forum_categories']);

    Route::patch('/admin/categories/restore', [ForumAndCategoryController::class, 'restore_category']);

    Route::patch('/admin/categories/update', [ForumAndCategoryController::class, 'update_category'])->withoutMiddleware([XssSanitizer::class]);;
    Route::patch('/admin/categories/status', [ForumAndCategoryController::class, 'update_category_status']);
    Route::get('/admin/categories/archive', [ForumAndCategoryController::class, 'category_archive_page'])->name('admin.category.archive');
    Route::patch('/admin/categories/archive', [ForumAndCategoryController::class, 'archive_category']);
    Route::get('/admin/categories/restore', [ForumAndCategoryController::class, 'restore_category_page'])->name('admin.category.restore');
    Route::patch('/admin/categories/restore', [ForumAndCategoryController::class, 'restore_category']);

    Route::get('/admin/archives/forums', [ArchivesController::class, 'archived_forums_page'])->name('admin.archives.forums');
    Route::get('/admin/archives/categories', [ArchivesController::class, 'archived_categories_page'])->name('admin.archives.categories');
    Route::get('/admin/archives/categories/deleteviewer', [ArchivesController::class, 'get_category_delete_viewer']);
    Route::get('/admin/archives/forums/deleteviewer', [ArchivesController::class, 'get_forum_delete_viewer']);

    Route::post('/admin/checkpath', [AdminController::class, 'checkpath']);

    Route::get('/admin/internationalization', [InternationalizationController::class, 'index'])->name('admin.internationalization');
    Route::post('/admin/internationalization/search', [InternationalizationController::class, 'search_for_keys_by_paths']);
    Route::get('/admin/internationalization/lang-file/keys', [InternationalizationController::class, 'get_lang_file_keys']);
    Route::get('/admin/internationalization/db-entries/search', [InternationalizationController::class, 'search_for_keys_in_database']);
});

Route::post('/setlang', [GeneralController::class, 'setlang']);

/** AUTO-FETCHING */
Route::get('/index/threads/loadmore', [ThreadComponentsFetchController::class, 'index_load_more']);
Route::get('/forums/{forum}/threads/loadmore', [ThreadComponentsFetchController::class, 'forum_threads_load_more']);
Route::get('/forums/{forum}/categories/{category}/threads/loadmore', [ThreadComponentsFetchController::class, 'category_threads_load_more']);
Route::get('/users/{user}/threads/loadmore', [ThreadComponentsFetchController::class, 'profile_threads_load_more']);
Route::get('/explore/loadmore', [ExploreController::class, 'explore_more']);

Route::get('/forums/{forum}/categories', [GeneralController::class, 'get_forum_categories']);
Route::get('/threads/{thread}/viewer_infos_component', [ThreadController::class, 'view_infos_component']);
Route::get('/thread/viewer/posts/fetchmore', [ThreadController::class, 'fetch_more_viewer_posts']);
Route::post('/thread/poll/fetch-remaining-options', [ThreadController::class, 'fetch_thread_poll_remaining_options']);
Route::post('/thread/poll/raw-fetch-remaining-options', [ThreadController::class, 'fetch_raw_thread_poll_remaining_options']);
Route::get('/users/{user}/activities/sections/generate', [ThreadController::class, 'generate_section_range']);
Route::get('/users/{user}/card/generate', [GeneralController::class, 'generate_user_card']);

Route::post('/contact', [ContactController::class, 'store_contact_message']);
Route::post('/faqs', [FaqsController::class, 'store']);

Route::get('/user/followers/viewer', [FollowController::class, 'get_followers_viewer']);
Route::get('/user/follows/viewer', [FollowController::class, 'get_follows_viewer']);
Route::get('/users/followers/fetchmore', [FollowController::class, 'fetch_more_followers']);
Route::get('/users/follows/fetchmore', [FollowController::class, 'fetch_more_follows']);
Route::get('/users/follower/component/generate', [FollowController::class, 'generate_follower_component']);

Route::middleware(['auth'])->group(function () {
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::patch('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

    Route::post('/notifications/get-disables-by-type', [NotificationController::class, 'get_notification_disables_by_type']);
    Route::post('/notifications/markasread', [NotificationController::class, 'mark_as_read']);
    Route::patch('/notifications/group/markasread', [NotificationController::class, 'mark_group_of_notifications_as_read']);
    Route::post('/notifications/{notification}/markasread', [NotificationController::class, 'mark_single_notification_as_read']);
    Route::post('/notification/generate', [NotificationController::class, 'notification_generate']);
    Route::get('/notifications/bootstrap', [NotificationController::class, 'generate_header_notifications_bootstrap']);
    Route::get('/notifications/generate', [NotificationController::class, 'notification_generate_range']);
    Route::get('/notifications/statement/{slug}/get', [NotificationController::class, 'get_notification_statement']); // blnotification : bottom-left notification component
    Route::post('/notification/{id}/disable', [NotificationController::class, 'disable']);
    Route::post('/notification/{id}/enable', [NotificationController::class, 'enable']);
    // This following route is the same as the former one, except the parameter passed is disable_id instead of notif id
    Route::post('/notifications/disables/enable', [NotificationController::class, 'enablev1']);
    Route::delete('/notification/{notification_id}/delete', [NotificationController::class, 'destroy']);

    Route::get('/user/update_last_activity', [GeneralController::class, 'update_user_last_activity']);

    Route::post('/users/follow', [FollowController::class, 'follow_user']);
    
    Route::get('/threads/{thread}/component/generate', [ThreadController::class, 'generate_thread_component']);
    Route::get('/generatequickaccess', [GeneralController::class, 'generate_quickaccess']);
    Route::get('/thread/add/faded/fetch', [GeneralController::class, 'generate_thread_add_faded']);
    Route::get('/thread/add/component/fetch', [GeneralController::class, 'generate_thread_add_component']);
    
    Route::post('/thread', [ThreadController::class, 'store']);
    Route::patch('/thread/visibility/patch', [ThreadController::class, 'update_visibility']);
    Route::patch('/thread/{thread}', [ThreadController::class, 'update']);
    Route::delete('/thread/{thread}', [ThreadController::class, 'delete'])->name('thread.delete');
    Route::post('/thread/{thread}/report', [ReportController::class, 'thread_report']);
    Route::post('/post/{post}/report', [ReportController::class, 'post_report']);
    Route::post('/thread/{thread}/save', [ThreadController::class, 'thread_save_switch']);
    Route::delete('/thread/delete/force', [ThreadController::class, 'destroy'])->name('thread.destroy');
    Route::post('/thread/restore', [ThreadController::class, 'restore'])->name('thread.restore');
    Route::post('/thread/posts/switch', [ThreadController::class, 'thread_posts_switch'])->name('thread.posts.turn.off');
    Route::patch('/thread/posts/untick', [ThreadController::class, 'untick_thread']);
    
    Route::post('/post', [PostController::class, 'store']);
    Route::patch('/post', [PostController::class, 'update']);
    Route::delete('/post', [PostController::class, 'delete']);
    Route::get('/post/content/fetch', [PostController::class, 'post_raw_content_fetch']);
    Route::get('/post/content/parsed/fetch', [PostController::class, 'post_parsed_content_fetch']);
    Route::get('/post/{post}/show/generate', [PostController::class, 'thread_show_post_generate']);
    Route::get('/post/{post}/viewer/generate', [PostController::class, 'thread_viewer_post_generate']);
    Route::post('/post/{post}/tick', [PostController::class, 'tick']);

    Route::post('/options', [PollController::class, 'add_option']);
    Route::post('/options/vote', [PollController::class, 'option_vote']);
    Route::delete('/options/delete', [PollController::class, 'option_delete']);
    Route::get('/options/{option}/component/generate', [PollController::class, 'get_poll_option_component']);

    Route::post('/settings/profile', [UserController::class, 'update']);
    Route::patch('/settings/personal', [UserController::class, 'update_personal']);
    Route::post('/settings/password/set', [UserController::class, 'set_password']);
    Route::patch('/settings/password/update', [UserController::class, 'update_password']);
    Route::patch('/settings/account/deactivate', [UserController::class, 'deactivate_account']);
    Route::delete('/user/delete', [UserController::class, 'delete_account']);

    Route::post('/resource/simple-render', [GeneralController::class, 'resource_simple_render']);

    Route::post('/forums/fetchmore', [ForumController::class, 'fetch_more_forums']);
    Route::post('/user/warnings/fetchmore', [UserController::class, 'fetch_more_user_warnings']);
    Route::post('/user/strikes/fetchmore', [UserController::class, 'fetch_more_user_strikes']);

    Route::get('/settings/account/activate', [UserController::class, 'activate_account_page'])->name('user.account.activate')->withoutMiddleware([AccountStatusCheck::class]);
    Route::patch('/settings/account/activate', [UserController::class, 'activate_account'])->withoutMiddleware([AccountStatusCheck::class]);

    Route::post('/thread/like', [LikesController::class, 'thread_like']);
    Route::post('/post/like', [LikesController::class, 'post_like']);

    Route::post('/thread/vote', [VoteController::class, 'thread_vote'])->name('thread.vote');
    Route::post('/post/vote', [VoteController::class, 'post_vote'])->name('post.vote');
});

Route::get('/login/{provider}', [OAuthController::class, 'redirectToProvider']);
Route::get('/{provider}/callback', [OAuthController::class, 'handleProviderCallback']);

Route::get('/users/{user}/activities/sections/{section}/generate', [ThreadController::class, 'generate_section']);
Route::post('/users/username/check', [UserController::class, 'username_check']);

Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.save');
Route::post('/emojifeedback', [FeedbackController::class, 'store_emojifeedback'])->name('feedback.emoji.save');

Route::middleware(['visitlog'])->group(function(){
    Route::get('/', [IndexController::class, 'index'])->name('home.slash');
    Route::get('/home', [IndexController::class, 'index'])->name('home');
    Route::get('/forums', [IndexController::class, 'forums'])->name('forums');
    Route::get('/forums/{forum:slug}', [ThreadController::class, 'forum_all_threads'])->name('forum.all.threads');
    Route::get('/explore', [ExploreController::class, 'explore'])->name('explore');
    /** Search routes */
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::get('/search/advanced', [SearchController::class, 'search_advanced'])->name('advanced.search');
    Route::get('/search/advanced/results', [SearchController::class, 'search_advanced_results'])->name('advanced.search.results');
    Route::get('/threads/search', [SearchController::class, 'threads_search'])->name('threads.search');
    Route::get('/users/search', [SearchController::class, 'users_search'])->name('users.search');
    Route::get('/announcements', [IndexController::class, 'announcements'])->name('announcements');
    Route::get('/guidelines', [IndexController::class, 'guidelines'])->name('guidelines');
    Route::get('/about', [IndexController::class, 'about'])->name('about');
    Route::get('/contact', [ContactController::class, 'contactus'])->name('contactus');
    Route::get('/faqs', [FaqsController::class, 'faqs'])->name('faqs');
    Route::get('/privacy', [IndexController::class, 'privacy'])->name('privacy');
    Route::get('/forums/{forum:slug}/{category:slug}/threads', [ThreadController::class, 'category_threads'])->name('category.threads');
    Route::get('/users/{user:username}/activities', [UserController::class, 'activities'])->name('user.activities');
    Route::get('/users/{user:username}', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/{forum:slug}/{category:slug}/{thread}', [ThreadController::class, 'show'])->name('thread.show');
    Route::get('/announcements/{forum:slug}/{announcement}', [ThreadController::class, 'announcement_show'])->name('announcement.show');

    Route::middleware(['auth'])->group(function () {
        Route::get('/notifications', [NotificationController::class, 'notifications'])->name('user.notifications');
        Route::get('/notifications/settings', [NotificationController::class, 'notifications_settings'])->name('user.notifications.settings');
        Route::get('/threads/add', [ThreadController::class, 'create'])->name('thread.add');
        Route::get('/{user:username}/threads/{thread}/edit', [ThreadController::class, 'edit'])->name('thread.edit');

        Route::get('/settings', [UserController::class, 'edit'])->name('user.settings');
        Route::get('/settings/personal', [UserController::class, 'edit_personal_infos'])->name('user.personal.settings');
        Route::get('/settings/strikes', [UserController::class, 'strikes_and_warnings'])->name('user.strikes');
        Route::get('/settings/passwords', [UserController::class, 'edit_password'])->name('user.passwords.settings');
        Route::get('/settings/account', [UserController::class, 'account_settings'])->name('user.account');
    });
});