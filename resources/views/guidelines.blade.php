@extends('layouts.app')

@section('title', 'Guidelines')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'guidelines'])
    <style>
        .contactus-text {
            font-size: 13px;
            min-width: 300px;
            line-height: 1.7;
            letter-spacing: 1.4px;
            margin: 0 0 16px 0;
            color: #1e2027;
        }
        #cu-heading {
            color: #1e2027;
            letter-spacing: 5px;
            margin: 20px 0 14px 0;
        }
        #contact-us-form-wrapper {
            width: 70%;
            min-width: 320px;
        }
        #middle-padding {
            width: 80%;
            min-width: 300px;
            margin: 0 auto;
        }

        em:first-letter {
            margin-left: 10px;
        }
        .text {
            font-size: 15px;
            line-height: 1.5;
            margin: 0;
        }
        .bordered-guideline {
            padding: 6px 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            background-color: #fbfbfb;
        }
        .table-left-grid {
            width: 150px;
            min-width: 150px;
            max-width: 150px;
        }
        p {
            font-size: 15px;
        }
        #left-panel {
            width: 250px;
        }
    </style>
    <div class="flex align-center middle-padding-1">
        <a href="/" class="link-path flex align-center unselectable">
            <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
            {{ __('Board index') }}
        </a>
        <svg class="size12 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <span class="current-link-path unselectable">{{ __('Guidelines') }}</span>
    </div>
    <div id="middle-padding">
        <div>
            @if(Session::has('message'))
                <div class="green-message-container full-width border-box flex align-center" style="margin-top: 16px">
                    <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:rgb(67, 172, 67)"/></svg>
                    <p class="green-message">{{ Session::get('message') }}</p>
                </div>
            @endif
            <div class="full-center move-to-middle">
                <svg class="size24 mr8 mt8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M65.4,453.77h85.53V512l55-24.76L261,512V453.77H446.6V0H65.4ZM231,465.61l-25-11.27-25,11.27V423.74H231ZM155.44,30H416.6V333.7H155.44Zm-60,0h30.05V333.7h-30Zm0,333.7H416.6v60.07H261v-30H150.93v30H95.4ZM301,231.9V161.85H241v30h30V231.9H241v30h90.07v-30ZM271,101.8h30v30H271Z"/></svg>
                <h1 id="cu-heading">{{__('FORUM GUIDELINES')}}</h1>
            </div>
            <em class="fs15 flex text-center move-to-middle" style="width: 80%">{{ __("Champions aren't made in the gyms. Champions are made from something they have deep inside them -- a desire, a dream, a vision") }} ~ Muhammad Ali</em>
            <h3 class="no-margin fs17 mb4" style="margin-top: 18px">{{__('INTRODUCTION')}}</h3>
            <p class="text bordered-guideline">
                {{ __("Moroccan gladiator forum is intended to be a place where athletes can engage with each other on a peaceful, friendly basis. The rules which govern this forum have been implemented to protect both the forum and its users. Please make yourself familiar with these rules. Members of the gladiator's team and Moderators are in the forums on a regular basis, and we will enforce these rules whenever necessary") }}.
            </p>
            <h3 class="no-margin fs17 mb4" style='margin-top: 12px'>I. {{ __('Forum Rules & Guidelines') }}</h3>
            <div style='margin-left: 16px'>
                <p><b>1.</b> {{ __('Respect comes in two unchangeable steps: giving it and receiving it') }}.</p>
                <p><b>2.</b> {{ __('Make sure to be always a useful member..and judge yourself first before people judge you..so make your pen always write about the good things') }}.</p>
                <p><b>3.</b> {{ __("The Forum is dedicated to discussing all topics, posts, discussions and questions related to sports, and any irrelevant topic will be deleted and could lead the topic's user account to be banned") }}.</p>
                <p><b>4.</b> {{ __("Each member must abide by virtuous morals and overcome the barrier of racism in every sporting sector(and they have the right to encourage their teams or favorite players in a manner consistent with the spirit of sport and under the roof of sporting ethics)") }}.</p>
                <p><b>5. {{ __("It is forbidden to write any topic that contradicts the Islamic religion or contradicts religious doctrines") }}</b>.</p>
                <p><b>6.</b> {{ __("The moderators have the right to delete, edit or move any topic or reply that is in violation of the laws and conditions") }}.</p>
                <p><b>7.</b> {{ __("Do not put unorganized and unformatted topics (so that the reader is attracted to read the topic) as copy and paste topics do not have any meaning just to increase views and replies") }}.</p>
                <p><b>8.</b> {{ __("No links to other sports forums") }}.</p>
                <p><b>9.</b> {{ __("Criticism is welcome, but without prejudice or intolerance") }}.</p>
                <p><b>10.</b> {{ __("The member must choose an appropriate title that corresponds to the content of its topic, and the forum administration, monitors and moderators of the forum have the right to change it if necessary(maybe soon, we're going to add a feature where the user could suggest edits)") }}.</p>
                <p><b>11.</b> {{ __("It must be taken into account that the sports forum is attended by visitors of different ages, so we must preserve our writing style so that the topics do not contain bad words that affect modesty") }}.</p>
                <p><b>11.</b> {{ __("We would prefer if we adhere to these rules and stay away from everything that contradicts that, so that we show the beautiful image of our arena, as the forum is for all of us") }}.</p>
                <div class="simple-line-separator my8"></div>
                <div>
                    <p class="my8">{{ __("We confirm what has been mentioned and we wish all the pioneers of the sports section to comply. And always remember") }}:</p>
                    <ul>
                        <li class="my8">{{ __("Your participation is a reflection of your personality") }}.</li>
                        <li class="my8">{{ __("Accepting the other opinion is proof that you are a professional athlete in the truest sense of the word") }}.</li>
                        <li class="my8">{{ __("Your opinion is as valid and wrong as others") }}.</li>
                        <li class="my8">{{ __("These laws were established only to preserve the good relationship of members with each other and to raise the level of our community and It is subject to change and modification if necessary") }}.</li>
                        <li class="my8">{{ __("(Our goal is to promote thought and advancement in the forum, and we hope everyone cooperates with us)") }}.</li>
                        <li class="my8">{{ __("And when there is any suggestion or problem, please go to the contact & feedback section, and you will only find what pleases you Insha'Allah") }}.</li>
                    </ul>
                </div>
            </div>
            <h3 class="no-margin fs17 mb4" style='margin: 12px 0'>II. {{ __('Items that May Result in Immediate Ban') }}</h3>
            <div style="margin-left: 16px">
                <div class="simple-line-separator my8"></div>
                <div class="flex">
                    <p class="no-margin bold text mr8 table-left-grid">{{__('SPAM')}}</p>
                    <p class="no-margin text">{{ __("Spamming or flooding the forums, in which a user posts the same message repeatedly, is prohibited and you will be banned") }}.</p>
                </div>
                <div class="simple-line-separator my8"></div>
                <div class="flex">
                    <p class="no-margin bold text mr8 table-left-grid" >{{ __("Touts / Advertising / Commerce") }}</p>
                    <p class="no-margin text">{{ __("Our forum will not be used as a place to do your personal business. Phone numbers, home addresses, email addresses that are found in any forum other than Website Promotions, will be deleted. Touts involving twitter or Facebook redirects will also result in the user being banned. If you are promoting a service in any forum (including that of a ‘bookie’) other than Website Promotions, your account may be suspended or banned at the discretion of our Moderators and Support team") }}.</p>
                </div>
                <div class="simple-line-separator my8"></div>
                <div class="flex">
                    <p class="no-margin bold text mr8 table-left-grid" >{{ __("Racism, sexism, and other discrimination") }}</p>
                    <p class="no-margin text">{{ __("The use of inappropriate or offensive language is not permitted at Gladiator forum. Inappropriate or offensive language includes, but is not limited to, any language or content that is sexually oriented, sexually suggestive or abusive, harassing, defamatory, vulgar, obscene, profane, hateful, or that contains racially, ethnically or otherwise objectionable material of any kind") }}.</p>
                </div>
                <div class="simple-line-separator my8"></div>
                <div class="flex">
                    <p class="no-margin bold text mr8 table-left-grid" >{{ __("Links to External Sites") }}</p>
                    <p class="no-margin text">{{ __("Links to informational sites or informative articles such as those found on sports websites that include useful informations are permitted but links to personal sites (Facebook), personal spaces, websites, pick services, and sites solely designed for advertising/commerce are not permitted. If you are unsure if your link is permitted, check with a Support or a moderator first") }}.</p>
                </div>
                <div class="simple-line-separator my8"></div>
            </div>
            <h3 class="no-margin fs17 mb4" style='margin-top: 12px'>III. {{ __('Other Rules') }}</h3>
            <div style="margin-left: 16px">
                <p class="no-margin text my8"><b>1. {{ __("Images") }}</b>: {{ __("Any avatars, covers, images, or URLs containing nudity, pornography, or sexually explicit attire (e.g., bikinis/lingerie) are NOT permitted in the forum and will be removed (may lead the user's account to be banned). This includes, but is not limited to") }}:</p>
                <div class="ml8">                                    
                    <p class="text no-margin">1-1. {{ __("Strategically covered nudity") }}</p>
                    <p class="text no-margin">1-2. {{ __("Sheer or see-through clothing") }}</p>
                    <p class="text no-margin">1-3. {{ __("Lewd or provocative poses") }}</p>
                    <p class="text no-margin">1-4. {{ __("Close-ups of breasts, buttocks or crotches") }}</p>
                </div>
                <p class="text no-margin">{{ __("All avatars will be reviewed by the Gladiator team – if they are deemed inappropriate, they will be removed. If users continue to upload avatars that violate these guidelines, the user will be banned") }}.</p>
                <p class="text my8"><b>2.</b> {{ __("Slanderous posts are not allowed. If a post is deemed slanderous, the post may be deleted or moved to the penalty box and the poster may be boxed or even banned") }}.</p>
                <p class="text my8"><b>3.</b> {{ __("Any obvious site promotions will be assumed to be meant for the promotions area, and will be moved there if not deleted. Any other off-topic posts will be relocated to the appropriate forum and/or deleted accordingly") }}.</p>
                <p class="text my8"><b>4.</b> {{ __("Intentionally repetitive posts or replies posted by the same user may be locked, deleted, or consolidated") }}.</p>
                <p class="text my8"><b>5.</b> {{ __("Any post in the forum which deteriorate to arguments between two or more users will be moved to the penalty box, or deleted at the discretion of our Moderators") }}.</p>
                <p class="text my8"><b>6.</b> {{ __("If you have nothing positive to offer our forum and are only posting insults, attacks, and/or emoticons, you will be warned, suspended, and/or banned from the forum. Users who are suspended may continue to post in the Penalty Box for a period of time until the Moderators decide to either ban the user or release them from the box") }}.</p>
            </div>
            <h3 class="no-margin fs17 mb4" style='margin-top: 12px'>IV. {{ __('General Guidelines of Behavior') }}</h3>
            <div style="margin-left: 16px">
                <p class="text my8">{{ __("Gladiator’ forum is only enjoyable for our users as long as everyone plays fair. Therefore, we have come up with a few basic guidelines that we expect all of our users to agree to and respect. We are counting on our forum members to do a lot of self-policing to ensure that guidelines are being followed. Respecting these guidelines will keep the forum vibrant, entertaining, and enjoyable") }}!</p>
                <p class="text my8">{{ __("If you notice a member behaving in a way that is a direct violation of the rules and spirit of the forum, please let us know via the contact and feedback page. If this member’s attitude is not violating the rules but is ruining your experience in the forum, please consider ignoring them as opposed to engaging in an online battle") }}.</p>
                <p class="text my8">{{ __("With regards to slanderous posts/comments: as mentioned above, we will be notifying users if we deem a post to be unsubstantiated and slanderous. Once a post has been deemed slanderous, it will either be deleted or moved to the Penalty Box forum") }}.</p>
                <p class="text my8">{{ __("Try to be civil! We know that this can be difficult if someone is being rude and disruptive. However, we also know that nobody wants to read a page full of arguments, either. Please try to maintain a sense of dignity. Refusing to engage in rude or disruptive behavior also shows a lot of class") }}.</p>
                <p class="text my8">{{ __("If you have a good idea about ways to improve the forum, let us know in the contact page! We participated in the creation of this site, and we plan to add new features from time to time so feedback from our users is definitely welcome") }}.</p>
            </div>
            <h3 class="no-margin fs20 mb4" style='margin-top: 12px'>{{ __('The Legal Stuff') }}</h3>
            <p class="text bordered-guideline text-center" style="background-color: #f5fff5">
                {{ __("All of the information contained inside this forum represents the personal thoughts and opinions of the individual members. Submissions to this forum are not reflective of the thoughts and opinions of moroccan-gladiator.com, nor its employees. moroccan-gladiator.com and its employees do not endorse or represent any of the opinions within the forum, and shall not be held responsible in any legal action resulting from any of the content contained within the forum. Furthermore, moroccan-gladiator.com shall not be responsible for keeping a permanent record of the opinions expressed within the forum, and we may delete or edit submissions to the forum at our discretion if deemed necessary") }}.
            </p>
            <div class="full-center" style="margin: 20px 0">
                <em class="text flex text-center" style="width: 60%">
                    {{ __("In conclusion, we would like to point out to all members that all of this was only set for the service of our sports department. We hope that you will abide by these laws and take them seriously and understand them as we promised you") }}.
                </em>
            </div>
        </div>
    </div>
@endsection