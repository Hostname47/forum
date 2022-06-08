@extends('layouts.admin')

@section('title', 'Admin - Contact messages')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.feedbacks-and-messages', 'subpage'=>'contactmessages'])
@endsection

@push('scripts')
<script src="{{ asset('js/admin/contactmessages.js') }}" defer></script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/contactmessages.css') }}">
@endpush

@section('content')
    <div class="flex align-center space-between top-page-title-box">
        <div class="flex align-center">
            <svg class="size18 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40"><path d="M39.24,33.2c-6.6.76-13.23.18-19.85.34-3.07.07-6.15,0-9.22,0C9,33.52,7.63,34,7,32.6s.68-2.12,1.46-2.93c2.56-2.63,5-5.36,7.78-7.78,1.81-1.6,1.42-2.48-.13-3.89-2.85-2.6-5.51-5.42-8.26-8.15C7.19,9.21,6.55,8.58,7,7.55c.31-.81,1-.88,1.72-.88q14.58,0,29.16,0a8.6,8.6,0,0,1,1.41.22ZM11.66,30.3H34.34c-2.55-2.44-4.6-4.3-6.52-6.29-1.18-1.22-2.14-2.41-3.64-.39a1.28,1.28,0,0,1-2.08.23c-1.89-2.52-3-.67-4.32.6C16,26.23,14.08,28,11.66,30.3ZM33.55,9.92H12.24c3.44,3.45,6.59,6.58,9.7,9.73.62.64,1.09,1,1.88.18C27,16.58,30.14,13.38,33.55,9.92ZM36,27.84V11.51c-2.61,2.76-4.67,5-6.82,7.19C28.4,19.5,27.94,20,29,21,31.37,23.2,33.61,25.49,36,27.84ZM4.55,21.58a12.17,12.17,0,0,0,1.48,0c.8-.1,1.59-.31,1.68-1.32.07-.77-.21-1.47-1-1.5-1.81-.07-3.74-.81-5.34.62A1.06,1.06,0,0,0,1.49,21a2.81,2.81,0,0,0,1.3.59,10.33,10.33,0,0,0,1.76,0Zm5-7.27c0-2.05-2-1.26-3.31-1.4a8.74,8.74,0,0,0-1.77,0A1.42,1.42,0,0,0,3,14.49a1.38,1.38,0,0,0,1.32,1.35c.59.06,1.19,0,2.13,0C7.4,15.63,9.58,16.65,9.52,14.31ZM6.25,27.2a13,13,0,0,0,2.07,0,1.34,1.34,0,0,0,1.25-1.67C9.27,24,8,24.16,7,24.26c-1.37.13-3.13-.76-3.9,1.14-.36.88.27,1.55,1.12,1.75a9.42,9.42,0,0,0,2.06,0Z"/></svg>
            <h1 class="fs22 no-margin lblack">Contact messages</h1>
        </div>
        <div class="flex align-center height-max-content">
            <div class="flex align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                <a href="{{ route('admin.dashboard') }}" class="link-path">Home</a>
            </div>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">Contact messages</span>
            </div>
        </div>
    </div>
    <div id="admin-main-content-box" style="padding-bottom: 0px">
        @php $can_mark_as_read_cmessages = auth()->user()->can('mark_contact_message_as_read', [\App\Models\User::class]); @endphp
        @php $can_delete_cmessages = auth()->user()->can('delete_contact_message', [\App\Models\User::class]); @endphp
        <div>
            <input type="hidden" id="message-read-message" autocomplete="off" value="Message marked as read">
        </div>
        <p class="no-margin mb8">The following messages has been received from users in <strong>contact us</strong> page</p>
        <div class="flex align-center">
            <div class="flex align-center">
                <h2 class="fs14 my8 lblack mr8">Statistics :</h2>
                <div class="flex align-center fs13">
                    <span class="lblack mr4">Today messages :</span>
                    <strong>{{ $todaymessages }}</strong>
                </div>
                <span style="margin: 0 12px" class="fs10">•</span>
                <div class="flex align-center fs13">
                    <span class="lblack mr4">Unread messages :</span>
                    <strong id="unread-messages-counter">{{ $unreadmessages }}</strong>
                </div>
            </div>
            <div class="move-to-right mr4 relative">
                <div class="felx align-center pointer button-with-suboptions">
                    <span class="fs13 bold lblack">more options</span>
                    <svg class="size7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                </div>
                <div class="suboptions-container suboptions-container-right-style" style="right: 0;">
                    <span class="block fs11 bold lblack my4">Selected messages :</span>
                    @if($can_mark_as_read_cmessages)
                    <div class="simple-suboption flex align-center ml8" id="mark-selected-messages-as-read">
                        <div class="size14 mr4 relative">
                            <svg class="size14 icon-above-spinner" fill="#313131" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M255.79,71.38q-34.33,34.22-68.67,68.44Q158,168.88,129,198c-2.32,2.33-3.56,2.71-6.08.15q-27.33-27.69-55-55c-2-2-2.59-3.2-.15-5.34a104.45,104.45,0,0,0,10.09-10.09c2.19-2.53,3.38-1.78,5.34.2,12.92,13.08,26.06,25.94,38.9,39.1,2.89,3,4.33,3.36,7.5.13C165,131.2,200.51,95.49,235.85,59.56c3-3.05,4.56-3.27,7.6-.15,3.82,3.93,7.46,8.19,12.34,11ZM124.06,137.51c1.5,1.52,2.34,1.45,3.86-.07q32-32.11,64.05-64.06c1.53-1.52,2.14-2.47.2-4.25C188.3,65.58,184.61,61.83,181,58c-1.73-1.85-2.73-1.4-4.3.17-21.9,22-43.85,43.87-66.14,66.12C115.2,128.77,119.7,133.07,124.06,137.51Zm-106.53-11C13.35,130.71,9.23,134.93,5,139c-1.78,1.73-.24,2.52.74,3.5Q33.88,170.71,62,198.91c1.94,2,3,1.56,4.63-.17,3.37-3.58,6.79-7.13,10.44-10.41,2.18-2,1.79-3.08-.11-5q-28.09-27.87-56-55.92c-.67-.66-1.38-1.28-2.08-1.94A16.78,16.78,0,0,0,17.53,126.54Z"/></svg>
                            <div class="spinner size14 opacity0 absolute" style="top: 0; left: 0">
                                <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                            </div>
                        </div>
                        <div class="fs12 button-text bold">Mark as read</div>
                        <input type="hidden" class="message-after-success" value="Selected messages have been marked as read successfully" autocomplete="off">
                    </div>
                    @else
                    <div class="simple-suboption flex cursor-not-allowed ml8">
                        <svg class="size14 mr4" fill="#313131" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M255.79,71.38q-34.33,34.22-68.67,68.44Q158,168.88,129,198c-2.32,2.33-3.56,2.71-6.08.15q-27.33-27.69-55-55c-2-2-2.59-3.2-.15-5.34a104.45,104.45,0,0,0,10.09-10.09c2.19-2.53,3.38-1.78,5.34.2,12.92,13.08,26.06,25.94,38.9,39.1,2.89,3,4.33,3.36,7.5.13C165,131.2,200.51,95.49,235.85,59.56c3-3.05,4.56-3.27,7.6-.15,3.82,3.93,7.46,8.19,12.34,11ZM124.06,137.51c1.5,1.52,2.34,1.45,3.86-.07q32-32.11,64.05-64.06c1.53-1.52,2.14-2.47.2-4.25C188.3,65.58,184.61,61.83,181,58c-1.73-1.85-2.73-1.4-4.3.17-21.9,22-43.85,43.87-66.14,66.12C115.2,128.77,119.7,133.07,124.06,137.51Zm-106.53-11C13.35,130.71,9.23,134.93,5,139c-1.78,1.73-.24,2.52.74,3.5Q33.88,170.71,62,198.91c1.94,2,3,1.56,4.63-.17,3.37-3.58,6.79-7.13,10.44-10.41,2.18-2,1.79-3.08-.11-5q-28.09-27.87-56-55.92c-.67-.66-1.38-1.28-2.08-1.94A16.78,16.78,0,0,0,17.53,126.54Z"/></svg>
                        <div>
                            <div class="fs12 button-text bold">Mark as read</div>
                            <p class="fs11 no-margin gray">You cannot mark messages as read due to lack of permission</p>
                        </div>
                    </div>
                    @endif
                    @if($can_delete_cmessages)
                    <div class="simple-suboption flex align-center ml8" id="delete-selected-messages">
                        <div class="size14 relative mr4">
                            <svg class="size12 icon-above-spinner flex" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                            <div class="spinner size14 opacity0 absolute" fill="#2ca0ff" style="top: 0; left: 0">
                                <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                            </div>
                        </div>
                        <div class="fs12 button-text bold">Delete</div>
                        <input type="hidden" class="message-after-success" value="Selected messages have been deleted successfully" autocomplete="off">
                    </div>
                    @else
                    <div class="simple-suboption flex cursor-not-allowed ml8">
                        <svg class="size12 mr4 mt2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                        <div>
                            <div class="fs12 button-text bold">Delete</div>
                            <p class="fs11 no-margin gray">You cannot delete messages due to lack of permission</p>
                        </div>
                    </div>
                    @endif
                    <div class="simple-line-separator my4"></div>
                    @if($can_mark_as_read_cmessages)
                    <div class="pointer simple-suboption flex align-center" id="mark-all-messages-as-read">
                        <div class="size14 mr4 relative">
                            <svg class="size14 icon-above-spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M255.79,71.38q-34.33,34.22-68.67,68.44Q158,168.88,129,198c-2.32,2.33-3.56,2.71-6.08.15q-27.33-27.69-55-55c-2-2-2.59-3.2-.15-5.34a104.45,104.45,0,0,0,10.09-10.09c2.19-2.53,3.38-1.78,5.34.2,12.92,13.08,26.06,25.94,38.9,39.1,2.89,3,4.33,3.36,7.5.13C165,131.2,200.51,95.49,235.85,59.56c3-3.05,4.56-3.27,7.6-.15,3.82,3.93,7.46,8.19,12.34,11ZM124.06,137.51c1.5,1.52,2.34,1.45,3.86-.07q32-32.11,64.05-64.06c1.53-1.52,2.14-2.47.2-4.25C188.3,65.58,184.61,61.83,181,58c-1.73-1.85-2.73-1.4-4.3.17-21.9,22-43.85,43.87-66.14,66.12C115.2,128.77,119.7,133.07,124.06,137.51Zm-106.53-11C13.35,130.71,9.23,134.93,5,139c-1.78,1.73-.24,2.52.74,3.5Q33.88,170.71,62,198.91c1.94,2,3,1.56,4.63-.17,3.37-3.58,6.79-7.13,10.44-10.41,2.18-2,1.79-3.08-.11-5q-28.09-27.87-56-55.92c-.67-.66-1.38-1.28-2.08-1.94A16.78,16.78,0,0,0,17.53,126.54Z"/></svg>
                            <div class="spinner size14 opacity0 absolute spinner-above-icon" fill="#2ca0ff" style="top: 0; left: 0">
                                <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                            </div>
                        </div>
                        <span class="fs12 bold">Mark all as read</span>
                        <input type="hidden" class="message-after-success" value="All messages have been marked as read successfully" autocomplete="off">
                    </div>
                    @else
                    <div class="pointer simple-suboption flex cursor-not-allowed">
                        <svg class="size14 mr4 mt2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M255.79,71.38q-34.33,34.22-68.67,68.44Q158,168.88,129,198c-2.32,2.33-3.56,2.71-6.08.15q-27.33-27.69-55-55c-2-2-2.59-3.2-.15-5.34a104.45,104.45,0,0,0,10.09-10.09c2.19-2.53,3.38-1.78,5.34.2,12.92,13.08,26.06,25.94,38.9,39.1,2.89,3,4.33,3.36,7.5.13C165,131.2,200.51,95.49,235.85,59.56c3-3.05,4.56-3.27,7.6-.15,3.82,3.93,7.46,8.19,12.34,11ZM124.06,137.51c1.5,1.52,2.34,1.45,3.86-.07q32-32.11,64.05-64.06c1.53-1.52,2.14-2.47.2-4.25C188.3,65.58,184.61,61.83,181,58c-1.73-1.85-2.73-1.4-4.3.17-21.9,22-43.85,43.87-66.14,66.12C115.2,128.77,119.7,133.07,124.06,137.51Zm-106.53-11C13.35,130.71,9.23,134.93,5,139c-1.78,1.73-.24,2.52.74,3.5Q33.88,170.71,62,198.91c1.94,2,3,1.56,4.63-.17,3.37-3.58,6.79-7.13,10.44-10.41,2.18-2,1.79-3.08-.11-5q-28.09-27.87-56-55.92c-.67-.66-1.38-1.28-2.08-1.94A16.78,16.78,0,0,0,17.53,126.54Z"/></svg>
                        <div>
                            <span class="fs12 bold">Mark all as read</span>
                            <p class="fs11 no-margin gray">You cannot mark messages as read due to lack of permission</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div id="contact-messages-box">
            @foreach($contactmessages as $message)
                <x-admin.contactmessage.cmessage :message="$message" :data="['canread'=>$can_mark_as_read_cmessages, 'candelete'=>$can_delete_cmessages]"/>
            @endforeach
            @if($hasmore)
            <div class="flex mb8 full-width contact-messages-fetch-more">
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