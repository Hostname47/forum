@extends('layouts.app')

@section('title', 'Privacy Policy')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/privacy.js') }}" defer></script>
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'privacy'])
    <style>
        em {
            letter-spacing: 1.1px;
        }
        #privacy p, #privacy li {
            font-size: 15px;
            min-width: 300px;
            line-height: 1.7;
            letter-spacing: 1.1px;
            margin: 0;
        }

        #middle-padding {
            width: 74%;
            min-width: 300px;
            margin: 0 auto;
        }

        h2 {
            color: #202020;
            margin-bottom: 6px;
        }

    </style>
    <div class="flex align-center middle-padding-1">
        <a href="/" class="link-path flex align-center unselectable">
            <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
            {{ __('Board index') }}
        </a>
        <svg class="size12 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <span class="current-link-path unselectable">{{ __('Privacy Policy') }}</span>
    </div>
    <div id="middle-padding">
        <!-- title -->
        <div class="full-center move-to-middle">
            <h1 id="cu-heading" style="margin-bottom: 0">{{ __('PRIVACY POLICY') }}</h1>
        </div>
        <div style="margin: 10px 0 10px 0;" class="full-center">
            <em>{{__('When you use our website, that means you’re trusting us')}}.</em>
        </div>
        <!-- FAQs -->
        @if(Session::has('message'))
            <div class="green-message-container full-width border-box flex align-center" style="margin: 16px 0">
                <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:rgb(67, 172, 67)"/></svg>
                <p class="green-message">{{ Session::get('message') }}</p>
            </div>
        @endif
        <div id="privacy" style="margin-bottom: 40px">
            <p>{{__('At Moroccan Gladiator, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by our website and how we use it')}}.</p>
            <p>{{__('If you have additional questions or require more information about our Privacy Policy, do not hesitate to')}} <a href="{{ route('contactus') }}" class="link-path">{{__('contact us')}}</a>.</p>

            <p>{{__('This Privacy Policy applies only to our online activities and is valid for visitors to our website with regards to the information that they shared and/or collect in our website. This policy is not applicable to any information collected offline or via channels other than this website')}}.</p>

            <h2>{{__('Consent')}}</h2>

            <p>{{__('By using our website, you hereby consent to our Privacy Policy and agree to its terms')}}.</p>

            <h2 id="data-we-collect">{{__('Information we collect')}}</h2>

            <p>{{ __("The personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information") }}.</p>
            <p>{{__("If you contact us directly, we may receive additional information about you such as your name, email address, phone number, the contents of the message and/or attachments you may send us, and any other information you may choose to provide")}}.</p>
            <p>{{__("When you register for an Account using one of your social media accounts, we may ask for your contact information, including items such as full name, email address, and your avatar")}}.</p>

            <h2>{{__("How we use your information")}}</h2>

            <p>{{__('We use the information we collect in various ways, including')}}:</p>

            <ul>
                <li>{{__('Provide, operate, and maintain our website')}}</li>
                <li>{{__('Improve, personalize, and expand our website')}}</li>
                <li>{{__('Understand and analyze how you use our website')}}</li>
                <li>{{__('Develop new products, services, features, and functionality')}}</li>
                <li>{{__('Send you emails')}}</li>
                <li>{{__('Find and prevent fraud')}}</li>
            </ul>

            <h2>{{__('Log Files')}}</h2>

            <p>{{("Moroccan Gladiator follows a standard procedure of using log files. These files log visitors when they visit websites. All hosting companies do this and a part of hosting services' analytics. The information collected by log files include internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks. These are not linked to any information that is personally identifiable. The purpose of the information is for analyzing trends, administering the site, tracking users' movement on the website, and gathering demographic information")}}.</p>

            <h2 id="cookies-and-beacons">{{__('Cookies and Web Beacons')}}</h2>
            <p>{{__("Like any other website, Moroccan Gladiator uses 'cookies'. These cookies are used to store information including visitors' preferences, and the pages on the website that the visitor accessed or visited. The information is used to optimize the users' experience by customizing our web page content based on visitors' browser type and/or other information")}}.</p>

            <h2>{{__('Our Advertising Partners')}}</h2>
            <p>{{__("Some of advertisers on our site may use cookies and web beacons. Our advertising partners are listed below. Each of our advertising partners has their own Privacy Policy for their policies on user data. For easier access, we hyperlinked to their Privacy Policies below")}}.</p>

            <ul>
                <li>
                    <p>Google</p>
                    <p><a href="https://policies.google.com/technologies/ads">https://policies.google.com/technologies/ads</a></p>
                </li>
            </ul>

            <h2>{{__('Advertising Partners Privacy Policies')}}</h2>

            <P>{{__("You may consult this list to find the Privacy Policy for each of the advertising partners of Moroccan Gladiator")}}.</p>

            <p>{{__("Third-party ad servers or ad networks uses technologies like cookies, JavaScript, or Web Beacons that are used in their respective advertisements and links that appear on the website, which are sent directly to users' browser. They automatically receive your IP address when this occurs. These technologies are used to measure the effectiveness of their advertising campaigns and/or to personalize the advertising content that you see on websites that you visit")}}.</p>

            <p>{{__("Note that we have no access to or control over these cookies that are used by third-party advertisers")}}.</p>

            <h2>{{__("Third Party Privacy Policies")}}</h2>

            <p>{{__("Moroccan Gladiator's Privacy Policy does not apply to other advertisers or websites. Thus, we are advising you to consult the respective Privacy Policies of these third-party ad servers for more detailed information. It may include their practices and instructions about how to opt-out of certain options")}}.</p>

            <p>{{__("You can choose to disable cookies through your individual browser options. To know more detailed information about cookie management with specific web browsers, it can be found at the browsers' respective websites")}}.</p>

            <h2>{{__("CCPA Privacy Rights (Do Not Sell My Personal Information)")}}</h2>

            <p>{{__("Under the CCPA, among other rights, California consumers have the right to")}}:</p>
            <p>{{__("Request that a business that collects a consumer's personal data disclose the categories and specific pieces of personal data that a business has collected about consumers")}}.</p>
            <p>{{__("Request that a business delete any personal data about the consumer that a business has collected")}}.</p>
            <p>{{__("Request that a business that sells a consumer's personal data, not sell the consumer's personal data")}}.</p>
            <p>{{__("If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us")}}.</p>

            <h2>{{ __('GDPR Data Protection Rights') }}</h2>

            <p>{{__("We would like to make sure you are fully aware of all of your data protection rights. Every user is entitled to the following")}}:</p>
            <p>{{__("The right to access – You have the right to request copies of your personal data. We may charge you a small fee for this service")}}.</p>
            <p>{{__("The right to rectification – You have the right to request that we correct any information you believe is inaccurate. You also have the right to request that we complete the information you believe is incomplete")}}.</p>
            <p>{{__("The right to erasure – You have the right to request that we erase your personal data, under certain conditions")}}.</p>
            <p>{{__("The right to restrict processing – You have the right to request that we restrict the processing of your personal data, under certain conditions")}}.</p>
            <p>{{__("The right to object to processing – You have the right to object to our processing of your personal data, under certain conditions")}}.</p>
            <p>{{__("The right to data portability – You have the right to request that we transfer the data that we have collected to another organization, or directly to you, under certain conditions")}}.</p>
            <p>{{__("If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us")}}.</p>

            <h2>{{__("Children's Information")}}</h2>

            <p>{{__("Another part of our priority is adding protection for children while using the internet. We encourage parents and guardians to observe, participate in, and/or monitor and guide their online activity")}}.</p>

            <p>{{__("Moroccan Gladiator does not knowingly collect any Personal Identifiable Information from children under the age of 13. If you think that your child provided this kind of information on our website, we strongly encourage you to contact us immediately and we will do our best efforts to promptly remove such information from our records")}}.</p>
        </div>
    </div>
@endsection