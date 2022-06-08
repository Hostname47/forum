<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Classes\TestHelper;
use App\Models\{User, FAQ, UserBan, BanReason, Authorizationbreak, ContactMessage};
use Carbon\Carbon;

class FAQTest extends TestCase
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
    public function faq_question_input_is_required() {
        $user = $this->user;
        $this->actingAs($user);

        $response = $this->post('/faqs', []);
        $response->assertRedirect();
        $response->assertSessionHasErrors('question');
    }

    /** @test */
    public function faq_inputs_validation() {
        $user = $this->user;
        $this->actingAs($user);

        $response = $this->post('/faqs', [
            'question'=>'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eveniet, quia sint. Nesciunt aut illo ipsa voluptatum. Pariatur repudiandae repellendus error ab rem, esse vel, sunt minima ullam aut at odit.Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eveniet, quia sint. Nesciunt aut illo ipsa voluptatum. Pariatur repudiandae repellendus error ab rem, esse vel, sunt minima ullam aut at odit.er',
            'desc'=>'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eveniet, quia sint. Nesciunt aut illo ipsa voluptatum. Pariatur repudiandae repellendus error ab rem, esse vel, sunt minima ullam aut at odit.Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eveniet, quia sint. Nesciunt aut illo ipsa voluptatum. Pariatur repudiandae repellendus error ab rem, esse vel, sunt minima ullam aut at odit.Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eveniet, quia sint. Nesciunt aut illo ipsa voluptatum. Pariatur repudiandae repellendus error ab rem, esse vel, sunt minima ullam aut at odit.Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eveniet, quia sint. Nesciunt aut illo ipsa voluptatum. Pariatur repudiandae repellendus error ab rem, esse vel, sunt minima ullam aut at odierggerttt',
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['question', 'desc']);

        $response = $this->post('/faqs', []);
        $response->assertRedirect();
        $response->assertSessionHasErrors('question'); // question is missing
    }

    /** @test */
    public function faqs_rate_limit() {
        $user = $this->user;
        $this->actingAs($user);

        FAQ::factory(8)->create(['user_id'=>$user->id,'created_at'=>Carbon::now()]);
        $this->assertCount(0, Authorizationbreak::all());
        $response = $this->post('/faqs', ['question'=>'Is this the 9th question today !?']);
        $this->assertCount(1, Authorizationbreak::all());
        $response->assertForbidden();
    }

    /** @test */
    public function temp_banned_user_cannot_submit_faqs() {
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

        $response = $this->post('/faqs', ['question'=>'Who is the creator of this website !?']);
        $response->assertForbidden();
    }

    /** @test */
    public function permanent_banned_user_submit_faqs() {
        $user = $this->user;
        $this->actingAs($user);
        
        $user->set_account_status('banned');
        $response = $this->post('/faqs', ['question'=>'Who is the creator of this website !?']);
        $response->assertRedirect(route('home')); // When user is permanently banned, we logged him out and redirect to home (with ban flash message)
    }

    /** @test */
    public function faq_saved_successfully() {
        $user = $this->user;
        $this->actingAs($user);
        
        $this->assertCount(0, FAQ::all());
        $response = $this->post('/faqs', ['question'=>'Who is the creator of this website !?']);
        $this->assertCount(1, FAQ::all());
    }
}
