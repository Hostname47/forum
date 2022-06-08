@extends('layouts.admin')

@section('title', 'Admin - Feedbacks')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.feedbacks-and-messages', 'subpage'=>'feedbacks'])
@endsection

@push('scripts')
<script src="{{ asset('js/admin/feedbacks.js') }}" defer></script>
@endpush

@section('content')
    <style>
        .feedback-message-content {
            padding: 6px;
            border-radius: 4px;
            border: 1px solid #d9d9d9;
            background-color: #eee;
        }

        #feedbacks-box {
            padding: 8px 12px 8px 8px;
            background-color: rgb(245, 245, 245);
            border: 1px solid #d9d9d9;
            border-radius: 4px 4px 0 0;
        }

        .more-button-style-1 {
            background-color: #f7f7f7;
            border-radius: 50%;
            padding: 4px;
            border: 1px solid #cacaca;
        }
    </style>
    <div class="flex align-center space-between top-page-title-box">
        <div class="flex align-center">
            <svg class="size24 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M128,132,57.22,238.11,256,470,454.78,238.11,384,132Zm83,90H104l35.65-53.49Zm-30-60H331l-75,56.25Zm60,90V406.43L108.61,252Zm30,0H403.39L271,406.43Zm30-30,71.32-53.49L408,222ZM482,72V42H452V72H422v30h30v30h30V102h30V72ZM60,372H30v30H0v30H30v30H60V432H90V402H60ZM0,282H30v30H0Zm482-90h30v30H482Z"/></svg>
            <h1 class="fs22 no-margin lblack">{{ __('Users Feedback') }}</h1>
        </div>
        <div class="flex align-center height-max-content">
            <div class="flex align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                <a href="{{ route('admin.dashboard') }}" class="link-path">{{ __('Home') }}</a>
            </div>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Feedbacks') }}</span>
            </div>
        </div>
    </div>
    <div id="admin-main-content-box" style="padding-bottom: 0px">
        @php $can_delete_feedback = auth()->user()->can('delete_feedback', [\App\Models\User::class]); @endphp
        <div>
            <input type="hidden" id="message-read-message" autocomplete="off" value="Message marked as read">
            <input type="hidden" id="message-after-feedback-delete" value="Feedback has been deleted successfully.">
        </div>
        <p class="no-margin mb8">The following feedback messages and emojis feedbacks has been received from users in <strong>feedback panel in the right side</strong></p>
        <h3 class="lblack">Statistics</h3>
        <div>
            <div class="my8">
                <div>
                    <div class="flex align-center">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8ZM397.4,397.4A200,200,0,1,1,114.6,114.6,200,200,0,1,1,397.4,397.4ZM336,224a32,32,0,1,0-32-32A32,32,0,0,0,336,224Zm-160,0a32,32,0,1,0-32-32A32,32,0,0,0,176,224Zm194.4,64H141.6a13.42,13.42,0,0,0-13.5,15c7.5,59.2,58.9,105,121.1,105h13.6c62.2,0,113.6-45.8,121.1-105a13.42,13.42,0,0,0-13.5-15Z"/></svg>
                        <span class="flex lblack fs13">Today Emojis Feedback</span>
                    </div>
                    <div class="flex align-center mt4">
                        <svg class="size16 mx8 mt4" fill="#868686" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"/></svg>
                        <div class="flex align-center mx4">
                            <div class="flex flex-column align-center">
                                <span class="fs13 mb2 bold">{{ $emojisresult['sad'] }}</span>
                                <svg class="mx4 size30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm0,448C145.7,456,56,366.3,56,256S145.7,56,256,56s200,89.7,200,200S366.3,456,256,456Zm8-152a24,24,0,0,0,0,48,80.17,80.17,0,0,1,61.6,28.8,24,24,0,1,0,36.9-30.7A128.11,128.11,0,0,0,264,304Zm-88-64a32,32,0,1,0-32-32A32,32,0,0,0,176,240Zm160-64a32,32,0,1,0,32,32A32,32,0,0,0,336,176ZM170.4,274.8C159,290.1,134,325.4,134,342.9c0,22.7,18.8,41.1,42,41.1s42-18.4,42-41.1c0-17.5-25-52.8-36.4-68.1a7,7,0,0,0-11.2,0Z"/></svg>
                            </div>
                        </div>
                        <div class="flex align-center mx4">
                            <div class="flex flex-column align-center">
                                <span class="fs13 mb2 bold">{{ $emojisresult['sceptic'] }}</span>
                                <svg class="mx4 size30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm0,448C145.7,456,56,366.3,56,256S145.7,56,256,56s200,89.7,200,200S366.3,456,256,456ZM176,240a32,32,0,1,0-32-32A32,32,0,0,0,176,240Zm160-64a32,32,0,1,0,32,32A32,32,0,0,0,336,176ZM256,304a134.84,134.84,0,0,0-103.8,48.6,24,24,0,0,0,36.9,30.7,87,87,0,0,1,133.8,0,24,24,0,1,0,36.9-30.7A134.84,134.84,0,0,0,256,304Z"/></svg>
                            </div>
                        </div>
                        <div class="flex align-center mx4">
                            <div class="flex flex-column align-center">
                                <span class="fs13 mb2 bold">{{ $emojisresult['so-so'] }}</span>
                                <svg class="mx4 size30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm0,448C145.7,456,56,366.3,56,256S145.7,56,256,56s200,89.7,200,200S366.3,456,256,456ZM176,240a32,32,0,1,0-32-32A32,32,0,0,0,176,240Zm160-64a32,32,0,1,0,32,32A32,32,0,0,0,336,176Zm8,144H168a24,24,0,0,0,0,48H344a24,24,0,0,0,0-48Z"/></svg>
                            </div>
                        </div>
                        <div class="flex align-center mx4">
                            <div class="flex flex-column align-center">
                                <span class="fs13 mb2 bold">{{ $emojisresult['happy'] }}</span>
                                <svg class="mx4 size30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm0,448C145.7,456,56,366.3,56,256S145.7,56,256,56s200,89.7,200,200S366.3,456,256,456ZM176,240a32,32,0,1,0-32-32A32,32,0,0,0,176,240Zm160,0a32,32,0,1,0-32-32A32,32,0,0,0,336,240Zm4,72.6a109.24,109.24,0,0,1-168,0,24,24,0,0,0-36.9,30.7,157.42,157.42,0,0,0,241.8,0A24,24,0,1,0,340,312.6Z"/></svg>
                            </div>
                        </div>
                        <div class="flex align-center mx4">
                            <div class="flex flex-column align-center">
                                <span class="fs13 mb2 bold">{{ $emojisresult['veryhappy'] }}</span>
                                <svg class="mx4 size30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8ZM397.4,397.4A200,200,0,1,1,114.6,114.6,200,200,0,1,1,397.4,397.4ZM336,224a32,32,0,1,0-32-32A32,32,0,0,0,336,224Zm-160,0a32,32,0,1,0-32-32A32,32,0,0,0,176,224Zm194.4,64H141.6a13.42,13.42,0,0,0-13.5,15c7.5,59.2,58.9,105,121.1,105h13.6c62.2,0,113.6-45.8,121.1-105a13.42,13.42,0,0,0-13.5-15Z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my8">
                <div class="flex align-center">
                    <svg class="size16 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M128,132,57.22,238.11,256,470,454.78,238.11,384,132Zm83,90H104l35.65-53.49Zm-30-60H331l-75,56.25Zm60,90V406.43L108.61,252Zm30,0H403.39L271,406.43Zm30-30,71.32-53.49L408,222ZM482,72V42H452V72H422v30h30v30h30V102h30V72ZM60,372H30v30H0v30H30v30H60V432H90V402H60ZM0,282H30v30H0Zm482-90h30v30H482Z"/></svg>
                    <span class="flex lblack fs13">Today feedback messages : <span class="ml4 black bold fs14" style="margin-top: -1px">{{ $todayfeedbackscount }}</span></span>
                </div>
            </div>
        </div>
        <div class="flex">
        <div class="move-to-right mr8 mb2 relative">
                <div class="felx align-center pointer button-with-suboptions">
                    <span class="fs13 bold lblack">more options</span>
                    <svg class="size7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                </div>
                <div class="suboptions-container suboptions-container-right-style" style="right: 0; max-width: 200px;">
                    @if($can_delete_feedback)
                    <div class="pointer simple-suboption flex align-center" id="delete-selected-feedbacks-read">
                        <div class="flex relative size12 mr4">
                            <svg class="size12 icon-above-spinner" style="fill: #202020; min-width: 12px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                            <svg class="spinner size12 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <span class="fs12 bold">{{ __('Delete selected feedbacks') }}</span>
                        <input type="hidden" class="message-after-success" value="Selected feedbacks have been deleted successfully" autocomplete="off">
                    </div>
                    @else
                    <div class="pointer simple-suboption flex cursor-not-allowed">
                        <svg class="size12 mr4" style="min-width: 12px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                        <div>
                            <p class="no-margin fs12 bold">{{ __('Delete selected feedbacks') }}</p>
                            <p class="no-margin fs11 gray">You cannot delete feedbacks due to lack of permission</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div id="feedbacks-box">
            <h3 class="lblack mt4">Feedback messages</h3>
            @foreach($feedbacks as $feedback)
                <x-admin.feedback :feedback="$feedback" :data="['candelete'=>$can_delete_feedback]"/>
            @endforeach
            @if($hasmore)
            <div class="flex mb8 full-width" id="feedback-fetch-more">
                <div class="size48 br4 hidden-overflow relative" style="min-width: 48px">
                    <div class="fade-loading"></div>
                </div>
                <div class="ml8 full-width">
                    <div>
                        <div class="br4 hidden-overflow relative mb4" style="height: 14px; width: 120px">
                            <div class="fade-loading"></div>
                        </div>
                        <div class="br4 hidden-overflow relative" style="height: 30px;">
                            <div class="fade-loading"></div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection