<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Classes\TestHelper;
use App\Models\{User, FAQ, UserBan, BanReason, Authorizationbreak, Feedback, EmojiFeedback};
use Carbon\Carbon;

class FeedbackTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    public function setUp() : void {
        parent::setUp();
        
        TestHelper::fill_db_tables_defaults(
            ['account_status', 'ban_reasons', 'authorizationbreak_types']
        );

        $user = User::factory()->create(['id'=>1700, 'username'=>'hostname47']);
        $user->set_account_status('active');
        $this->user = $user;
    }

    /** @test */
    public function feedback_inputs_validation() {
        $user = $this->user;
        $this->actingAs($user);

        $response = $this->post('/feedback', []);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['feedback']);
        
        \Auth::logout();

        $response = $this->post('/feedback', []);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['email']);

        $this->assertCount(0, Feedback::all());
        $response = $this->post('/feedback', ['feedback'=>'funny feedback', 'email'=>'invalid-email']);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function check_feedback_autorization() {
        $user = $this->user;
        $this->actingAs($user);

        // Auth users limit
        Feedback::factory(4)->create([
            'user_id'=>$user->id,
            'feedback'=>'good feedback',
        ]);
        $response = $this->post('/feedback', ['feedback'=>'funny feedback']);
        $response->assertForbidden();

        \Auth::logout();

        // Guest users limit
        Feedback::factory(4)->create([
            'ip'=>'127.0.0.1',
            'feedback'=>'good feedback',
        ]);
        $response = $this->post('/feedback', ['feedback'=>'funny feedback', 'email'=>'mouad@gmail.com'], ['REMOTE_ADDR'=>'127.0.0.1']);
        $response->assertForbidden();
    }

    /** @test */
    // public function temp_banned_user_cannot_submit_feedbacks() {
    //     $user = $this->user;
    //     $this->actingAs($user);
    //     $user->set_account_status('temp-banned');
    //     $ban = UserBan::create([
    //         'user_id'=>$user->id,
    //         'admin_id'=>$user->id,
    //         'ban_reason'=>BanReason::first()->id,
    //         'ban_duration'=>7,
    //         'created_at'=>Carbon::now(),
    //     ]);

    //     $response = $this->post('/feedback', ['feedback'=>'Amazing website']);
    //     $response->assertForbidden();
    // }

    /** @test */
    // public function permanent_banned_user_submit_feedbacks() {
    //     $user = $this->user;
    //     $this->actingAs($user);
        
    //     $user->set_account_status('banned');
    //     $response = $this->post('/feedback', ['feedback'=>'Amazing website']);
    //     $response->assertRedirect(route('home')); // When user is permanently banned, we logged him out and redirect to home (with ban flash message)
    // }

    /** @test */
    public function feedback_saved_successfully() {
        $user = $this->user;
        $this->actingAs($user);
        
        $this->assertCount(0, Feedback::all());
        $response = $this->post('/feedback', ['feedback'=>'Amazing website']);
        $this->assertCount(1, Feedback::all());

        \Auth::logout();
        $response = $this->post('/feedback', ['email'=>'mouad@gmail.com', 'feedback'=>'Amazing website']);
        $this->assertCount(2, Feedback::all());
    }

    // ==== emoji feedbacks ====

    /** @test */
    public function check_emojifeedback_autorization() {
        $user = $this->user;
        $this->actingAs($user);

        // Auth users limit
        EmojiFeedback::factory(1)->create(['user_id'=>$user->id]);
        $response = $this->post('/emojifeedback', ['emoji_feedback'=>'veryhappy']);
        $response->assertForbidden();

        \Auth::logout();

        // Guest users limit
        EmojiFeedback::factory(1)->create(['emoji_feedback'=>'veryhappy', 'ip'=>'127.0.8.1']);
        $response = $this->post('/emojifeedback', ['emoji_feedback'=>'happy'], ['REMOTE_ADDR'=>'127.0.8.1']);
        $response->assertForbidden();
    }

    /** @test */
    public function check_emojifeedback_validation() {
        $user = $this->user;
        $this->actingAs($user);

        $response = $this->post('/emojifeedback', []);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['emoji_feedback']);
        
        \Auth::logout();

        $response = $this->post('/emojifeedback', []);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['emoji_feedback']);

        $response = $this->post('/emojifeedback', ['emoji_feedback'=>'garbage']);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['emoji_feedback']);

        $response = $this->post('/emojifeedback', ['emoji_feedback'=>'happy']);
        $this->assertCount(1, EmojiFeedback::all());
    }

    public function emoji_feedback_saved_successfully() {
        $user = $this->user;
        $this->actingAs($user);
        
        $this->assertCount(0, EmojiFeedback::all());
        $response = $this->post('/emojifeedback', ['emoji_feedback'=>'veryhappy']);
        $this->assertCount(1, EmojiFeedback::all());

        \Auth::logout();

        $response = $this->post('/emojifeedback', ['emoji_feedback'=>'veryhappy'], ['REMOTE_ADDR'=>'127.1.0.1']);
        $this->assertCount(2, EmojiFeedback::all());
    }
}
