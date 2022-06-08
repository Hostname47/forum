<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;

class Cleaner {
    public static function clean_orphaned_records() {
        DB::statement("DELETE likes FROM likes LEFT JOIN threads 
        ON likes.likable_id=threads.id 
        WHERE likes.likable_type='App\\\Models\\\Thread' AND threads.id IS NULL");

        DB::statement("DELETE likes FROM likes LEFT JOIN posts 
        ON likes.likable_id=posts.id 
        WHERE likes.likable_type='App\\\Models\\\Post' AND posts.id IS NULL");

        DB::statement("DELETE votes FROM votes LEFT JOIN threads 
        ON votes.votable_id=threads.id 
        WHERE votes.votable_type='App\\\Models\\\Thread' AND threads.id IS NULL");

        DB::statement("DELETE votes FROM votes LEFT JOIN posts 
        ON votes.votable_id=posts.id 
        WHERE votes.votable_type='App\\\Models\\\Post' AND posts.id IS NULL");

        DB::statement("DELETE reports FROM reports LEFT JOIN threads 
        ON reports.reportable_id=threads.id 
        WHERE reports.reportable_type='App\\\Models\\\Thread' AND threads.id IS NULL");

        DB::statement("DELETE reports FROM reports LEFT JOIN posts 
        ON reports.reportable_id=posts.id 
        WHERE reports.reportable_type='App\\\Models\\\Post' AND posts.id IS NULL");

        DB::statement("DELETE `warnings` FROM `warnings` LEFT JOIN threads 
        ON `warnings`.resource_id=threads.id 
        WHERE `warnings`.resource_type='App\\\Models\\\Thread' AND threads.id IS NULL");

        DB::statement("DELETE `warnings` FROM `warnings` LEFT JOIN posts 
        ON `warnings`.resource_id=posts.id 
        WHERE `warnings`.resource_type='App\\\Models\\\Post' AND posts.id IS NULL");

        DB::statement("DELETE `strikes` FROM `strikes` LEFT JOIN threads 
        ON `strikes`.resource_id=threads.id 
        WHERE `strikes`.resource_type='App\\\Models\\\Thread' AND threads.id IS NULL");

        DB::statement("DELETE `strikes` FROM `strikes` LEFT JOIN posts 
        ON `strikes`.resource_id=posts.id 
        WHERE `strikes`.resource_type='App\\\Models\\\Post' AND posts.id IS NULL");

        DB::statement("DELETE `notificationsdisables` FROM `notificationsdisables` LEFT JOIN threads 
        ON `notificationsdisables`.resource_id=threads.id 
        WHERE `notificationsdisables`.resource_type='thread' AND threads.id IS NULL");

        DB::statement("DELETE `notificationsdisables` FROM `notificationsdisables` LEFT JOIN posts 
        ON `notificationsdisables`.resource_id=posts.id 
        WHERE `notificationsdisables`.resource_type='post' AND posts.id IS NULL");
    }

    /**
     * This function should be called only If you are sure about deleting medias of a collection of threads
     * like when you destroy a category or a forum
     * 
     * $threads_ids_and_user_ids : must be an array of objects; each object must contain both thread id (id)
     * and user id (user_id) in order to locate the medias location of the thread
     */
    public static function clean_orphaned_threads_medias($threads_ids_and_user_ids) {
        foreach($threads_ids_and_user_ids as $thread_id_and_user_id) {
            $mediasdirectory = storage_path("app/public/users/" . $thread_id_and_user_id->id . "/threads/" . $thread_id_and_user_id->user_id . "/medias");
            \File::deleteDirectory($mediasdirectory);
        }
    }
}