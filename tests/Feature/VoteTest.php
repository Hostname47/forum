<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Classes\TestHelper;
use App\Models\{User, UserBan, BanReason, Forum, Category, ForumStatus, Notification, CategoryStatus, Thread, ThreadStatus, Post, PostStatus, ThreadVisibility, Vote};
use Carbon\Carbon;

class VoteTest extends TestCase
{
    use DatabaseTransactions;
    
    protected $user;
    protected $thread;
    protected $post;

    public function setUp() : void
    {
        parent::setUp();
        
        TestHelper::fill_db_tables_defaults(
            ['account_status', 'thread_visibility', 'thread_status', 'post_status', 'ban_reasons', 'authorizationbreak_types', 'category_status', 'forum_status']
        );

        $user = User::factory()->create(['id'=>1700, 'username'=>'hostname47']);
        $user->set_account_status('active');

        $forum = Forum::factory()->create(['status_id'=>ForumStatus::where('slug', 'live')->first()->id]);
        $category = Category::factory()->create(['status_id'=>CategoryStatus::where('slug', 'live')->first()->id, 'forum_id'=>$forum->id]);
        $thread = Thread::create([
            'user_id'=>$user->id,
            'subject'=>'This is subject',
            'category_id'=>$category->id,
            'status_id'=>ThreadStatus::where('slug', 'live')->first()->id,
            'visibility_id'=>ThreadVisibility::where('slug', 'public')->first()->id,
            'type'=>'poll',
            'replies_off'=>0,
        ]);
        $post = Post::create([
            'user_id'=>$user->id,
            'thread_id'=>$thread->id,
            'status_id'=>PostStatus::where('slug','live')->first()->id
        ]);

        $this->user = $user;
        $this->thread = $thread;
        $this->post = $post;
    }

    /** @test */
    public function user_cannot_vote_his_own_resources() {
        $user = $this->user;
        $this->actingAs($user);

        $thread = $this->thread;
        $response = $this->post('/thread/vote', [
            'resourceid'=>$thread->id,
            'vote'=>1
        ]);
        $response->assertForbidden();

        $post = $this->post;
        $response = $this->post('/post/vote', [
            'resourceid'=>$post->id,
            'vote'=>1
        ]);
        $response->assertForbidden();
    }

    /** @test */
    public function resource_vote_data_validation() {
        $user = $this->user;
        $this->actingAs($user);

        $response = $this->post('/thread/vote', [
            'resourceid'=>847,
            'vote'=>1
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors('resourceid');

        $response = $this->post('/post/vote', [
            'resourceid'=>847,
            'vote'=>1
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors('resourceid');
    }

    /** @test */
    public function temp_banned_user_cannot_vote() {
        $user = $this->user;
        $this->actingAs($user);
        $user->set_account_status('temp-banned');
        $ban = UserBan::create([
            'user_id'=>$user->id,
            'admin_id'=>$user->id,
            'ban_reason'=>BanReason::first()->id,
            'ban_duration'=>7,
            'created_at'=>Carbon::now(),
        ]);

        $thread = $this->thread;
        $response = $this->post('/thread/vote', [
            'resourceid'=>$thread->id,
            'vote'=>1
        ]);
        $response->assertForbidden();
    }

    /** @test */
    public function permanent_banned_user_cannot_vote() {
        $user = $this->user;
        $this->actingAs($user);
        
        $user->set_account_status('banned');
        $thread = $this->thread;
        $response = $this->post('/thread/vote', [
            'resourceid'=>$thread->id,
            'vote'=>1
        ]);
        $response->assertRedirect(route('home')); // When user is permanently banned, we logged him out and redirect to home (with ban flash message)
    }

    /** @test */
    public function thread_vote() {
        $other = User::factory()->create(['id'=>1701, 'username'=>'hostname49']);
        $other->set_account_status('active');
        $this->actingAs($other);

        $this->assertCount(0, Vote::all());
        $thread = $this->thread;
        $response = $this->post('/thread/vote', [
            'resourceid'=>$thread->id,
            'vote'=>1
        ]);
        $this->assertCount(1, Vote::all());
    }

    /** @test */
    public function post_vote() {
        $other = User::factory()->create(['id'=>1701, 'username'=>'hostname49']);
        $other->set_account_status('active');
        $this->actingAs($other);

        $this->assertCount(0, Vote::all());
        $post = $this->post;
        $response = $this->post('/post/vote', [
            'resourceid'=>$post->id,
            'vote'=>1
        ]);
        $this->assertCount(1, Vote::all());
    }

    /** @test */
    public function cannot_vote_hidden_threads() {
        // Hidden means : deactivated user threads, private or followers-only threads(in case visitor is not a follower)
        $user = $this->user;
        $this->actingAs($user);
        $other = User::factory()->create(['id'=>1701, 'username'=>'hostname49']);
        
        // $other user creates a private thread
        $thread = Thread::create(['user_id'=>$other->id,'subject'=>'This is subject','category_id'=>Category::first()->id,'status_id'=>ThreadStatus::where('slug', 'live')->first()->id,'visibility_id'=>ThreadVisibility::where('slug', 'private')->first()->id,'type'=>'poll','replies_off'=>0]);
        $response = $this->post('/thread/vote', ['resourceid'=>$thread->id,'vote'=>1]);
        $response->assertStatus(404);

        // $other user creates a followers-only thread
        $thread->update(['visibility_id'=>ThreadVisibility::where('slug', 'followers-only')->first()->id]);
        $response = $this->post('/thread/vote', ['resourceid'=>$thread->id,'vote'=>1]);
        $response->assertStatus(404);

        // $other1 share a public thread but he decide to deactivate his account for a while
        $thread->update(['visibility_id'=>ThreadVisibility::where('slug', 'public')->first()->id]);
        $other->set_account_status('deactivated');
        $response = $this->post('/thread/vote', ['resourceid'=>$thread->id,'vote'=>1]);
        $response->assertStatus(404);
    }

    /** @test */
    public function cannot_vote_posts_that_belongs_to_hidden_threads() {
        $user = $this->user;
        $this->actingAs($user);
        $other = User::factory()->create(['id'=>1701, 'username'=>'hostname49']);
        
        // private thread's posts vote
        $thread = Thread::create(['user_id'=>$other->id,'subject'=>'This is subject','category_id'=>Category::first()->id,'status_id'=>ThreadStatus::where('slug', 'live')->first()->id,'visibility_id'=>ThreadVisibility::where('slug', 'private')->first()->id,'type'=>'poll','replies_off'=>0]);
        $post = Post::create([
            'user_id'=>$other->id,
            'thread_id'=>$thread->id,
            'status_id'=>PostStatus::where('slug','live')->first()->id
        ]);
        $response = $this->post('/post/vote', ['resourceid'=>$post->id,'vote'=>1]);
        $response->assertStatus(404);

        // check followers-only thread's posts vote
        $thread->update(['visibility_id'=>ThreadVisibility::where('slug', 'followers-only')->first()->id]);
        $response = $this->post('/post/vote', ['resourceid'=>$post->id,'vote'=>1]);
        $response->assertStatus(404);

        // public thread but the owner decides to deactivate his account for a while
        $thread->update(['visibility_id'=>ThreadVisibility::where('slug', 'public')->first()->id]);
        $other->set_account_status('deactivated');
        $response = $this->post('/post/vote', ['resourceid'=>$post->id,'vote'=>1]);
        $response->assertStatus(404);
    }

}
