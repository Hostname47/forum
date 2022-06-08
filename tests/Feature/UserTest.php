<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\File;
use Tests\TestCase;
use Mockery;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use Laravel\Socialite\Two\User as SocialUser;
use App\Models\{AccountStatus, User, UserPersonalInfos, ProfileView, UserBan, BanReason, Authorizationbreak};
use App\Models\{ContactMessage, EmojiFeedback, FAQ, Feedback, Follow, Like, Vote, Notification, 
                NotificationDisable, Category, CategoryStatus, Forum, ForumStatus, Thread, ThreadStatus, 
                ThreadVisibility, ThreadClose, CloseReason, Post, PostStatus, SavedThread, Poll, PollOption, OptionVote,
                Permission, Role};
use App\Classes\TestHelper;
use App\Jobs\User\CleanUserResourcesAfterDelete;
use Carbon\Carbon;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    
    public function setUp() : void
    {
        parent::setUp();

        TestHelper::fill_db_tables_defaults(
            ['account_status', 'thread_visibility', 'thread_status', 'closereasons', 'post_status', 'ban_reasons', 'authorizationbreak_types', 'category_status', 'forum_status']
        );
    }

    /** @test */
    public function user_could_be_created() {
        $user = User::factory()->create();
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function google_oauth_opened_successfully() {
        $response = $this->get('/login/google');

        $response->assertStatus(302);
        $response->assertSee('google');
    }
    
    /** @test */
    public function facebbok_oauth_opened_successfully() {
        $response = $this->get('/login/facebook');

        $response->assertStatus(302);
        $response->assertSee('facebook');
    }

    /** @test */
    public function user_signup_using_google_oauth() {
        // Mock the Facade and return a User Object
        $this->mockSocialiteFacade();
        
        $this->assertCount(0, User::all());
        $response = $this->get('google/callback');
        $this->assertCount(1, User::all());
    }

    public function mockSocialiteFacade($email='mouad@nassri.com', $token='foo', $id=1) {
        // mock users
        $socialiteUser = $this->createMock(SocialUser::class);
        $socialiteUser->token = $token;
        $socialiteUser->id = $id;
        $socialiteUser->email = $email;
        $socialiteUser->avatar_original = 'mouad.cdn.io/shut-the-fokirap';

        // mock provider
        $provider = $this->createMock(GoogleProvider::class);
        $provider->expects($this->any())
            ->method('user')
            ->willReturn($socialiteUser);

        $stub = $this->createMock(Socialite::class);
        $stub->expects($this->any())
            ->method('driver')
            ->willReturn($provider);

        // Replace Socialite Instance with our mock
        $this->app->instance(Socialite::class, $stub);
    }

    /** @test */
    public function user_could_not_register_using_usual_signup() { // Only oauth is supported now
        $this->withoutExceptionHandling();
        $this->expectException(\Illuminate\Contracts\Container\BindingResolutionException::class);
        $data = [
            'firstname'=>'mouad',
            'lastname'=>'nassri',
            'username'=>'hostname47',
            'email'=>'hostname47@gmail.com',
            'password'=>'Password54',
            'password_confirmation'=>'Password54'
        ];

        $this->assertTrue(true);
        $response = $this->post('/register', $data);
    }

    /** @test */
    public function permanently_banned_user_could_not_access_the_website() {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->set_account_status('active');
        
        $response = $this->get(route('user.settings', ['user'=>$user->username]));
        $response->assertOk();

        UserBan::create([
            'user_id'=>$user->id,
            'admin_id'=>$user->id,
            'ban_reason'=>BanReason::first()->id,
            'ban_duration'=>-1,
            'created_at'=>Carbon::now(),
            'type'=>'permanent'
        ]);
        $user->set_account_status('banned');
        $user->refresh();
        $response = $this->get(route('user.settings', ['user'=>$user->username]));
        $response->assertRedirect(route('home'));
        $response->assertSessionHasAll([
            'error' => 'Your account has been banned permanently. If you think you get this ban by accident, feel free to contact us',
        ]);
    }

    /** @test */
    public function user_with_deactivated_account_could_not_access_the_website() {
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->set_account_status('deactivated');

        $response = $this->get(route('user.settings', ['user'=>$user->username]));
        $response->assertRedirect(route('user.account.activate'));
    }

    /** @test */
    public function user_with_deleted_account_could_not_access_the_website() {
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->set_account_status('deleted');
        $response = $this->get(route('user.settings', ['user'=>$user->username]));
        $response->assertRedirect(route('home'));
        $response->assertSessionHasAll([
            'error' => 'This account has already been deleted permanently.',
        ]);
    }

    /** @test */
    public function deactivated_user_activities_page_not_reachable() {
        $visitor = User::factory()->create();
        $visitor->set_account_status('active');
        $user = User::factory()->create();
        $user->set_account_status('deactivated');

        $this->actingAs($visitor);
        $response = $this->get(route('user.activities', ['user'=>$user->username]));
        $response->assertSee('This account is currently deactivated');
    }

    /** @test */
    public function banned_user_activities_page_not_reachable() {
        $visitor = User::factory()->create();
        $visitor->set_account_status('active');
        $user = User::factory()->create();
        $user->set_account_status('banned');

        $this->actingAs($visitor);
        $response = $this->get(route('user.activities', ['user'=>$user->username]));
        $response->assertSee('This account is currently banned');
    }

    /** @test */
    public function deactivated_user_profile_page_not_reachable() {
        $visitor = User::factory()->create();
        $visitor->set_account_status('active');
        $user = User::factory()->create();
        $user->set_account_status('deactivated');

        $this->actingAs($visitor);
        $response = $this->get(route('user.profile', ['user'=>$user->username]));
        $response->assertSee('This account is currently deactivated');
    }

    /** @test */
    public function banned_user_profile_page_not_reachable() {
        $visitor = User::factory()->create();
        $visitor->set_account_status('active');
        $user = User::factory()->create();
        $user->set_account_status('banned');

        $this->actingAs($visitor);
        $response = $this->get(route('user.profile', ['user'=>$user->username]));
        $response->assertSee('This account is currently banned');
    }

    /** @test */
    public function user_profile_views_incremented() {
        $visitor = User::factory()->create();
        $visitor->set_account_status('active');
        $user = User::factory()->create();
        $user->set_account_status('active');
        $this->actingAs($visitor);

        $this->assertEquals(0, $user->profile_views);
        $response = $this->get(route('user.profile', ['user'=>$user->username]));
        $this->assertEquals(1, $user->profile_views);
    }

    /** @test */
    public function user_profile_views_does_increment_only_once_per_day_for_same_user() {
        $visitor = User::factory()->create();
        $visitor->set_account_status('active');
        $user = User::factory()->create();
        $user->set_account_status('active');
        $this->actingAs($visitor);

        $this->assertEquals(0, $user->profile_views);
        $response = $this->get(route('user.profile', ['user'=>$user->username]));
        $response = $this->get(route('user.profile', ['user'=>$user->username]));
        $this->assertEquals(1, $user->profile_views); // Even we visit the profile twice we have only 1
        $profileview = ProfileView::first();
        $profileview->update(['created_at'=>Carbon::now()->subHours(24)]);
        $response = $this->get(route('user.profile', ['user'=>$user->username]));
        $this->assertEquals(2, $user->profile_views);
    }

    /** @test */
    public function username_availability_check() {
        $user = User::factory()->create(['username'=>'hostname47']);
        $other = User::factory()->create(['username'=>'cosmicplata']);
        $user->set_account_status('active');
        /** Authenticating with hastname47 */
        $this->actingAs($user);
        $response = $this->post('/users/username/check', ['username'=>'grotto79']);
        $this->assertEquals($response['status'], 'valid');
        $response = $this->post('/users/username/check', ['username'=>'hostname47']);
        $this->assertEquals($response['status'], 'yours');
        $response = $this->post('/users/username/check', ['username'=>'cosmicplata']);
        $this->assertEquals($response['status'], 'taken');

        $response = $this->post('/users/username/check', ['username'=>'1']);
        $response->assertSessionHasErrors(['username'=>'Username must contain at least 6 characters']);
        $response = $this->post('/users/username/check', ['username'=>'1ergejr&&é']);
        $response->assertSessionHasErrors(['username'=>'Username must contain only letters, numbers or dashes']);
    }

    /** @test */
    public function user_textual_data_updated_successfully() {
        $user = User::factory()->create([
            'id'=>1337,
            'firstname'=>'Mouad',
            'lastname'=>'Nassri',
            'username'=>'hostname47',
            'about'=>'The quieter you become, the more you are able to hear'
        ]);
        $user->set_account_status('active');
        
        $this->actingAs($user);
        $response = $this->post('/settings/profile', [
            'firstname'=>'Jalaludin',
            'lastname'=>'Rumi',
            'username'=>'rumi_jalal',
            'about'=>'between wrongdoing and rightdoing there is a field'
        ]);
        $this->assertEquals($user->firstname, 'Jalaludin');
        $this->assertEquals($user->lastname, 'Rumi');
        $this->assertEquals($user->username, 'rumi_jalal');
        $this->assertEquals($user->about, 'between wrongdoing and rightdoing there is a field');
    }

    /** @test */
    public function user_avatar_uploaded_and_stored_successfully() {
        $user = User::factory()->create(['id'=>1700]);
        $user->set_account_status('active');
        $this->actingAs($user);

        Storage::fake('public');
        Storage::fake('public/users/'.$user->id.'/usermedia/avatars/originals');
        Storage::fake('public/users/'.$user->id.'/usermedia/avatars/segments');

        // Assert a file does not exist...
        $this->assertEquals(0, count(Storage::disk('public')->allFiles('users/'.$user->id.'/usermedia/avatars/originals')));
        $this->assertEquals(0, count(Storage::disk('public')->allFiles('users/'.$user->id.'/usermedia/avatars/segments')));
        $this->post('/settings/profile', [
            'avatar'=>UploadedFile::fake()->image('nassri.png', 30, 30)->size(200)
        ]);
        $this->assertEquals(1, count(Storage::disk('public')->allFiles('users/'.$user->id.'/usermedia/avatars/originals')));
        /** *2 because for each dimension we have lover and higher resolution of avatar */
        $this->assertEquals($user->avatar_dimensions_count*2, count(Storage::disk('public')->allFiles('users/'.$user->id.'/usermedia/avatars/segments')));
    }

    /** @test */
    public function user_avatar_upload_validation() {
        $user = User::factory()->create(['id'=>1700]);
        $user->set_account_status('active');
        $this->actingAs($user);

        Storage::fake('public');
        Storage::fake('public/users/'.$user->id.'/usermedia/avatars/originals');
        Storage::fake('public/users/'.$user->id.'/usermedia/avatars/segments');

        // Test avatar file size
        $response = $this->post('/settings/profile', [
            'avatar'=>UploadedFile::fake()->image('nassri.png', 30, 30)->size(5001)
        ]);
        $response->assertSessionHasErrors(['avatar'=>'Avatar size should be less than 5MB']);
        // Test avatar file dimensions
        $response = $this->post('/settings/profile', [
            'avatar'=>UploadedFile::fake()->image('nassri.png', 2001, 30)->size(1000)
        ]);
        $response->assertSessionHasErrors(['avatar'=>'Invalid avatar dimensions. Please read rules in right panel']);
    }
    
    /** @test */
    public function user_cover_uploaded_and_stored_successfully() {
        $user = User::factory()->create(['id'=>1700]);
        $user->set_account_status('active');
        $this->actingAs($user);

        Storage::fake('public');
        Storage::fake('public/users/'.$user->id.'/usermedia/covers');

        // Assert a file does not exist...
        $this->assertEquals(0, count(Storage::disk('public')->allFiles('users/'.$user->id.'/usermedia/covers')));
        $this->post('/settings/profile', [
            'cover'=>UploadedFile::fake()->image('nassri.png', 500, 100)->size(200)
        ]);
        $this->assertEquals(1, count(Storage::disk('public')->allFiles('users/'.$user->id.'/usermedia/covers')));
    }

    /** @test */
    public function user_cover_upload_validation() {
        $user = User::factory()->create(['id'=>1700]);
        $user->set_account_status('active');
        $this->actingAs($user);

        Storage::fake('public');
        Storage::fake('public/users/'.$user->id.'/usermedia/covers');

        // Test avatar file size
        $response = $this->post('/settings/profile', [
            'cover'=>UploadedFile::fake()->image('c1.png', 30, 30)->size(10001)
        ]);
        $response->assertSessionHasErrors(['cover'=>'Cover size should be less than 10MB']);
        // Test avatar file dimensions
        $response = $this->post('/settings/profile', [
            'cover'=>UploadedFile::fake()->image('c2.png', 80, 9)->size(200) // min height is 10px
        ]);
        $response->assertSessionHasErrors(['cover'=>'Invalid cover dimensions. Please read rules in right panel']);
    }

    /** @test */
    public function banned_user_could_not_update_his_data() {
        $this->withoutExceptionHandling();
        $user = User::factory()->create(['id'=>1700, 'username'=>'hostname47']);
        
        $this->actingAs($user);
        $user->set_account_status('banned');

        $response = $this->post('/settings/profile', [
            'firstname'=>'Jalaludin',
            'lastname'=>'Rumi',
            'username'=>'rumi_jalal',
            'about'=>'between wrongdoing and rightdoing there is a field'
        ]);
        $response->assertRedirect(route('home'));
        $response->assertSessionHasAll([
            'error' => 'Your account has been banned permanently. If you think you get this ban by accident, feel free to contact us',
        ]);
        $this->assertEquals('hostname47', $user->username);
    }

    /** @test */
    public function temporarily_banned_user_could_not_update_his_data() {
        $this->withoutExceptionHandling();
        $this->expectException(\Illuminate\Auth\Access\AuthorizationException::class);
        $user = User::factory()->create(['id'=>1700, 'username'=>'hostname47']);
        
        $this->actingAs($user);
        $user->set_account_status('temp-banned');
        $ban = UserBan::create([
            'user_id'=>$user->id,
            'admin_id'=>$user->id,
            'ban_reason'=>BanReason::first()->id,
            'ban_duration'=>7,
            'created_at'=>Carbon::now(),
        ]);

        $response = $this->post('/settings/profile', [
            'firstname'=>'Jalaludin',
            'lastname'=>'Rumi',
            'username'=>'rumi_jalal',
            'about'=>'between wrongdoing and rightdoing there is a field'
        ]);
    }

    /** @test */
    public function user_personal_informations_update() {
        $this->withoutExceptionHandling();
        $user = User::factory()->create(['id'=>1700, 'username'=>'hostname47']);
        UserPersonalInfos::create(['user_id'=>$user->id]);
        $this->actingAs($user);
        $user->set_account_status('active');

        $this->assertEquals(null, $user->personal->birth);
        $this->patch('/settings/personal', [
            'birth'=>Carbon::now(),
            'phone'=>'0671035697',
            'country'=>'Morrocco',
            'city'=>'Oujda',
        ]);
        $this->assertTrue(!is_null($user->personal->birth));
    }

    /** @test */
    public function set_first_password_after_oauth_registration() {
        $this->mockSocialiteFacade();
        $response = $this->get('google/callback');
        
        $user = User::first();
        $this->assertTrue(is_null($user->password));
        $this->post('/settings/password/set', [
            'password'=>'Hostname1',
            'password_confirmation'=>'Hostname1'
        ]);
        $user->refresh();
        $this->assertTrue(!is_null($user->password));
    }

    /** @test */
    public function user_could_not_set_first_password_if_he_has_already_a_password() {
        $user = User::factory()->create();
        $user->set_account_status('active');
        $this->actingAs($user);

        $this->assertCount(0, Authorizationbreak::all());
        $response = $this->post('/settings/password/set', [
            'password'=>'Hostname1',
            'password_confirmation'=>'Hostname1'
        ]);
        $response->assertForbidden();
        $this->assertCount(1, Authorizationbreak::all());
    }

    /** @test */
    public function user_password_update() {
        $user = User::factory()->create(['password'=>null]);
        $user->set_account_status('active');
        $this->actingAs($user);

        $response = $this->post('/settings/password/set', [
            'password'=>'Hostname1',
            'password_confirmation'=>'Hostname1'
        ]);
        $this->assertTrue(Hash::check('Hostname1', $user->password));

        $response = $this->patch('/settings/password/update', [
            'currentpassword'=>'Hostname1',
            'password'=>'FlimsyEntropy589',
            'password_confirmation'=>'FlimsyEntropy589'
        ]);

        $this->assertTrue(Hash::check('FlimsyEntropy589', $user->password));
    }

    /** @test */
    public function user_password_update_fail_if_current_password_is_wrong() {
        $user = User::factory()->create(['password'=>null]);
        $user->set_account_status('active');
        $this->actingAs($user);

        $response = $this->post('/settings/password/set', [
            'password'=>'Hostname1',
            'password_confirmation'=>'Hostname1'
        ]);

        $response = $this->patch('/settings/password/update', [
            'currentpassword'=>'Hostname89',
            'password'=>'FlimsyEntropy589',
            'password_confirmation'=>'FlimsyEntropy589'
        ]);
        $response->assertStatus(422);
    }

    /** @test */
    public function user_deactivate_his_account() {
        $user = User::factory()->create(['password'=>Hash::make('Hostname47')]);
        $user->set_account_status('active');
        $this->actingAs($user);

        $response = $this->patch('/settings/account/deactivate', ['password'=>'Hostname47']);
        $user->refresh();
        $this->assertEquals('deactivated', $user->status->slug);
    }

    /** @test */
    public function user_cannot_deactivate_account_with_invalid_password() {
        $user = User::factory()->create(['password'=>Hash::make('Hostname47')]);
        $user->set_account_status('active');
        $this->actingAs($user);

        $response = $this->patch('/settings/account/deactivate', ['password'=>'Hostname48']);
        $response->assertStatus(422);
    }

    /** @test */
    public function user_account_activation_access() {
        $user = User::factory()->create(['password'=>Hash::make('Hostname47')]);
        $user->set_account_status('active');
        $this->actingAs($user);

        $response = $this->get('/settings/account/activate');
        $response->assertStatus(404);
        $response = $this->patch('/settings/account/deactivate', ['password'=>'Hostname47']);
        $user->refresh();
        /** User is unauthenticated after he deactivate his account */
        $this->actingAs($user);
        $response = $this->get('/settings/account/activate');
        $response->assertStatus(200);
    }

    /** @test */
    public function user_account_activation() {
        $user = User::factory()->create(['password'=>Hash::make('Hostname47')]);
        $user->set_account_status('active');
        $this->actingAs($user);

        $response = $this->patch('/settings/account/deactivate', ['password'=>'Hostname47']);
        $user->refresh();
        /** User is unauthenticated after he deactivate his account */
        $this->actingAs($user);
        $this->assertTrue($user->account_deactivated());
        
        $response = $this->patch('/settings/account/activate', ['password'=>'Hostname47']);
        $user->refresh();
        $this->actingAs($user);
        $this->assertTrue(!$user->account_deactivated());
    }

    /** @test */
    public function user_account_deletion_and_resources_cleanups() {
        $this->withoutExceptionHandling();
        /**
         * Please notice that we don't cover some use cases here like testing whether scoped threads
         * (followers only) gets deleted or not because we'll handle those tests in Thread tests
         * 
         * IMPORTANT : Please run the queue worker before run this test
         */
        $user = User::factory()->create(['id'=>488, 'avatar'=>'has-avatar', 'password'=>Hash::make('Hostname47')]);
        UserPersonalInfos::create(['user_id'=>$user->id, 'country'=>'Morocco', 'city'=>'oujda']);
        $other1 = User::factory()->create(['id'=>478, 'password'=>Hash::make('codename48')]);
        $other1->set_account_status('active');
        $other2 = User::factory()->create(['id'=>468, 'password'=>Hash::make('codename49')]);

        $user->set_account_status('active');
        $this->actingAs($user);
        /**
         * Before test user resources cleanups, we need to fill tables like forums, categories, ...etc
         * After than, we will create models for every relationship and attach it to this user to 
         * check if those resources will be deleted as the user deleted or not
         * 
         * IMPORTANT: Please note that we don't have to check for user interacting with other users's
         * resources - likes that come from other user on his threads - because we'll handle this actions when we handle
         * thread deletion; Here we only test user's own resources
         */
        ContactMessage::factory(2)->create(['user'=>$user->id]);
        $this->assertCount(2, ContactMessage::all());

        EmojiFeedback::factory(2)->create(['user_id'=>$user->id]);
        $this->assertCount(2, EmojiFeedback::all());

        $faqs = FAQ::factory(2)->create(['user_id'=>$user->id, 'live'=>1]);
        $unverifiedfaq = FAQ::factory()->create(['user_id'=>$user->id, 'live'=>0]);
        $this->assertCount(3, FAQ::all());

        Feedback::factory(2)->create(['user_id'=>$user->id]);
        $this->assertCount(2, Feedback::all());

        // Add 2 followers to $user and follow 2 other users
        Follow::create(['follower'=>$other1->id, 'followable_id'=>$user->id, 'followable_type'=>'App\Models\User']);
        Follow::create(['follower'=>$other2->id, 'followable_id'=>$user->id, 'followable_type'=>'App\Models\User']);
        Follow::create(['follower'=>$user->id, 'followable_id'=>$other1->id, 'followable_type'=>'App\Models\User']);
        Follow::create(['follower'=>$user->id, 'followable_id'=>$other2->id, 'followable_type'=>'App\Models\User']);
        $this->assertCount(4, Follow::all());

        // Likes
        Like::factory(2)->create(['user_id'=>$user->id]);
        $this->assertCount(2, Like::all());

        /**
         * Notifications
         * 
         * Here we only need to take care of notifications that belongs directly to the user; For notifications
         * that are generated due to $user activity like replying to other user's post, we'll use a scheduled
         * task to remove orphaned notifications
         */
        Notification::factory(2)->create(['notifiable_id'=>$user->id, 'notifiable_type'=>'App\Models\User']);
        $this->assertCount(2, Notification::all());

        NotificationDisable::factory(2)->create(['user_id'=>$user->id]);
        $this->assertCount(2, NotificationDisable::all());

        Vote::factory(2)->create(['user_id'=>$user->id]);
        $this->assertCount(2, Vote::all());

        $this->get('/faqs');
        $this->get('/contact');
        $this->assertEquals(2, $user->visits()->count());

        $this->assertTrue(!is_null($user->personal));

        // Threads
        $forum = Forum::factory()->create(['status_id'=>ForumStatus::where('slug', 'live')->first()->id]);
        $category = Category::factory()->create(['status_id'=>CategoryStatus::where('slug', 'live')->first()->id, 'forum_id'=>$forum->id]);
        $threads = Thread::factory(2)->create(['user_id'=>$user->id,'category_id'=>$category->id,'status_id'=>ThreadStatus::where('slug', 'live')->first()->id,'visibility_id'=>ThreadVisibility::where('slug', 'public')->first()->id]);
        $other1thread = Thread::factory()->create(['user_id'=>$other1->id, 'category_id'=>$category->id, 'status_id'=>ThreadStatus::where('slug', 'live')->first()->id, 'visibility_id'=>ThreadVisibility::where('slug', 'public')->first()->id]);
        $this->assertTrue($user->threads()->count() == 2);

        // Thread closes
        ThreadClose::create([
            'thread_id'=>$threads[0]->id,
            'closed_by'=>$other1->id,
            'reason_id'=>CloseReason::first()->id
        ]);
        $this->assertTrue(ThreadClose::count() == 1);

        // Posts (replies)
        Post::factory(2)->create([
            'user_id'=>$user->id,
            'thread_id'=>$threads->first()->id,
            'status_id'=>PostStatus::where('slug','live')->first()->id
        ]);
        $this->assertTrue($user->posts()->count() == 2);

        // User reach
        $this->actingAs($other1);
        $this->get(route('thread.show', 
            ['forum'=>$forum->slug, 'category'=>$category->slug, 'thread'=>$threads->first()->id]));
        $this->assertTrue($user->reach()->count() == 1);

        // Profile views
        $this->get(route('user.profile', ['user'=>$user->username]));
        $this->assertTrue($user->profile_views == 1);

        $this->actingAs($user);

        // Saved threads
        $this->post('/thread/' . $threads[0]->id . '/save', ['save_switch'=>'save']);
        $this->post('/thread/' . $threads[1]->id . '/save', ['save_switch'=>'save']);
        $this->assertTrue($user->savedthreads()->withoutGlobalScopes()->count() == 2);
        
        // Reports
        $this->post('/thread/' . $other1thread->id . '/report', ['type'=>'spam']);
        $this->assertTrue($user->reportings()->count() == 1);

        // Thread Poll tests
        Bus::fake();
        $thread = Thread::create([
            'user_id'=>$other1->id,
            'subject'=>'This is subject',
            'category_id'=>$category->id,
            'status_id'=>ThreadStatus::where('slug', 'live')->first()->id,
            'visibility_id'=>ThreadVisibility::where('slug', 'public')->first()->id,
            'type'=>'poll',
            'replies_off'=>0,
        ]);
        $poll = Poll::create([
            'thread_id'=>$thread->id,
            'allow_multiple_voting'=>1,
            'allow_options_add'=>1,
            'options_add_limit'=>1,
        ]);
        foreach(['option1', 'option2'] as $option) {
            PollOption::create([
                'content' => $option,
                'poll_id' => $poll->id,
                'user_id' => $other1->id
            ]);
        }
        PollOption::create([
            'content' => 'option3',
            'poll_id' => $poll->id,
            'user_id' => $user->id
        ]);

        $pollthread = Thread::where('subject', 'This is subject')->first(); // thread poll
        $this->post('/options/vote', [
            'option_id'=>$pollthread->poll->options()->first()->id
        ]);

        // Permission
        $permission = Permission::create(['permission'=>'Foo', 'slug'=>'foo', 'description'=>'foo bar', 'scope'=>'foo']);
        $user->grant_permission($permission);
        $this->assertCount(1, $user->permissions);

        // Role
        $role = Role::create(['role'=>'Foo', 'slug'=>'foo', 'description'=>'foo bar', 'priority'=>1]);
        $user->grant_role($role);
        $this->assertCount(1, $user->roles);

        // user folders for media and threads
        File::makeDirectory(public_path().'/users/' . $user->id.'/threads/14', 0777, true, true);
        File::makeDirectory(public_path().'/users/' . $user->id.'/usermedia/avatars/segments/rr', 0777, true, true);
        $this->assertTrue(is_dir(public_path() . '/users/' . $user->id.'/threads/14')); // Should be deleted after deleting
        $this->assertTrue(is_dir(public_path() . '/users/' . $user->id.'/usermedia/avatars/segments/rr')); // Should be deleted after deleting

        // ====== DELETE USER ======
        $response = $this->delete('/user/delete', [
            'password'=>'Hostname47'
        ]);
        Bus::assertDispatched(CleanUserResourcesAfterDelete::class);
        
        // Dispatch the job to check cleaning queries (not just mock it)
        $cleanjob = new CleanUserResourcesAfterDelete($user);
        $cleanjob->handle($user);
        
        $user->refresh();

        $this->assertTrue(!is_null($user->deleted_at));
        $this->assertTrue($user->status->slug == 'deleted');

        $this->assertCount(0, ContactMessage::all());
        $this->assertCount(0, EmojiFeedback::all());
        $this->assertCount(2, FAQ::all()); // Only unverified faqs of that user gets deleted
        $this->assertCount(0, Feedback::all());
        $this->assertCount(0, Follow::all());
        $this->assertCount(0, Like::all());
        $this->assertCount(0, Notification::all());
        $this->assertCount(0, NotificationDisable::all());
        $this->assertCount(0, Vote::all());
        $this->assertEquals(0, $user->visits()->count());
        $this->assertTrue(is_null($user->personal->country));
        $this->assertTrue(is_null($user->avatar));
        $this->assertEquals(0, $user->threads()->withoutGlobalScopes()->count());
        $this->assertCount(0, ThreadClose::all());
        $this->assertCount(0, Post::all());
        $this->assertCount(0, $user->reach);
        $this->assertTrue($user->profile_views == 0);
        $this->assertTrue($user->savedthreads()->withoutGlobalScopes()->count() == 0);
        $this->assertCount(0, $user->reportings);
        $this->assertCount(2, PollOption::all()); // $user collaborate on other1 poll with 1 option; poll has 3 options; when $user deleted it becomes 2
        $this->assertCount(0, $pollthread->poll->votes); // Remove user votes on poll options
        $this->assertCount(0, $user->permissions);
        $this->assertCount(0, $user->roles);

        $this->assertTrue(!is_dir(public_path() . '/users/' . $user->id.'/threads/14'));
        $this->assertTrue(!is_dir(public_path() . '/users/' . $user->id.'/usermedia/avatars/segments/rr')); // Should be deleted after deleting
    }
}
