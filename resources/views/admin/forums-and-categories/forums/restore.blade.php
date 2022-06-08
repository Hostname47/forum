@extends('layouts.admin')

@section('title', 'Restore a forum')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.forums-and-categories', 'subpage'=>'forums-and-categories-forum-restore'])
@endsection

@push('scripts')
<script src="{{ asset('js/admin/forums-and-categories/fac.js') }}" defer></script>
<script src="{{ asset('js/admin/forums-and-categories/forum.js') }}" defer></script>
@endpush

@section('content')
    <style>
        .forum-section {
            overflow-y: scroll;
            height: 340px;
            max-height: 450px;
            border: 1px solid #e6e6e6;
        }

        .categories-section {
            overflow-y: scroll;
            height: 340px;
            max-height: 280px
        }

        .category-desc-column {
            width: 100%;
        }

        table th {
            font-size: 13px;
            padding: 8px;
            background-color: #e7ecfd;
        }

        table th, table td {
            border-color: #c6c6c6;
        }

        table td {
            font-size: 13px;
        }
    </style>
    <div class="flex space-between align-center top-page-title-box">
        <div class="flex align-center">
            <svg class="mr8 size20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"/><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"/></svg>
            <h1 class="fs22 no-margin lblack">{{ __('Restore a Forum') }}</h1>
        </div>
        <div class="flex align-center height-max-content">
            <div class="flex align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                <a href="{{ route('admin.dashboard') }}" class="link-path">{{ __('Home') }}</a>
            </div>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            @if(is_null($forum))
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Restore a forum') }}</span>
            </div>
            @else
            <div class="flex align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M438.09,273.32h-39.6a102.92,102.92,0,0,1,6.24,35.4V458.37a44.18,44.18,0,0,1-2.54,14.79h65.46A44.4,44.4,0,0,0,512,428.81V347.23A74,74,0,0,0,438.09,273.32ZM107.26,308.73a102.94,102.94,0,0,1,6.25-35.41H73.91A74,74,0,0,0,0,347.23v81.58a44.4,44.4,0,0,0,44.35,44.35h65.46a44.17,44.17,0,0,1-2.55-14.78Zm194-73.91H210.74a74,74,0,0,0-73.91,73.91V458.38a14.78,14.78,0,0,0,14.78,14.78H360.39a14.78,14.78,0,0,0,14.78-14.78V308.73A74,74,0,0,0,301.26,234.82ZM256,38.84a88.87,88.87,0,1,0,88.89,88.89A89,89,0,0,0,256,38.84ZM99.92,121.69a66.44,66.44,0,1,0,66.47,66.47A66.55,66.55,0,0,0,99.92,121.69Zm312.16,0a66.48,66.48,0,1,0,66.48,66.47A66.55,66.55,0,0,0,412.08,121.69Z"/></svg>
                <a href="{{ route('admin.forum.restore') }}" class="link-path">{{ __('Select forum to restore') }}</a>
            </div>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Restore forum') }}</span>
            </div>
            @endif
        </div>
    </div>
    <div id="admin-main-content-box">
        <div>
        @if(is_null($forum))
        <div style="margin-top: 50px">
            <div class="flex flex-column align-center">
                <p class="my8">Select a forum to <strong>restore</strong></p>
                <div class="relative flex align-center justify-center">
                    <div class="relative flex align-center pointer fs13 button-with-suboptions py4">
                        <span class="selected-forum-name forum-color fs14 bold">Select a forum</span>
                        <svg class="size7 mx4 mt2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                    </div>
                    <div class="suboptions-container suboptions-container-right-style scrolly" style="max-height: 300px; right: auto; padding: 12px">
                        @if($forums->count())
                            @include('partials.admin.forums.forums-list-for-categories-ops-linkable', ['forums'=>$forums, 'route'=>'admin.forum.restore'])
                        @else
                        <div class="flex align-center">
                            <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"></path></svg>
                            <p class="fs13 no-margin">There are no archived forums at the moment.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @else
            @if($status->slug != 'archived')
            <div style="margin-top: 20px">
                @php $fscolor = ($status->slug == 'live') ? 'green' : (($status->slug == 'closed') ? 'red' : (($status->slug == 'under-review') ? 'blue' : 'gray' )); @endphp
                <h2 class="forum-color fs26 no-margin" style="margin: 12px 0">Forum : {{ $forum->forum }} - <span class="{{ $fscolor }}">{{ $status->status }}</span></h2>
                <div class="section-style lblack">
                    <div class="flex align-center">
                        <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <span class="fs15 bold lblack">Oops !</span>
                    </div>
                    <div>
                        <p class="no-margin mt8">This forum is not currently <strong>archived</strong> to be restored. Go to path above and select the exact category from archived forums to restore.</p>
                    </div>
                </div>
            </div>
            @else
                @if($canrestore)
                <div id="forum-restore-viewer" class="global-viewer full-center none">
                    <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
                    <div class="global-viewer-content-box viewer-box-style-1" style="width: 660px;">
                        <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                            <div class="flex align-center">
                                <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"/><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"/></svg>
                                <span class="fs20 bold forum-color">{{ __('Restore Forum') }}</span>
                            </div>
                            <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                        </div>
                        <div class="scrolly" style="padding: 14px; max-height: 430px">
                            <!-- inputs and messages -->
                            <input type="hidden" id="forum-status-after-restore" autocomplete="off" value="live">

                            <input type="hidden" id="forum-status-after-restore-is-required-message" value="{{ __('You have to specify the status of forum before restoring it') }}." autocomplete="off">
                            <input type="hidden" id="at-least-one-category-restored-message" value="{{ __('You must select at least one category to restore along with the forum') }}." autocomplete="off">

                            <div class="flex" style="margin-bottom: 12px">
                                <h2 class="forum-color fs20 no-margin mr8">Restore forum :</h2>
                                <svg class="size18 mr8" style="margin-top: 2px" fill="#202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    {!! $forum->icon !!}
                                </svg>
                                <h2 class="forum-color fs20 no-margin">{{ $forum->forum }}</h2>
                            </div>
                            <div class="section-style fs13 lblack" style="margin: 12px 0">
                                <p class="no-margin">Here you can restore the forum and make it live to public. But before that, you have to consider the following points :</p>
                                <div class="ml8 mt8">
                                    <div class="flex align-center">
                                        <div class="fs10 mr8 gray">•</div>
                                        <p class="no-margin">You need to select <strong>at least one category to restore</strong> along with the forum.</p>
                                    </div>
                                    <div class="flex align-center">
                                        <div class="fs10 mr8 gray">•</div>
                                        <p class="no-margin mt4">You have to specify the status of forum after the restore.</p>
                                    </div>
                                </div>
                            </div>

                            <p class="fs13 no-margin">This action will <strong>restore the forum</strong> and show all the activities and resources in there (only in the selected categories to restore) to public users again ! are you sure you want to restore this forum ?</p>
                            <p class="fs13 my8">Remember the forum will be restored and only the selected categories to restore will be accessible to users. The unchecked categories will be archived.</p>

                            <div style="margin-top: 18px">
                                <div class="flex align-center mb8">
                                    <svg class="size13 mr4" style="min-width: 14px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M197.63,2.4C199,4.24,201.19,3.45,203,4.08a32,32,0,0,1,21.4,28.77c.14,4,.18,7.93,0,11.88-.26,6.3-4.8,10.58-10.82,10.44-5.84-.13-9.9-4.25-10.17-10.51-.14-3.3.08-6.61-.09-9.91C202.94,27.81,199,23.86,192,23.52c-3-.14-5.94,0-8.91,0-6-.14-10.05-3-11.2-7.82-1.23-5.13.68-9.09,5.92-12.31a5.8,5.8,0,0,0,1-1ZM38.88,2.4c-.22.78-.87.78-1.52.94C24.43,6.58,16.51,14.91,13.46,27.71c-1.34,5.64-.74,11.53-.53,17.3a10.08,10.08,0,0,0,10.5,10.18c5.78,0,10.14-4.29,10.45-10.36.16-3.13,0-6.28,0-9.42C34.05,27.9,38,23.79,45.5,23.51c3.46-.13,6.94.06,10.4-.14,4.87-.28,7.94-3.08,9.31-7.6s-.25-8-3.59-11.09C60.7,3.83,59.05,4,58.73,2.4Zm55.56,0c-.16,1.13-1.22.84-1.87,1.21-4.47,2.56-6.49,7-5.37,11.67,1.16,4.89,4.64,8,9.88,8.1q21.56.23,43.13,0a9.75,9.75,0,0,0,9.7-7.7c1-4.8-.35-8.79-4.57-11.64-.77-.52-2-.44-2.28-1.63ZM142.29,247c0,3.87.55,7.36,4.66,9,4,1.53,6.55-.77,9.05-3.38,12.14-12.64,24.36-25.2,36.43-37.91a9.54,9.54,0,0,1,7.68-3.37c15.71.18,31.42.06,47.12.09,4,0,7.28-1,8.54-5.19,1.14-3.81-1.26-6.2-3.65-8.58q-47.88-47.85-95.75-95.74c-2.63-2.64-5.24-5.33-9.43-3.7-4.36,1.7-4.66,5.47-4.65,9.46q.06,34.47,0,68.94Q142.31,211.74,142.29,247Zm-87-33c6.06-.34,10.36-4.74,10.35-10.45a10.59,10.59,0,0,0-10.37-10.52c-3.46-.18-6.94,0-10.41-.07-6.56-.23-10.71-4.41-10.92-11-.12-3.64.14-7.29-.12-10.91a10.52,10.52,0,0,0-10-9.8c-5.11-.22-10.18,3.43-10.65,8.43-.61,6.57-1,13.26.49,19.75,3.7,15.82,16.07,24.61,34.23,24.59C50.34,213.94,52.82,214.05,55.3,213.91ZM12.86,128.57C13,135.3,17.31,140,23.27,140s10.57-4.64,10.62-11.27q.15-20.53,0-41.08c0-6.68-4.52-11.11-10.71-11-6,.07-10.17,4.3-10.3,10.87-.15,6.93,0,13.86,0,20.79C12.84,115,12.75,121.81,12.86,128.57ZM203.39,97.73c0,3.63-.16,7.28,0,10.9.32,5.93,4.46,9.91,10.13,10s10.47-3.78,10.72-9.47c.34-7.75.36-15.54,0-23.29-.27-5.64-5.21-9.48-10.87-9.28a10,10,0,0,0-9.93,9.7c-.23,3.78,0,7.6,0,11.4Zm-84,116.12a10.44,10.44,0,0,0,0-20.84c-7.56-.3-15.15-.29-22.71,0a10.44,10.44,0,0,0,0,20.84c3.77.23,7.57,0,11.35.05S115.57,214.09,119.34,213.85Z"/></svg>
                                    <p class="no-margin bold lblack fs14">Select categories to restore</p>
                                </div>
                                <p class="fs13 lblack my4">Please select the categories that you want to restore along with forum. (You must select at least one)</p>
                                <table class="full-width">
                                    <tr>
                                        <th class="category-column">category</th>
                                        <th class="category-desc-column">description</th>
                                        <th class="category-restore-column">restore</th>
                                    </tr>
                                    @foreach($categories as $category)
                                        <tr class="category-row">
                                            <input type="hidden" class="category-id" autocomplete="off" value="{{ $category->id }}">
                                            <td class="bold">{{ $category->category }}</td>
                                            <td>
                                                <div class="expand-box">
                                                    <span class="expandable-text fs13 my4" style="line-height: 1.4">{{ $category->descriptionslice }}</span>
                                                    @if($category->descriptionslice != $category->description)
                                                    <input type="hidden" class="expand-slice-text" value="{{ $category->descriptionslice }}" autocomplete="off">
                                                    <input type="hidden" class="expand-whole-text" value="{{ $category->description }}" autocomplete="off">
                                                    <input type="hidden" class="expand-text-state" value="0" autocomplete="off">
                                                    <span class="pointer expand-button fs12 inline-block bblock bold">{{ __('see all') }}</span>
                                                    <input type="hidden" class="expand-text" value="{{ __('see all') }}">
                                                    <input type="hidden" class="collapse-text" value="{{ __('see less') }}">
                                                    @endif
                                                </div>
                                                <p class="bold lblack no-margin mt8">status : <span class="gray">Archived</span></p>
                                            </td>
                                            <td>
                                                <div class="custom-checkbox-button full-width flex justify-center">
                                                    <div class="custom-checkbox select-category-to-restore-checkbox size15" style="border-radius: 2px">
                                                        <svg class="size10 custom-checkbox-tick none" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M173.9,439.4,7.5,273a25.59,25.59,0,0,1,0-36.2l36.2-36.2a25.59,25.59,0,0,1,36.2,0L192,312.69,432.1,72.6a25.59,25.59,0,0,1,36.2,0l36.2,36.2a25.59,25.59,0,0,1,0,36.2L210.1,439.4a25.59,25.59,0,0,1-36.2,0Z"/></svg>
                                                        <input type="hidden" class="checkbox-status" autocomplete="off" value="0">
                                                        <input type="hidden" class="category-id" value="{{ $category->id }}" autocomplete="off">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if(!$categories->count())
                                    <tr>
                                        <td colspan="4">
                                            <div class="full-center flex-column">
                                                <div class="flex align-center">
                                                    <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"></path></svg>
                                                    <p class="my4 text-center">The forum doesn't contain any categories yet, and therefore, you cannot restore it again.</p>
                                                </div>
                                                <p class="no-margin mt4">The forum require at least one category to be restored (other than announcements).</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                            <div style="margin-top: 18px">
                                <div class="flex align-center mb8">
                                    <svg class="size13 mr4" style="min-width: 14px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M197.63,2.4C199,4.24,201.19,3.45,203,4.08a32,32,0,0,1,21.4,28.77c.14,4,.18,7.93,0,11.88-.26,6.3-4.8,10.58-10.82,10.44-5.84-.13-9.9-4.25-10.17-10.51-.14-3.3.08-6.61-.09-9.91C202.94,27.81,199,23.86,192,23.52c-3-.14-5.94,0-8.91,0-6-.14-10.05-3-11.2-7.82-1.23-5.13.68-9.09,5.92-12.31a5.8,5.8,0,0,0,1-1ZM38.88,2.4c-.22.78-.87.78-1.52.94C24.43,6.58,16.51,14.91,13.46,27.71c-1.34,5.64-.74,11.53-.53,17.3a10.08,10.08,0,0,0,10.5,10.18c5.78,0,10.14-4.29,10.45-10.36.16-3.13,0-6.28,0-9.42C34.05,27.9,38,23.79,45.5,23.51c3.46-.13,6.94.06,10.4-.14,4.87-.28,7.94-3.08,9.31-7.6s-.25-8-3.59-11.09C60.7,3.83,59.05,4,58.73,2.4Zm55.56,0c-.16,1.13-1.22.84-1.87,1.21-4.47,2.56-6.49,7-5.37,11.67,1.16,4.89,4.64,8,9.88,8.1q21.56.23,43.13,0a9.75,9.75,0,0,0,9.7-7.7c1-4.8-.35-8.79-4.57-11.64-.77-.52-2-.44-2.28-1.63ZM142.29,247c0,3.87.55,7.36,4.66,9,4,1.53,6.55-.77,9.05-3.38,12.14-12.64,24.36-25.2,36.43-37.91a9.54,9.54,0,0,1,7.68-3.37c15.71.18,31.42.06,47.12.09,4,0,7.28-1,8.54-5.19,1.14-3.81-1.26-6.2-3.65-8.58q-47.88-47.85-95.75-95.74c-2.63-2.64-5.24-5.33-9.43-3.7-4.36,1.7-4.66,5.47-4.65,9.46q.06,34.47,0,68.94Q142.31,211.74,142.29,247Zm-87-33c6.06-.34,10.36-4.74,10.35-10.45a10.59,10.59,0,0,0-10.37-10.52c-3.46-.18-6.94,0-10.41-.07-6.56-.23-10.71-4.41-10.92-11-.12-3.64.14-7.29-.12-10.91a10.52,10.52,0,0,0-10-9.8c-5.11-.22-10.18,3.43-10.65,8.43-.61,6.57-1,13.26.49,19.75,3.7,15.82,16.07,24.61,34.23,24.59C50.34,213.94,52.82,214.05,55.3,213.91ZM12.86,128.57C13,135.3,17.31,140,23.27,140s10.57-4.64,10.62-11.27q.15-20.53,0-41.08c0-6.68-4.52-11.11-10.71-11-6,.07-10.17,4.3-10.3,10.87-.15,6.93,0,13.86,0,20.79C12.84,115,12.75,121.81,12.86,128.57ZM203.39,97.73c0,3.63-.16,7.28,0,10.9.32,5.93,4.46,9.91,10.13,10s10.47-3.78,10.72-9.47c.34-7.75.36-15.54,0-23.29-.27-5.64-5.21-9.48-10.87-9.28a10,10,0,0,0-9.93,9.7c-.23,3.78,0,7.6,0,11.4Zm-84,116.12a10.44,10.44,0,0,0,0-20.84c-7.56-.3-15.15-.29-22.71,0a10.44,10.44,0,0,0,0,20.84c3.77.23,7.57,0,11.35.05S115.57,214.09,119.34,213.85Z"/></svg>
                                    <p class="no-margin bold lblack fs14">Select forum <span class="blue">status</span></p>
                                </div>
                                <p class="fs13 lblack my4">Please select the forum status after restoring. (all selected categories will be restored and turned to live, and non-selected categories will remain archived)</p>
                                <div class="radio-group">
                                    <!-- live -->
                                    <div class="flex align-center custom-radio-button pointer select-forum-status-after-restore" style="padding: 6px; border: 1px solid #c8c8c8; border-radius: 4px;">
                                        <div class="custom-radio-background">
                                            <div class="custom-radio custom-radio-checked size10">
                                                <span class="radio-check-tick size8"></span>
                                                <input type="hidden" class="radio-status" autocomplete="off" value="1">
                                            </div>
                                        </div>
                                        <div class="ml4">
                                            <div class="flex align-center">
                                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.55,60.69c8,0,16,.06,24-.13,2.82-.06,4.05.4,3.92,3.66-.28,7-.16,14,0,21.08,0,2.19-.38,3.24-2.91,3.17-8.33-.22-16.66-.22-25-.3Z"/><path d="M3.55,116.64c8.16,0,16.33,0,24.49-.17,2.35,0,3.51.34,3.43,3.13q-.3,10.79,0,21.57c.08,2.79-1.08,3.17-3.43,3.13-8.16-.15-16.33-.13-24.49-.17Z"/><path d="M3.55,172.6c8.32-.09,16.65-.08,25-.3,2.53-.07,2.94,1,2.91,3.17-.1,7.19-.17,14.39,0,21.58.07,2.76-1,3.18-3.41,3.14-8.17-.13-16.34-.09-24.51-.11Z"/><path d="M59.5,256c0-8,.07-16-.12-24-.07-2.82.39-4,3.65-3.92,7,.29,14,.16,21.08,0,2.19,0,3.24.39,3.17,2.92-.22,8.32-.21,16.65-.3,25Z"/><path d="M115.45,256c0-8.17,0-16.33-.17-24.5,0-2.35.34-3.5,3.13-3.43q10.78.31,21.57,0c2.79-.07,3.17,1.08,3.13,3.43-.15,8.17-.13,16.33-.17,24.5Z"/><path d="M171.41,256c-.09-8.33-.08-16.66-.3-25-.07-2.53,1-2.95,3.17-2.92,7.19.11,14.39.17,21.57,0,2.77-.08,3.19,1,3.15,3.4-.14,8.17-.09,16.35-.11,24.52Z"/><path d="M3.55,228.55c8.43-.86,16.89-.12,25.34-.39,1.88-.06,2.6.65,2.53,2.54-.27,8.44.47,16.9-.39,25.34H25.14c-.53-1.53-2.07-1.38-3.19-1.8A28.18,28.18,0,0,1,6.41,240.33c-1-1.94-.77-4.49-2.86-5.89Z" style="fill:#020202"/><path d="M3.55,26.33c2.28-1.85,2.18-4.87,3.57-7.21,4.71-8,11.59-12.5,20.6-14.11,2.58-.46,3.86-.12,3.76,3-.23,7.16-.1,14.34-.05,21.51,0,1.8-.09,3.16-2.52,3.07-8.45-.31-16.92.46-25.36-.4Z" style="fill:#020202"/><path d="M227.36,256c-.86-8.44-.1-16.91-.4-25.36-.09-2.41,1.24-2.53,3-2.52,7.17,0,14.34.16,21.51,0,3.08-.09,3.42,1.09,3.07,3.73a27.46,27.46,0,0,1-21.88,23.24c-.67.12-1.26.17-1.42,1Z" style="fill:#020202"/><path d="M3.55,234.44c2.09,1.4,1.84,3.95,2.86,5.89A28.18,28.18,0,0,0,22,254.24c1.12.42,2.66.27,3.19,1.8-6.38,0-12.76-.12-19.14.06-2.12.06-2.58-.4-2.52-2.52C3.66,247.21,3.55,240.82,3.55,234.44Z" style="fill:#fafafa"/><path d="M59.44,130.39c0-21.92.06-43.84-.07-65.76,0-3.07.61-4.1,3.94-4.09q66,.18,132,0c3.13,0,3.72.91,3.71,3.83q-.14,66,0,132c0,2.9-.54,3.85-3.69,3.85q-66-.18-132,0c-3.3,0-4-1-4-4.08C59.5,174.23,59.44,152.31,59.44,130.39Zm27.79-.53c0,12.75.13,25.49-.08,38.23-.06,3.5,1,4.35,4.4,4.33q37.74-.19,75.48,0c3.1,0,4.22-.65,4.2-4q-.21-38,0-76c0-3.27-1-4.09-4.14-4.08-25.16.12-50.32.17-75.48,0-3.93,0-4.51,1.34-4.45,4.78C87.35,105.35,87.23,117.61,87.23,129.86Z"/><path d="M73.26,4.74c3.75,0,7.51.1,11.25,0,2.13-.09,2.8.6,2.77,2.74-.12,7.5-.08,15,0,22.51,0,1.73-.32,2.69-2.38,2.67q-11.49-.13-23,0c-2,0-2.49-.69-2.47-2.55.07-7.66.09-15.33,0-23,0-2.06.85-2.42,2.61-2.37C65.76,4.8,69.51,4.74,73.26,4.74Z"/><path d="M115.32,18.62c0-3.59.18-7.18-.06-10.75-.18-2.69.87-3.23,3.32-3.19,7.17.15,14.34.14,21.51,0,2.31-.05,3.08.57,3,3q-.23,11,0,22c0,2.4-.77,3-3.07,3q-11-.18-22,0c-2.13,0-2.86-.64-2.77-2.77C115.43,26.12,115.32,22.37,115.32,18.62Z"/><path d="M184.65,32.59c-3.59,0-7.18-.11-10.76,0-2.16.08-2.8-.7-2.77-2.8.1-7.5.13-15,0-22.51C171.06,5,172,4.68,174,4.7c7.33.09,14.67.13,22,0,2.36,0,3,.66,3,3-.15,7.34-.17,14.68,0,22,.06,2.52-.87,3-3.11,2.93C192.16,32.47,188.4,32.59,184.65,32.59Z"/><path d="M240.61,88c-4.37,0-10.09,1.68-12.73-.45S227.19,79.36,227,75c-.15-3.74.13-7.51-.09-11.25-.15-2.66.87-3.25,3.34-3.2,7.17.15,14.35.13,21.52,0,2.21,0,3.16.38,3.11,2.89-.17,7.34-.16,14.68,0,22,.05,2.4-.68,3.1-3,3-3.74-.19-7.5,0-11.25,0Z"/><path d="M254.84,130.87c0,3.42-.18,6.86.06,10.26.18,2.7-.87,3.23-3.33,3.18q-10.5-.23-21,0c-2.61.06-3.72-.49-3.63-3.41.21-7,.21-14,0-21-.09-2.92,1-3.48,3.63-3.42q10.5.23,21,0c2.45,0,3.5.47,3.33,3.17C254.66,123.36,254.84,127.12,254.84,130.87Z"/><path d="M241.78,172.35c3.71.38,9.7-1.95,12.28.88,2.23,2.44.74,8.35.76,12.72,0,4.54,1.61,10.61-.68,13.23-2.64,3-8.85.78-13.51.92-4.36.12-10.24,1.5-12.72-.72-2.86-2.57-.71-8.55-.89-13-.15-3.74.07-7.5-.07-11.25-.08-2.15.69-2.84,2.8-2.77C233.5,172.45,237.25,172.35,241.78,172.35Z"/><path d="M239.83,32.59c-3.59-.34-9.25,1.87-12-.78s-.68-8.35-.85-12.7c-.14-3.75.14-7.52-.08-11.26C226.77,5,228,4.68,230.39,5c12.12,1.36,22.68,11.9,24.23,24.09.36,2.86-.39,3.76-3.24,3.59C247.8,32.43,244.19,32.59,239.83,32.59Z" style="fill:#020202"/></svg>
                                                <span class="bold lblack">live</span>
                                            </div>
                                            <p class="my4 fs12">The forum will be live and accessible by users after restore</p>
                                        </div>
                                        <input type="hidden" class="status" value="live" autocomplete="off">
                                    </div>
                                    <!-- closed -->
                                    <div class="flex align-center custom-radio-button pointer mt8 select-forum-status-after-restore" style="padding: 6px; border: 1px solid #c8c8c8; border-radius: 4px;">
                                        <div class="custom-radio-background">
                                            <div class="custom-radio size10">
                                                <span class="radio-check-tick size8 none"></span>
                                                <input type="hidden" class="radio-status" autocomplete="off" value="0">
                                            </div>
                                        </div>
                                        <div class="ml4">
                                            <div class="flex align-center">
                                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M129.39,13.08A116.22,116.22,0,0,1,245.46,130.51c-.54,64-53,115.73-116.79,115.2-64.79-.54-116.24-52.6-115.81-117.18C13.29,64.45,65.57,12.65,129.39,13.08Zm0,21.11C76,34.38,33.77,77,34,130.5c.19,51.8,43.32,94.23,95.7,94.12,52-.11,94.85-43.1,94.75-95.1C224.3,76.91,181.55,34,129.43,34.19Zm41.32,48.16a10.27,10.27,0,0,0-11.86,2.37c-9,9-18.09,17.91-27,27-2.1,2.15-3.23,2.32-5.42,0-8.5-8.79-17.22-17.38-25.91-26-5.58-5.53-12-6-16.55-1.27s-3.86,10.76,1.52,16.19c8.61,8.69,17.21,17.39,26,25.92,2.17,2.1,2.3,3.25,0,5.43-8.67,8.39-17.11,17-25.64,25.54-1.88,1.88-3.74,3.74-4.44,6.43a10.62,10.62,0,0,0,4.81,12c4.16,2.44,9.21,1.84,13.15-2,9.09-8.9,18.12-17.88,27-27,2.14-2.19,3.27-2.25,5.43,0,8.51,8.78,17.24,17.35,25.89,26,1.76,1.76,3.56,3.42,6.09,4.06a10.57,10.57,0,0,0,11.94-4.84c2.42-4.16,1.82-9.19-2-13.14-8.89-9.1-17.86-18.13-27-27-2.26-2.2-2.09-3.34.06-5.43,8.65-8.41,17.11-17,25.65-25.55,2.5-2.5,4.69-5.15,4.57-7.68C177,87.54,175,84.1,170.75,82.35Z"/></svg>
                                                <span class="bold lblack">closed</span>
                                            </div>
                                            <p class="my4 fs12">The forum will be closed after restoring; Admins then decide whether to open it later or not</p>
                                        </div>
                                        <input type="hidden" class="status" value="closed" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <p class="my8 bold forum-color">Confirmation</p>
                            <p class="no-margin mb4 bblack">Please type <strong>{{ auth()->user()->username }}::restore-forum::{{ $forum->slug }}</strong> to confirm.</p>
                            <div>
                                <input type="text" autocomplete="off" class="full-width input-style-1" id="restore-forum-confirm-input" style="padding: 8px 10px">
                                <input type="hidden" id="restore-forum-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}::restore-forum::{{ $forum->slug }}">
                            </div>
                            <div class="flex" style="margin-top: 12px">
                                <div class="flex align-center full-width">
                                    <div id="restore-forum-button" class="disabled-green-button-style green-button-style full-center full-width">
                                        <div class="relative size14 mr4">
                                            <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"/><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"/></svg>
                                            <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                            </svg>
                                        </div>
                                        <span class="fs13">I understand, restore this forum</span>
                                        <input type="hidden" class="forum-id" value="{{ $forum->id }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="flex" style="margin-top: 12px">
                    <!-- forum informations section -->
                    <div class="half-width pr8">
                        <input type="hidden" class="selected-forum-id" autocomplete="off" value="{{ $forum->id }}">
                        <div class="flex">
                            <svg class="size24 mr8" style="margin-top: 2px" fill="#202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                {!! $forum->icon !!}
                            </svg>
                            <div>
                                @php $fscolor = ($status->slug == 'live') ? 'green' : (($status->slug == 'closed') ? 'red' : (($status->slug == 'under-review') ? 'blue' : 'gray' )); @endphp
                                <h2 class="forum-color fs26 no-margin">{{ $forum->forum }} Forum - <span class="{{ $fscolor }}">{{ $status->status }}</span></h2>
                                <p class="bold no-margin fs13">slug : {{ $forum->slug }}</p>
                            </div>
                        </div>
                        <div class="mt4 fs13">
                            <p class="bold bo-margin mb4 forum-color fs14">Description :</p>
                            <div class="expand-box">
                                <span class="expandable-text fs13 my4 forum-description" style="line-height: 1.4">{{ $forum->descriptionmediumslice }}</span>
                                @if($forum->descriptionmediumslice != $forum->description)
                                <input type="hidden" class="expand-slice-text" value="{{ $forum->descriptionmediumslice }}" autocomplete="off">
                                <input type="hidden" class="expand-whole-text" value="{{ $forum->description }}" autocomplete="off">
                                <input type="hidden" class="expand-text-state" value="0" autocomplete="off">
                                <span class="pointer expand-button fs12 inline-block bblock bold">{{ __('see all') }}</span>
                                <input type="hidden" class="expand-text" value="{{ __('see all') }}">
                                <input type="hidden" class="collapse-text" value="{{ __('see less') }}">
                                @endif
                            </div>
                        </div>
                        <!-- forum statistics -->
                        <div class="flex align-center mt8">
                            <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M400,32H48A48,48,0,0,0,0,80V432a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48V80A48,48,0,0,0,400,32ZM160,368a16,16,0,0,1-16,16H112a16,16,0,0,1-16-16V240a16,16,0,0,1,16-16h32a16,16,0,0,1,16,16Zm96,0a16,16,0,0,1-16,16H208a16,16,0,0,1-16-16V144a16,16,0,0,1,16-16h32a16,16,0,0,1,16,16Zm96,0a16,16,0,0,1-16,16H304a16,16,0,0,1-16-16V304a16,16,0,0,1,16-16h32a16,16,0,0,1,16,16Z"/></svg>
                            <span class="bold block lblack">Forum statistics</span>
                        </div>
                        <div style="margin: 16px 0 16px 8px" class="flex align-end">
                            <div class="flex align-center">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130,17.11h97.27c11.82,0,15.64,3.73,15.64,15.34q0,75.07,0,150.16c0,11.39-3.78,15.13-15.22,15.13-2.64,0-5.3.12-7.93-.06a11.11,11.11,0,0,1-10.53-9.38c-.81-5.69,2-11,7.45-12.38,3.28-.84,3.52-2.36,3.51-5.06-.07-27.15-.11-54.29,0-81.43,0-3.68-1-4.69-4.68-4.68q-85.63.16-171.29,0c-3.32,0-4.52.68-4.5,4.33q.26,41,0,81.95c0,3.72,1.3,4.53,4.56,4.25a45.59,45.59,0,0,1,7.39.06,11.06,11.06,0,0,1,10.58,11c0,5.62-4.18,10.89-9.91,11.17-8.43.4-16.92.36-25.36,0-5.16-.23-8.82-4.31-9.68-9.66a33,33,0,0,1-.24-5.27q0-75.08,0-150.16c0-11.61,3.81-15.34,15.63-15.34Zm22.49,45.22c16.56,0,33.13,0,49.7,0,5.79,0,13.59,2,16.83-.89,3.67-3.31.59-11.25,1.19-17.13.4-3.92-1.21-4.54-4.73-4.51-19.21.17-38.42.08-57.63.08-22.73,0-45.47.11-68.21-.1-4,0-5.27,1-4.92,5a75.62,75.62,0,0,1,0,12.68c-.32,3.89.78,5,4.85,5C110.54,62.21,131.51,62.33,152.49,62.33ZM62.3,51.13c0-11.26,0-11.26-11.45-11.26h-.53c-10.47,0-10.47,0-10.47,10.71,0,11.75,0,11.75,11.49,11.75C62.3,62.33,62.3,62.33,62.3,51.13ZM102,118.66c25.79.3,18.21-2.79,36.49,15.23,18.05,17.8,35.89,35.83,53.8,53.79,7.34,7.35,7.3,12.82-.13,20.26q-14.94,15-29.91,29.87c-6.86,6.81-12.62,6.78-19.5-.09-21.3-21.28-42.53-42.64-63.92-63.84a16.11,16.11,0,0,1-5.24-12.62c.23-9.86,0-19.73.09-29.59.07-8.71,4.24-12.85,13-13C91.81,118.59,96.92,118.66,102,118.66ZM96.16,151c.74,2.85-1.53,6.66,1.41,9.6,17.66,17.71,35.39,35.36,53,53.11,1.69,1.69,2.59,1.48,4.12-.12,4.12-4.34,8.24-8.72,12.73-12.67,2.95-2.59,2.36-4-.16-6.49-15.68-15.46-31.4-30.89-46.63-46.79-4.56-4.76-9.1-6.73-15.59-6.35C96.18,141.8,96.16,141.41,96.16,151Z"/></svg>
                                <span>threads: <span class="bold">{{ $statistics['threadscount'] }}</span></span>
                            </div>
                            <div class="gray mx8 fs10">•</div>
                            <div class="flex align-center">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                                <span>replies: <span class="bold">{{ $statistics['postscount'] }}</span></span>
                            </div>
                            <div class="gray mx8 fs10">•</div>
                            <div>
                                <div class="flex align-center mb4">
                                    <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><g id="Layer_1_copy" data-name="Layer 1 copy"><path d="M287.81,219.72h-238c-21.4,0-32.1-30.07-17-47.61l119-138.2c9.4-10.91,24.6-10.91,33.9,0l119,138.2C319.91,189.65,309.21,219.72,287.81,219.72ZM224.22,292l238,.56c21.4,0,32,30.26,16.92,47.83L359.89,478.86c-9.41,10.93-24.61,10.9-33.9-.08l-118.75-139C192.07,322.15,202.82,292,224.22,292Z" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:49px"/></g></svg>
                                    <span class="fs13 bold">Votes</span>
                                </div>
                                <div class="flex align-center ml8">
                                    <span>thread: <span class="bold">{{ $statistics['threadsvotescount'] }}</span></span>
                                    <div class="gray mx8 fs10">•</div>
                                    <span>replies: <span class="bold">{{ $statistics['postsvotescount'] }}</span></span>
                                </div>
                            </div>
                            <div class="gray mx8 fs10">•</div>
                            <div>
                                <div class="flex align-center mb4">
                                    <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 391.84 391.84">
                                        <path d="M273.52,56.75A92.93,92.93,0,0,1,366,149.23c0,93.38-170,185.86-170,185.86S26,241.25,26,149.23A92.72,92.72,0,0,1,185.3,84.94a14.87,14.87,0,0,0,21.47,0A92.52,92.52,0,0,1,273.52,56.75Z" style="fill:none;stroke:#1c1c1c;stroke-miterlimit:10;stroke-width:45px"/>
                                    </svg>
                                    <span class="fs13 bold">Likes</span>
                                </div>
                                <div class="flex align-center ml8">
                                    <span>thread: <span class="bold">{{ $statistics['threadslikescount'] }}</span></span>
                                    <div class="gray mx8 fs10">•</div>
                                    <span>replies: <span class="bold">{{ $statistics['postslikescount'] }}</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- categories preview -->
                    <div class="half-width categories-section" style="padding: 12px; border: 1px solid #ccc; border-radius: 3px;">
                        <h2 class="forum-color fs26 no-margin mb8">Categories</h2>
                        <table>
                            <tr>
                                <th class="category-column">category</th>
                                <th class="category-desc-column">description</th>
                                <th class="category-state-column">state</th>
                            </tr>
                            @foreach($categories as $category)
                                <tr class="category-row">
                                    <input type="hidden" class="category-id" autocomplete="off" value="{{ $category->id }}">
                                    <td class="bold">{{ $category->category }}</td>
                                    <td>{{ $category->descriptionslice }}</td>
                                    <td class="bold gray">Archived</td>
                                </tr>
                            @endforeach
                            @if(!$categories->count())
                            <tr>
                                <td colspan="4">
                                    <div class="full-center">
                                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"></path></svg>
                                        <p class="my4 text-center">The forum doesn't contain any categories yet.</p>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
                <div class="section-style flex" style="margin: 12px 0">
                    <svg class="size14 mr8 mt2" style="min-width: 14px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"></path></svg>
                    <div class="fs13">
                        <p class="no-margin">Please don't forget to share an announcement on general forum to inform users about restoration of this forum.</p>    
                    </div>
                </div>
                @if(!$canrestore)
                <div class="section-style my8">
                    <div class="flex fs13">
                        <svg class="size16 mr4" style="min-width: 16px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M133.28,5.08h5.82c9.12,3.68,11.64,7.49,11.63,17.56q0,41.69,0,83.36a33.18,33.18,0,0,0,.09,4.35c.31,2.52,1.7,4.18,4.37,4.33,2.94.17,4.49-1.56,5-4.22a23.31,23.31,0,0,0,.13-4.35q0-37.8,0-75.6c0-9.49,5.91-15.89,14.48-15.79,8.25.09,14.27,6.68,14.25,15.71q-.06,42.41-.18,84.8a27.74,27.74,0,0,0,.18,4.83c.48,2.7,2.11,4.43,5,4.2,2.58-.2,4-1.82,4.27-4.43.08-.8.07-1.61.07-2.42q0-28.35-.08-56.7c0-4.12.44-8.06,2.94-11.5A14.34,14.34,0,0,1,217.17,44c6.35,2,10.1,7.94,10.09,16q-.06,61.06-.12,122.13a121.16,121.16,0,0,1-.74,13c-3.19,28.63-19.47,47.82-47.27,55.18-16.37,4.33-33,3.7-49.46.47-20-3.93-36.55-13.65-48.09-30.64-15.76-23.21-31-46.74-46.51-70.16a20.9,20.9,0,0,1-2.13-4.32c-4.68-12.84,4.91-25.12,18.14-23.18,5.55.81,9.81,3.87,13.1,8.36,6.31,8.63,12.63,17.25,19.68,26.87,0-16.64,0-31.95,0-47.25q0-35.13,0-70.27c0-7.58,3.18-12.62,9.24-15,10.31-4,19.76,3.91,19.66,16.09-.19,22.29-.11,44.58-.16,66.87,0,3.33.51,6.46,4.68,6.48s4.75-3.09,4.75-6.42c0-28.11.2-56.22-.13-84.33C121.79,14.87,124.51,8.36,133.28,5.08Z"/></svg>
                        <div>
                            <p class="no-margin">You <strong>cannot restore forums</strong> because you don't have permission. If you think this forum should be restored, please contact a super admin.</p>
                        </div>
                    </div>
                </div>
                @endif
                <div class="flex align-center" style="margin: 16px 0">
                    @if($canrestore)
                    <div class="open-forum-restore-confirmation-dialog fs13 typical-button-style flex align-center mr8">
                        <svg fill="white" class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"/><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"/></svg>
                        <div class="fs12 bold">{{ __('Confirm forum restore') }}</div>
                    </div>
                    @else
                    <div class="typical-button-style disabled-typical-button-style flex align-center mr8">
                        <svg class="size14 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"/><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"/></svg>
                        <div>{{ __('Restore forum') }}</div>
                    </div>
                    @endif
                    <a href="{{ route('admin.forum.and.categories.dashboard') . '?selectforum=' . $forum->id }}" class="no-underline bblack bold">{{ __('Return to dashboard') }}</a>
                </div>
            @endif
        @endif
    </div>
@endsection