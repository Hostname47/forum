<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Classes\TestHelper;
use App\Models\{User, FAQ, UserBan, BanReason, Authorizationbreak, Feedback, EmojiFeedback};
use Carbon\Carbon;

class FollowTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;
    protected $other;

    public function setUp() : void {
        parent::setUp();
        
        TestHelper::fill_db_tables_defaults(
            ['account_status', 'ban_reasons', 'authorizationbreak_types']
        );

        $user = User::factory()->create(['id'=>1700, 'username'=>'hostname47']);
        $other = User::factory()->create(['id'=>1701, 'username'=>'hostname48']);
        $this->user = $user;
        $this->other = $other;
    }

    /** @test */
    public function try_to_follow_a_user_does_not_exists_or_non_active_will_fail() {
        $user = $this->user;
        $other = $this->other;
        $this->actingAs($user);

        $response = $this->post('/users/follow', ['user_id'=>5]);
        $response->assertRedirect();
        $response->assertSessionHasErrors('user_id');

        $other->set_account_status('deactivated');
        $response = $this->post('/users/follow', ['user_id'=>$other->id]);
        $response->assertForbidden();
    }

    /** @test */
    public function temp_banned_user_cannot_follow_users() {
        $user = $this->user;
        $other = $this->other;
        $this->actingAs($user);
        
        $user->set_account_status('temp-banned');
        $ban = UserBan::create([
            'user_id'=>$user->id,
            'admin_id'=>$user->id,
            'ban_reason'=>BanReason::first()->id,
            'ban_duration'=>7,
            'created_at'=>Carbon::now(),
        ]);

        $response = $this->post('/users/follow', ['user_id'=>$other->id]);
        $response->assertForbidden();
    }

    /** @test */
    public function permanent_banned_user_cannot_follow_users() {
        $user = $this->user;
        $other = $this->other;
        $this->actingAs($user);
        
        $user->set_account_status('banned');
        $response = $this->post('/users/follow', ['user_id'=>$other->id]);
        $response->assertRedirect(route('home')); // When user is permanently banned, we logged him out and redirect to home (with ban flash message)
    }

    /** @test */
    public function temp_banned_users_cannot_be_followed() {
        $user = $this->user;
        $other = $this->other;
        $this->actingAs($user);
        
        $other->set_account_status('temp-banned');
        $ban = UserBan::create([
            'user_id'=>$other->id,
            'admin_id'=>$user->id,
            'ban_reason'=>BanReason::first()->id,
            'ban_duration'=>7,
            'created_at'=>Carbon::now(),
        ]);

        $response = $this->post('/users/follow', ['user_id'=>$other->id]);
        $response->assertForbidden();
    }

    /** @test */
    public function permanent_banned_user_cannot_be_followed() {
        $user = $this->user;
        $other = $this->other;
        $this->actingAs($user);
        
        $other->set_account_status('banned');
        $response = $this->post('/users/follow', ['user_id'=>$other->id]);
        $response->assertForbidden();
    }

    /** @test */
    public function user_cannot_follow_himself() {
        $user = $this->user;
        $this->actingAs($user);
        
        $response = $this->post('/users/follow', ['user_id'=>$user->id]);
        $response->assertForbidden();
    }

    /** @test */
    public function user_can_follow_active_users_successfully() {
        $user = $this->user;
        $other = $this->other;
        $this->actingAs($user);
        
        $this->assertCount(0, $other->followers);
        $response = $this->post('/users/follow', ['user_id'=>$other->id]);
        $other->refresh();
        $this->assertCount(1, $other->followers);
        $response = $this->post('/users/follow', ['user_id'=>$other->id]); // Unfollow
        $other->refresh();
        $this->assertCount(0, $other->followers);
    }
    
    /**
     * Concerning follow viewers; We'll only handle followers side, because followers and follows
     * has the same structure and logic
     */

    /** @test */
    public function get_followers_viewer_of_non_existent_or_non_active_user_will_fail() {
        $user = $this->user;
        $other = $this->other;
        $this->actingAs($user);

        $response = $this->get('/user/followers/viewer?user_id=5');
        $response->assertRedirect();
        $response->assertSessionHasErrors('user_id');

        $other->set_account_status('deactivated');
        $response = $this->get('/user/followers/viewer?user_id=' . $other->id);
        $response->assertStatus(404);
    }

    /** @test */
    public function user_followers_viewer_fetch() {
        $user = $this->user;
        $other = $this->other;
        $this->actingAs($user);

        $response = $this->get('/user/followers/viewer?user_id=' . $other->id);
        $response->assertOk();
        $response->assertJsonFragment(['hasmore'=>false]);
        $response->assertSee('payload');
    }

    /** @test */
    public function fetch_more_followers_of_non_existent_or_non_active_user_will_fail() {
        $user = $this->user;
        $other = $this->other;
        $this->actingAs($user);

        $response = $this->get('/users/followers/fetchmore?user_id=5');
        $response->assertRedirect();
        $response->assertSessionHasErrors(['user_id', 'skip']); // Non-existent user & missing skip

        $other->set_account_status('deactivated');
        $response = $this->get('/users/followers/fetchmore?user_id=' . $other->id . '&skip=10');
        $response->assertStatus(404);
    }

    /** @test */
    public function fetch_more_followers() {
        $user = $this->user;
        $other = $this->other;
        $this->actingAs($user);

        $response = $this->get('/users/followers/fetchmore?user_id=' . $other->id . '&skip=10');
        $response->assertOk();
        $response->assertJsonFragment(['hasmore'=>false]);
        $response->assertSee('payload');
    }

    /** @test */
    public function getting_follower_component_of_non_existent_or_hidden_user_fail() {
        $user = $this->user;
        $this->actingAs($user);

        $response = $this->get('/users/follower/component/generate?user_id=5');
        $response->assertRedirect();
        $response->assertSessionHasErrors(['user_id']); // Non-existent user & missing skip
    }

    /** @test */
    public function getting_follower_component() {
        $user = $this->user;
        $other = $this->other;

        $response = $this->get('/users/follower/component/generate?user_id='.$other->id);
        $response->assertOk();
    }
}
