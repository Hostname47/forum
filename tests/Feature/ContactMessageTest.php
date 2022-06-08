<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Classes\TestHelper;
use App\Models\{User, UserBan, BanReason, ContactMessage};
use Carbon\Carbon;

class ContactMessageTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    public function setUp() : void
    {
        parent::setUp();
        
        TestHelper::fill_db_tables_defaults(
            ['account_status', 'ban_reasons', 'authorizationbreak_types']
        );

        $user = User::factory()->create(['id'=>1700, 'username'=>'hostname47']);
        $user->set_account_status('active');
        $this->user = $user;
    }

    /** @test */
    public function contact_message_message_input_is_required() {
        $user = $this->user;
        $this->actingAs($user);

        $response = $this->post('/contact', []); // Missed message
        $response->assertRedirect();
        $response->assertSessionHasErrors('message');
    }

    /** @test */
    public function contact_informations_required_in_case_of_guest_user() {
        $response = $this->post('/contact', []); // Missed message
        $response->assertRedirect();
        $response->assertSessionHasErrors(['firstname', 'lastname', 'email', 'message']);
    }

    /** @test */
    public function contact_message_rate_limit_for_auth_user() {
        $user = $this->user;
        $this->actingAs($user);

        $cm = ContactMessage::factory(10)->create(['user'=>$user->id,'created_at'=>Carbon::now()]);
        
        $response = $this->post('/contact', ['message'=>'out beyond']);
        $response->assertForbidden();
    }

    /** @test */
    public function contact_message_rate_limit_for_guest_user() {
        $cm = ContactMessage::factory(10)->create(['ip'=>'127.0.0.1', 'created_at'=>Carbon::now()]);
        $response = $this->post('/contact', 
            ['firstname'=>'mouad', 'lastname'=>'nassri', 'email'=>'mouad@gmail.com', 'company'=>'gladiator', 'phone'=>'0671035697', 'message'=>'out beyond'], 
            ['REMOTE_ADDR' => '127.0.0.1']);

        $response->assertForbidden();
    }

    /** @test */
    public function submit_contact_message() {
        $user = $this->user;
        $this->actingAs($user);

        $this->assertCount(0, ContactMessage::all());
        $response = $this->post('/contact', ['message'=>'hello guys, Mouad in the house']);
        $this->assertCount(1, ContactMessage::all());
        // Logout to submit a message as guest
        \Auth::logout();
        $response = $this->post('/contact', ['firstname'=>'mouad', 'lastname'=>'nassri', 'email'=>'mouad@gmail.com', 'company'=>'gladiator', 'phone'=>'0671035697', 'message'=>'out beyond']);
        $this->assertCount(2, ContactMessage::all());
    }

    /** @test */
    public function when_user_reach_limit_show_a_message_to_viewer() {
        $user = $this->user;
        $this->actingAs($user);

        ContactMessage::factory(10)->create(['user'=>$user->id]);

        $response = $this->get('/contact');
        $response->assertSee('You have a limited number of messages per day');
    }
}
