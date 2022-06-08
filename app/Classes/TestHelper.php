<?php

namespace App\Classes;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use App\Models\{User, Role, Permission, Forum, UserStatus, Category};

class TestHelper {

    public static function fill_db_tables_defaults($tables=[]) {
        foreach($tables as $table)
            self::fill_db_table_defaults($table);
    }

    public static function fill_db_table_defaults($table) {
        switch($table) {
            case 'account_status':
                DB::unprepared("INSERT INTO `account_status` (`id`, `status`, `slug`) VALUES (1, 'Active', 'active'), (2, 'Deactivated', 'deactivated'), (3, 'Banned', 'banned'), (4, 'Temporarily banned', 'temp-banned'), (5, 'Deleted', 'deleted');");
                break;
            case 'thread_visibility':
                DB::unprepared("INSERT INTO `thread_visibility` (`id`, `visibility`, `slug`) VALUES (1, 'Public', 'public'), (2, 'Followers Only', 'followers-only'), (3, 'Private', 'private')");
                break;
            case 'ban_reasons':
                DB::unprepared("INSERT INTO `ban_reasons` (`id`, `name`, `slug`, `reason`) VALUES (1, 'Too many strikes', 'too-many-strikes', 'Account is banned due to many strikes and violation of our regulations.'), (2, 'Unauthorized actions', 'unauthorized-actions', 'Committing unauthorized actions'), (3, 'Rules and guidelines violation', 'rules-and-guidelines-violation', 'Violation of rules and guidelines and abusive usage of website ');");
                break;
            case 'authorizationbreak_types':
                DB::unprepared("INSERT INTO `authorizationbreak_types` (`id`, `type`, `slug`) VALUES
                (1, 'authbread', 'thread-share-daily-limit-reached'),
                (2, 'authbread', 'try-to-share-announcement-without-permission'),
                (3, 'authbread', 'abusively-change-thread-category-to-announcement'),
                (4, 'authbread', 'update-thread-that-is-not-belong-to-the-updater'),
                (5, 'authbread', 'delete-thread-that-does-not-belong-to-deleter'),
                (6, 'authbread', 'trying-to-destroy-thread-that-does-not-belong-to-destroyer'),
                (7, 'authbread', 'trying-to-update-someone-else-profile-informations'),
                (8, 'authbread', 'trying-to-delete-someone-else-account'),
                (9, 'authbread', 'thread-votes-daily-limit-reached'),
                (10, 'authbread', 'post-votes-daily-limit-reached'),
                (11, 'authbread', 'thread-reports-daily-limit-reached'),
                (12, 'authbread', 'post-reports-daily-limit-reached'),
                (13, 'authbread', 'faqs-daily-limit-reached'),
                (14, 'authbread', 'try-to-follow-himself'),
                (15, 'authbread', 'try-to-delete-a-notification-does-not-belong-to-the-deleter'),
                (16, 'authbread', 'try-to-delete-non-allowable-to-be-deleted-notification'),
                (17, 'authbread', 'try-to-disable-non-allowable-to-be-disabled-notification'),
                (18, 'authbread', 'try-to-enable-a-notification-does-not-belong-to-the-enabler'),
                (19, 'authbread', 'try-to-read-a-notification-does-not-own'),
                (20, 'authbread', 'try-to-delete-poll-option-does-not-own'),
                (21, 'authbread', 'post-share-daily-limit-reached'),
                (22, 'authbread', 'try-to-update-post-does-not-own'),
                (23, 'authbread', 'try-to-delete-post-does-not-own'),
                (24, 'authbread', 'try-to-fetch-a-post-does-not-own'),
                (25, 'authbread', 'try-to-tick-a-thread-does-not-own'),
                (26, 'authbread', 'trying-to-set-new-password-while-has-already-password'),
                (27, 'authbread', 'trying-to-update-password-wihout-an-attached-password');");
                break;
            case 'category_status':
                DB::unprepared("INSERT INTO `category_status` (`id`, `status`, `slug`, `created_at`, `updated_at`) VALUES (1, 'Live', 'live', NULL, NULL),(2, 'Closed', 'closed', NULL, NULL),(3, 'Under Review', 'under-review', NULL, NULL),(4, 'Archived', 'archived', NULL, NULL);");
                break;
            case 'forum_status':
                DB::unprepared("INSERT INTO `forum_status` (`id`, `status`, `slug`, `created_at`, `updated_at`) VALUES (1, 'Live', 'live', NULL, NULL),(2, 'Closed', 'closed', NULL, NULL),(3, 'Under Review', 'under-review', NULL, NULL),(4, 'Archived', 'archived', NULL, NULL);");
                break;
            case 'thread_status':
                DB::unprepared("INSERT INTO `thread_status` (`id`, `status`, `slug`) VALUES (1, 'Live', 'live'),(2, 'Closed', 'closed'),(5, 'Archived', 'archived'),(6, 'Deleted by owner', 'deleted-by-owner'),(7, 'Deleted by an admin', 'deleted-by-an-admin'),(8, 'Closed and deleted by owner', 'closed-and-deleted-by-owner'),(9, 'Closed and deleted by an admin', 'closed-and-deleted-by-an-admin');");
                break;
            case 'post_status':
                DB::unprepared("INSERT INTO `post_status` (`id`, `status`, `slug`) VALUES (1, 'Live', 'live'),(2, 'Deleted by owner', 'deleted-by-owner'),(3, 'Deleted by an admin', 'deleted-by-an-admin');");
                break;
            case 'closereasons':
                DB::unprepared("INSERT INTO `closereasons` (`id`, `name`, `resourcetype`, `slug`, `reason`, `created_at`, `updated_at`) VALUES (1, 'Useless post', 'thread', 'useless-thread', 'useless-thread.', NULL, NULL),(3, 'Post regulations violation', 'thread', 'not-respect-out-rules-and-regulations', 'non-respect-thread', NULL, NULL),(4, 'Post needs changes', 'thread', 'needs-changes', 'needs-change', NULL, NULL);");
                break;

        }
    }

    // ------ Following code is for old tests (removed) ------
    
    public static function create_user() {
        $faker = \Faker\Factory::create();

        $status = self::create_user_status('Unverified', 'unverified')->id;

        $user = User::create([
            'firstname'=>$faker->firstname,
            'lastname'=>$faker->lastname,
            'username'=>$faker->username,
            'status_id'=>$status,
            'email'=>$faker->email,
            'password'=>$faker->password,
        ]);

        return $user;
    }

    public static function create_user_with_status($status, $slug) {
        $faker = \Faker\Factory::create();

        $status = self::create_user_status($status, $slug)->id;

        $user = User::create([
            'firstname'=>$faker->firstname,
            'lastname'=>$faker->lastname,
            'username'=>$faker->username,
            'status_id'=>$status,
            'email'=>$faker->email,
            'password'=>$faker->password,
        ]);

        return $user;
    }

    public static function create_user_with_role($role, $slug) {
        $user = self::create_user();

        if(!self::role_exists($slug)) {
            $role = Role::create([
                'role'=>$role,
                'slug'=>$slug
            ]);
        } else {
            $role = Role::where('slug', $slug)->first();
        }

        $user->roles()->attach($role);

        return $user;
    }

    public static function role_exists($slug) {
        return (bool) count(Role::where('slug', $slug)->get());
    }

    public static function permission_exists($slug) {
        return (bool) count(Permission::where('slug', $slug)->get());
    }

    public static function forum_exists($slug) {
        return (bool) count(Forum::where('slug', $slug)->get());
    }

    public static function category_exists($slug) {
        return (bool) count(Category::where('slug', $slug)->get());
    }

    public static function user_status_exists($slug) {
        return (bool) count(UserStatus::where('slug', $slug)->get());
    }

    public static function create_role($role, $slug) {
        if(!self::role_exists($role)) {
            return Role::create([
                'role'=>$role,
                'slug'=>$slug
            ]);
        }
        
        return Role::where('role', $role)->first();
    }

    public static function create_permission($permission, $slug) {
        if(!self::permission_exists($slug)) {
            return Permission::create([
                'permission'=>$permission,
                'slug'=>$slug,
                'description'=>'To find yourself, think for yourself - socrates'
            ]);
        }

        return Permission::where('permission', $permission)->first();
    }

    public static function create_forum($forum, $slug, $desc, $status) {
        if(!self::forum_exists($slug)) {
            return Forum::create([
                'forum'=>$forum,
                'slug'=>$slug,
                'description'=>$desc,
                'status'=>$status
            ]);
        }

        return Forum::where('slug', $slug)->first();
    }

    public static function create_category($category, $slug, $desc, $forum, $status) {
        if(!self::category_exists($slug)) {
            return Category::create([
                'category'=>$category,
                'slug'=>$slug,
                'description'=>$desc,
                'forum_id'=>$forum,
                'status'=>$status
            ]);
        }

        return Category::where('slug', $slug)->first();
    }

    public static function create_user_status($status, $slug) {
        if(!self::user_status_exists($slug)) {
            return UserStatus::create([
                'status'=>$status,
                'slug'=>$slug,
            ]);
        }

        return UserStatus::where('slug', $slug)->first();
    }
}
