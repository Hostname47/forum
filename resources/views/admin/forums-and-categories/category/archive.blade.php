@extends('layouts.admin')

@section('title', 'Admin - Archive category')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.forums-and-categories', 'subpage'=>'forums-and-categories-category-archive'])
@endsection

@push('scripts')
<script src="{{ asset('js/admin/forums-and-categories/fac.js') }}" defer></script>
<script src="{{ asset('js/admin/forums-and-categories/category.js') }}" defer></script>
@endpush

@section('content')
    <div class="flex align-center space-between top-page-title-box">
        <div class="flex align-center">
            <svg class="mr8 size20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.13,22.58c1.78.15,3.56.41,5.34.41,17.56,0,35.12.06,52.68,0,2.72,0,4.05.29,4.05,3.64Q65,130,65.19,233.42c0,3.25-1.16,3.7-4,3.7-19.36,0-38.72.1-58.08.18ZM48,74.3c0-9.5-.05-19,0-28.51,0-2.41-.49-3.52-3.24-3.45-7,.18-14.09.2-21.13,0-2.91-.08-3.54,1-3.52,3.68q.14,28.75,0,57.51c0,3,1.11,3.54,3.75,3.49,6.71-.15,13.44-.25,20.15,0,3.44.14,4.07-1.17,4-4.24C47.86,93.31,48,83.81,48,74.3ZM34.08,189.91a13.85,13.85,0,0,0-13.84,13.65,14.05,14.05,0,0,0,13.62,14,13.9,13.9,0,0,0,14-14A13.62,13.62,0,0,0,34.08,189.91ZM140.13,34.6l42.49-11.33c4.42-1.19,8.89-2.23,13.24-3.66,3.1-1,4.36-.48,5.25,2.93,6,23.28,12.36,46.49,18.59,69.73,11.43,42.67,22.79,85.37,34.39,128,1.13,4.13.34,5.37-3.75,6.4q-25.69,6.5-51.18,13.74c-3.38,1-4.14-.11-4.87-2.88q-23.65-88.69-47.4-177.37a212.52,212.52,0,0,0-6.76-21.85V43q0,94.28.11,188.56c0,4.5-1.13,5.67-5.61,5.59-17.39-.27-34.79-.2-52.18,0-3.42,0-4.4-.84-4.4-4.34q.17-102.9,0-205.79c0-3.38,1.07-4.08,4.17-4.06,17.89.12,35.77.15,53.66,0,3.45,0,4.7.91,4.3,4.36A65,65,0,0,0,140.13,34.6Zm-17,40.07c0-9.5-.13-19,.07-28.5.06-3.05-.82-3.93-3.86-3.84-6.87.22-13.75.18-20.63,0-2.56-.06-3.36.71-3.35,3.3q.13,29,0,58c0,2.53.72,3.44,3.33,3.38,6.88-.16,13.76-.2,20.64,0,3,.09,3.93-.8,3.87-3.86C123,93.68,123.14,84.17,123.14,74.67Zm81.55,27.88c-.05-.16-.11-.31-.15-.47q-7.72-28.92-15.42-57.85c-.49-1.84-1.46-2.3-3.23-1.81q-10.89,3-21.8,5.85c-1.65.44-2.47.89-1.89,3,5.2,19.09,10.26,38.23,15.35,57.36.41,1.52.73,2.61,3,2,7.37-2.16,14.83-4,22.26-6C203.79,104.32,205.26,104.36,204.69,102.55Zm-95.23,87.38a13.53,13.53,0,0,0-14,13.37,13.83,13.83,0,0,0,13.73,14.23,14.09,14.09,0,0,0,13.87-13.73A13.88,13.88,0,0,0,109.46,189.93ZM216.65,214.8a13.77,13.77,0,0,0,13.9-13.53,14.08,14.08,0,0,0-14-14.07,13.9,13.9,0,0,0-13.56,14A13.51,13.51,0,0,0,216.65,214.8Z"/></svg>
            <h1 class="fs22 no-margin lblack">{{ __('Archive category') }}</h1>
        </div>
        <div class="flex align-center height-max-content">
            <div class="flex align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                <a href="{{ route('admin.dashboard') }}" class="link-path">{{ __('Home') }}</a>
            </div>
            @if(!is_null($category))
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M18.66,68.29c-.45-26.81,21.7-49.6,48.58-50a49.62,49.62,0,0,1,50.68,48.86c.58,27.16-21.52,50.15-48.55,50.49A49.71,49.71,0,0,1,18.66,68.29ZM68.23,97.81A29.81,29.81,0,1,0,38.55,68.19,29.83,29.83,0,0,0,68.23,97.81ZM18.66,191.6c-.51-26.59,21.39-49.43,48-50a49.63,49.63,0,0,1,51.25,48.77c.63,26.94-21.21,50-48,50.56A49.72,49.72,0,0,1,18.66,191.6ZM68.3,221a29.81,29.81,0,1,0-29.75-29.55A29.81,29.81,0,0,0,68.3,221ZM240.12,67.6c.54,26.57-21.44,49.49-48,50.07a49.7,49.7,0,0,1-51.29-48.76c-.73-26.83,21.25-50,48-50.57C217,17.73,239.54,39.35,240.12,67.6Zm-19.9.32A29.77,29.77,0,1,0,190.29,97.8,29.76,29.76,0,0,0,220.22,67.92Zm19.9,122.93c.52,26.58-21.46,49.48-48,50a49.69,49.69,0,0,1-51.26-48.79c-.71-26.83,21.28-50,48-50.53C217.05,141,239.57,162.61,240.12,190.85Zm-19.9.18a29.77,29.77,0,1,0-29.81,30A29.74,29.74,0,0,0,220.22,191Z"/></svg>
                <a href="{{ route('admin.category.archive') }}" class="link-path">{{ __('Select category to archive') }}</a>
            </div>
            @endif
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Archive category') }}</span>
            </div>
        </div>
    </div>
    <div id="admin-main-content-box">
        <!-- select category to archive -->
        @if(is_null($category))
        <div class="full-center flex-column" style="margin-top: 25px">
            <div class="flex flex-column align-center select-forum-section">
                <!-- This input is used to determine which category status to exclude -->
                <input type="hidden" class="status-excluded" value="archived,under-review" autocomplete="off">
                <p class="fs13 my8">Select the forum where category belongs</p>
                <p class="fs13 my4 none" id="forum-selected-p"><span class="mr8">Forum selected:</span> <span class="bold" id="forum-selected"></span></p>
                <div class="relative flex align-center justify-center">
                    <div class="relative flex align-center pointer fs13 button-with-suboptions py4">
                        <span class="selected-forum-name forum-color fs14 bold">Select a forum</span>
                        <svg class="size7 mx4 mt2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                        <div class="spinner size14 opacity0 absolute" id="select-forum-spinner" fill="#2ca0ff" style="left: calc(100% + 4px)">
                            <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                        </div>
                    </div>
                    <div class="suboptions-container suboptions-container-right-style scrolly mt4" style="max-height: 300px; right: auto">
                        @include('partials.admin.forums.forums-list-for-categories-ops-selectable', ['forums'=>$forums, 'operation_class'=>'select-forum-categories-button'])
                    </div>
                </div>
            </div>

            <div style="margin: 16px 0" class="gray height-max-content mx4 fs10">•</div>

            <div class="flex flex-column align-center" id="select-categories-section">
                <p class="fs13 my8">Select the category to archive</p>
                <div class="categories-wrapper scrolly">
                    <div id="categories-scrollable-box" class="flex flex-column">
                        <div class="flex align-center" style="margin: 8px 12px">
                            <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                            <p class="fs13 gray no-margin">Please select a forum to list its categories</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.category.archive') }}" class="simple-suboption black full-width no-underline forum-category-select-component none">
                        <div class="flex align-center">
                            <span class="category-text black"></span>
                            <div class="gray height-max-content mx8 fs10">•</div>
                            <span class="category-status fs13 bold"></span>
                        </div>
                    </a>
                    <div class="flex align-center none" id="no-categories-yet" style="margin: 8px 12px">
                        <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <p class="fs13 gray no-margin">This forum doesn't have categories yet</p>
                    </div>
                </div>
                <style>
                    .categories-wrapper {
                        padding: 6px;
                        background-color: white;
                        border-radius: 4px;
                        border: 1px solid rgb(177, 177, 177);
                        width: max-content;
                        max-height: 250px;
                    }
                </style>
            </div>
        </div>
        <!-- handle archive -->
        @else
            @if(Session::has('message'))
                <div class="green-message-container my8">
                    <p class="green-message">{{ Session::get('message') }}</p>
                </div>
            @endif

            @if($canarchive)
            <!-- archive category viewer -->
            <div id="category-archive-viewer" class="global-viewer flex justify-center none">
                <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
                <div class="global-viewer-content-box viewer-box-style-1" style="margin-top: 110px">
                    <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                        <div class="flex align-center">
                            <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 331.53 331.53"><path d="M197.07,216.42a11,11,0,0,1-11,11H145.46a11,11,0,0,1,0-22h40.61A11,11,0,0,1,197.07,216.42ZM331.53,51.9v68.32a11,11,0,0,1-11,11H313.4V279.63a11,11,0,0,1-11,11H29.13a11,11,0,0,1-11-11V131.22H11a11,11,0,0,1-11-11V51.9a11,11,0,0,1,11-11H320.53A11,11,0,0,1,331.53,51.9ZM291.4,131.22H221.24a56.55,56.55,0,0,1-110.94,0H40.13V268.63H291.4ZM165.77,154.77a34.61,34.61,0,0,0,32.75-23.55H133A34.6,34.6,0,0,0,165.77,154.77ZM309.53,62.9H22v46.32H309.53Z"/></svg>
                            <span class="fs20 bold forum-color">{{ __('Archive Category') }}</span>
                        </div>
                        <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                    </div>
                    <div style="padding: 14px">
                        <h2 class="mb8 no-margin forum-color fs18">Archive Category : <span class="black">{{ $category->category }}</span></h2>
                        <div class="simple-line-separator my8"></div>
                        <div class="flex" style="margin-bottom: 12px">
                            <svg class="size18 mr8" style="margin-top: 2px" fill="#202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                {!! $forum->icon !!}
                            </svg>
                            <div>
                                <h2 class="forum-color fs20 no-margin">{{ $forum->forum }} Forum</h2>
                                <div class="flex">
                                    <svg class="size14 mx8" style="margin-top: 3px" fill="#d2d2d2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"/></svg>
                                    <p class="my4 bold forum-color">category : {{ $category->category }}</p>
                                </div>
                            </div>
                        </div>
                        <p class="fs13 my8" style="line-height: 1.5">The category will be moved to admin archives, in case of you decide to restore it again.</p>
                        <p class="fs13 my8" style="line-height: 1.5">If you want to delete this category (permanently), proceed this action by delete the category from admin archives.</p>
                        <p class="fs13 no-margin" style="line-height: 1.5"> the <strong>category is archived</strong> every activity within the category will be archived & hidden from public access. Are you sure you want to archive this category ?</p>

                        <p class="bold forum-color" style="margin: 12px 0 4px 0">Confirmation</p>
                        <p class="no-margin mb4 bblack">Please type <strong>{{ $forum->forum }}::{{ $category->category }}</strong> to confirm.</p>
                        <div>
                            <input type="text" autocomplete="off" class="full-width input-style-1" id="archive-category-confirm-input" style="padding: 8px 10px">
                            <input type="hidden" id="archive-category-confirm-value" autocomplete="off" value="{{ $forum->forum }}::{{ $category->category }}">
                        </div>
                        <div class="flex" style="margin-top: 12px">
                            <div class="flex align-center full-width">
                                <div id="archive-category-button" class="disabled-red-button-style red-button-style full-center full-width">
                                    <div class="relative size14 mr4">
                                        <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.13,22.58c1.78.15,3.56.41,5.34.41,17.56,0,35.12.06,52.68,0,2.72,0,4.05.29,4.05,3.64Q65,130,65.19,233.42c0,3.25-1.16,3.7-4,3.7-19.36,0-38.72.1-58.08.18ZM48,74.3c0-9.5-.05-19,0-28.51,0-2.41-.49-3.52-3.24-3.45-7,.18-14.09.2-21.13,0-2.91-.08-3.54,1-3.52,3.68q.14,28.75,0,57.51c0,3,1.11,3.54,3.75,3.49,6.71-.15,13.44-.25,20.15,0,3.44.14,4.07-1.17,4-4.24C47.86,93.31,48,83.81,48,74.3ZM34.08,189.91a13.85,13.85,0,0,0-13.84,13.65,14.05,14.05,0,0,0,13.62,14,13.9,13.9,0,0,0,14-14A13.62,13.62,0,0,0,34.08,189.91ZM140.13,34.6l42.49-11.33c4.42-1.19,8.89-2.23,13.24-3.66,3.1-1,4.36-.48,5.25,2.93,6,23.28,12.36,46.49,18.59,69.73,11.43,42.67,22.79,85.37,34.39,128,1.13,4.13.34,5.37-3.75,6.4q-25.69,6.5-51.18,13.74c-3.38,1-4.14-.11-4.87-2.88q-23.65-88.69-47.4-177.37a212.52,212.52,0,0,0-6.76-21.85V43q0,94.28.11,188.56c0,4.5-1.13,5.67-5.61,5.59-17.39-.27-34.79-.2-52.18,0-3.42,0-4.4-.84-4.4-4.34q.17-102.9,0-205.79c0-3.38,1.07-4.08,4.17-4.06,17.89.12,35.77.15,53.66,0,3.45,0,4.7.91,4.3,4.36A65,65,0,0,0,140.13,34.6Zm-17,40.07c0-9.5-.13-19,.07-28.5.06-3.05-.82-3.93-3.86-3.84-6.87.22-13.75.18-20.63,0-2.56-.06-3.36.71-3.35,3.3q.13,29,0,58c0,2.53.72,3.44,3.33,3.38,6.88-.16,13.76-.2,20.64,0,3,.09,3.93-.8,3.87-3.86C123,93.68,123.14,84.17,123.14,74.67Zm81.55,27.88c-.05-.16-.11-.31-.15-.47q-7.72-28.92-15.42-57.85c-.49-1.84-1.46-2.3-3.23-1.81q-10.89,3-21.8,5.85c-1.65.44-2.47.89-1.89,3,5.2,19.09,10.26,38.23,15.35,57.36.41,1.52.73,2.61,3,2,7.37-2.16,14.83-4,22.26-6C203.79,104.32,205.26,104.36,204.69,102.55Zm-95.23,87.38a13.53,13.53,0,0,0-14,13.37,13.83,13.83,0,0,0,13.73,14.23,14.09,14.09,0,0,0,13.87-13.73A13.88,13.88,0,0,0,109.46,189.93ZM216.65,214.8a13.77,13.77,0,0,0,13.9-13.53,14.08,14.08,0,0,0-14-14.07,13.9,13.9,0,0,0-13.56,14A13.51,13.51,0,0,0,216.65,214.8Z"/></svg>
                                        <div class="spinner size14 opacity0 absolute" style="top: 0; left: 0">
                                            <svg class="size14" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                                        </div>
                                    </div>
                                    <span class="fs13">I understand the consequences, archive this category</span>
                                    <input type="hidden" class="category-id" value="{{ $category->id }}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="section-style my8">
                <span class="bold lblack">Caution</span> 
                <p class="lblack mt4 fs13 no-margin">When a category is archived, everything included within the category will be hidden from public including threads, replies, votes..etc. All the resources within the category will not be deleted, instead it will be archived and hidden. You can later restore the category by going to <a href="{{ route('admin.category.restore') }}" class="blue bold no-underline">restore category</a> page.</p>
                <p class="lblack mt4 fs13 no-margin">If you want to delete the category (permanently), you have to archive it first here, then delete it from archives page.</p>
            </div>

            <div class="flex" style="margin-bottom: 12px">
                <svg class="size20 mr8 mt4" fill="#202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    {!! $forum->icon !!}
                </svg>
                <div>
                    <h2 class="forum-color fs22 no-margin">{{ $forum->forum }} Forum</h2>
                    <div class="flex">
                        <svg class="size14 mx8" style="margin-top: 3px" fill="#d2d2d2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"/></svg>
                        <p class="no-margin bold forum-color" style="margin-top: 6px">category : {{ $category->category }}</p>
                    </div>
                </div>
            </div>

            @if(!$canarchive)
            <div class="red-section-style my8">
                <div class="flex fs13">
                    <svg class="size16 mr4" style="min-width: 16px" fill="rgb(68, 5, 5)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M133.28,5.08h5.82c9.12,3.68,11.64,7.49,11.63,17.56q0,41.69,0,83.36a33.18,33.18,0,0,0,.09,4.35c.31,2.52,1.7,4.18,4.37,4.33,2.94.17,4.49-1.56,5-4.22a23.31,23.31,0,0,0,.13-4.35q0-37.8,0-75.6c0-9.49,5.91-15.89,14.48-15.79,8.25.09,14.27,6.68,14.25,15.71q-.06,42.41-.18,84.8a27.74,27.74,0,0,0,.18,4.83c.48,2.7,2.11,4.43,5,4.2,2.58-.2,4-1.82,4.27-4.43.08-.8.07-1.61.07-2.42q0-28.35-.08-56.7c0-4.12.44-8.06,2.94-11.5A14.34,14.34,0,0,1,217.17,44c6.35,2,10.1,7.94,10.09,16q-.06,61.06-.12,122.13a121.16,121.16,0,0,1-.74,13c-3.19,28.63-19.47,47.82-47.27,55.18-16.37,4.33-33,3.7-49.46.47-20-3.93-36.55-13.65-48.09-30.64-15.76-23.21-31-46.74-46.51-70.16a20.9,20.9,0,0,1-2.13-4.32c-4.68-12.84,4.91-25.12,18.14-23.18,5.55.81,9.81,3.87,13.1,8.36,6.31,8.63,12.63,17.25,19.68,26.87,0-16.64,0-31.95,0-47.25q0-35.13,0-70.27c0-7.58,3.18-12.62,9.24-15,10.31-4,19.76,3.91,19.66,16.09-.19,22.29-.11,44.58-.16,66.87,0,3.33.51,6.46,4.68,6.48s4.75-3.09,4.75-6.42c0-28.11.2-56.22-.13-84.33C121.79,14.87,124.51,8.36,133.28,5.08Z"/></svg>
                    <div>
                        <p class="no-margin">You <strong>cannot archive categories</strong> because you don't have permission. If you think this forum should be archived, please contact a super admin.</p>
                    </div>
                </div>
            </div>
            @elseif($status->slug == 'archived')
            <div class="section-style border-box mb8">
                <p class="fs13 no-margin lblack">You cannot archive this category because it is already <strong>archived</strong>.</p>
            </div>
            @elseif($status->slug == 'under-review')
            <div class="section-style border-box mb8">
                <p class="fs13 no-margin lblack">You cannot archive this category because it is currently <strong>under review</strong>.</p>
            </div>
            @elseif($fstatus->slug == 'archived')
            <div class="section-style border-box mb8">
                <p class="fs13 no-margin lblack">You cannot archive this category because the parent forum is currently <strong>archived</strong>.</p>
            </div>
            @elseif($fstatus->slug == 'under-review')
            <div class="section-style border-box mb8">
                <p class="fs13 no-margin lblack">You cannot archive this category because the parent forum is currently <strong>under review</strong>.</p>
            </div>
            @elseif($category->slug == 'announcements')
            <div class="section-style border-box mb8">
                <p class="fs13 no-margin lblack">You cannot archive <strong>announcements categories</strong>.</p>
            </div>
            @else
            <div>
                <div>
                    <!-- category informations -->
                    <div class="flex align-center">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <span class="bold block lblack">Category informations</span>
                    </div>
                    <div style="margin: 16px 0 16px 8px" class="fs13">
                        <div class="flex align-center my8">
                            <span class="lblack mr4"><span class="bold mr4">Category :</span> {{ $category->category }}</span>
                            <div class="gray height-max-content mx8 fs10">•</div>
                            <span class="lblack mr8"><span class="bold mr4">Slug :</span> {{ $category->slug }}</span>
                        </div>
                        <div class="flex align-center my8">
                            <span class="bold lblack mr4">Status :</span>
                            @php $cscolor = ($status->slug == 'live') ? 'green' : (($status->slug == 'closed') ? 'red' : (($status->slug == 'under-review') ? 'blue' : 'gray' )); @endphp
                            <span class="{{ $cscolor }} bold">{{ $status->status }}</span>
                        </div>
                        <p class="lblack no-margin my8"><span class="bold">
                            Category description</span> : 
                            <span class="expand-box">
                                <span class="expandable-text fs13 my4 forum-description" style="line-height: 1.4">{{ $category->descriptionslice }}</span>
                                @if($category->descriptionslice != $category->description)
                                <input type="hidden" class="expand-slice-text" value="{{ $category->descriptionslice }}" autocomplete="off">
                                <input type="hidden" class="expand-whole-text" value="{{ $category->description }}" autocomplete="off">
                                <input type="hidden" class="expand-text-state" value="0" autocomplete="off">
                                <span class="pointer expand-button fs12 inline-block bblock bold">{{ __('see all') }}</span>
                                <input type="hidden" class="expand-text" value="{{ __('see all') }}">
                                <input type="hidden" class="collapse-text" value="{{ __('see less') }}">
                                @endif
                            </span>
                        </p>
                    </div>

                    <!-- category statistics -->
                    <div class="flex align-center">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M400,32H48A48,48,0,0,0,0,80V432a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48V80A48,48,0,0,0,400,32ZM160,368a16,16,0,0,1-16,16H112a16,16,0,0,1-16-16V240a16,16,0,0,1,16-16h32a16,16,0,0,1,16,16Zm96,0a16,16,0,0,1-16,16H208a16,16,0,0,1-16-16V144a16,16,0,0,1,16-16h32a16,16,0,0,1,16,16Zm96,0a16,16,0,0,1-16,16H304a16,16,0,0,1-16-16V304a16,16,0,0,1,16-16h32a16,16,0,0,1,16,16Z"/></svg>
                        <span class="bold block lblack">Category statistics</span>
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
                <div style="margin-top: 14px">
                    <div class="section-style my8">
                        <div class="flex align-center">
                            <svg class="size13 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                            <p class="lblack fs12 bold no-margin">Please read the caution at the top before archive the category</p>
                        </div>
                    </div>
                    <div class="flex align-center">
                        @if($canarchive)
                        <div class="open-category-archive-confirmation-dialog fs13 red-button-style flex align-center mr8">
                            <div class="relative size14 mr8">
                                <svg fill="white" class="size14 mr4 icon-above-spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.13,22.58c1.78.15,3.56.41,5.34.41,17.56,0,35.12.06,52.68,0,2.72,0,4.05.29,4.05,3.64Q65,130,65.19,233.42c0,3.25-1.16,3.7-4,3.7-19.36,0-38.72.1-58.08.18ZM48,74.3c0-9.5-.05-19,0-28.51,0-2.41-.49-3.52-3.24-3.45-7,.18-14.09.2-21.13,0-2.91-.08-3.54,1-3.52,3.68q.14,28.75,0,57.51c0,3,1.11,3.54,3.75,3.49,6.71-.15,13.44-.25,20.15,0,3.44.14,4.07-1.17,4-4.24C47.86,93.31,48,83.81,48,74.3ZM34.08,189.91a13.85,13.85,0,0,0-13.84,13.65,14.05,14.05,0,0,0,13.62,14,13.9,13.9,0,0,0,14-14A13.62,13.62,0,0,0,34.08,189.91ZM140.13,34.6l42.49-11.33c4.42-1.19,8.89-2.23,13.24-3.66,3.1-1,4.36-.48,5.25,2.93,6,23.28,12.36,46.49,18.59,69.73,11.43,42.67,22.79,85.37,34.39,128,1.13,4.13.34,5.37-3.75,6.4q-25.69,6.5-51.18,13.74c-3.38,1-4.14-.11-4.87-2.88q-23.65-88.69-47.4-177.37a212.52,212.52,0,0,0-6.76-21.85V43q0,94.28.11,188.56c0,4.5-1.13,5.67-5.61,5.59-17.39-.27-34.79-.2-52.18,0-3.42,0-4.4-.84-4.4-4.34q.17-102.9,0-205.79c0-3.38,1.07-4.08,4.17-4.06,17.89.12,35.77.15,53.66,0,3.45,0,4.7.91,4.3,4.36A65,65,0,0,0,140.13,34.6Zm-17,40.07c0-9.5-.13-19,.07-28.5.06-3.05-.82-3.93-3.86-3.84-6.87.22-13.75.18-20.63,0-2.56-.06-3.36.71-3.35,3.3q.13,29,0,58c0,2.53.72,3.44,3.33,3.38,6.88-.16,13.76-.2,20.64,0,3,.09,3.93-.8,3.87-3.86C123,93.68,123.14,84.17,123.14,74.67Zm81.55,27.88c-.05-.16-.11-.31-.15-.47q-7.72-28.92-15.42-57.85c-.49-1.84-1.46-2.3-3.23-1.81q-10.89,3-21.8,5.85c-1.65.44-2.47.89-1.89,3,5.2,19.09,10.26,38.23,15.35,57.36.41,1.52.73,2.61,3,2,7.37-2.16,14.83-4,22.26-6C203.79,104.32,205.26,104.36,204.69,102.55Zm-95.23,87.38a13.53,13.53,0,0,0-14,13.37,13.83,13.83,0,0,0,13.73,14.23,14.09,14.09,0,0,0,13.87-13.73A13.88,13.88,0,0,0,109.46,189.93ZM216.65,214.8a13.77,13.77,0,0,0,13.9-13.53,14.08,14.08,0,0,0-14-14.07,13.9,13.9,0,0,0-13.56,14A13.51,13.51,0,0,0,216.65,214.8Z"/></svg>
                                <div class="spinner size14 opacity0 absolute" fill="#2ca0ff" style="top: 0; left: 0">
                                    <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                                </div>
                            </div>
                            <span class="unselectable">{{ __('Archive category') }}</span>
                        </div>
                        @else
                        <div class="red-button-style disabled-red-button-style flex align-center mr8">
                            <svg class="size14 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.13,22.58c1.78.15,3.56.41,5.34.41,17.56,0,35.12.06,52.68,0,2.72,0,4.05.29,4.05,3.64Q65,130,65.19,233.42c0,3.25-1.16,3.7-4,3.7-19.36,0-38.72.1-58.08.18ZM48,74.3c0-9.5-.05-19,0-28.51,0-2.41-.49-3.52-3.24-3.45-7,.18-14.09.2-21.13,0-2.91-.08-3.54,1-3.52,3.68q.14,28.75,0,57.51c0,3,1.11,3.54,3.75,3.49,6.71-.15,13.44-.25,20.15,0,3.44.14,4.07-1.17,4-4.24C47.86,93.31,48,83.81,48,74.3ZM34.08,189.91a13.85,13.85,0,0,0-13.84,13.65,14.05,14.05,0,0,0,13.62,14,13.9,13.9,0,0,0,14-14A13.62,13.62,0,0,0,34.08,189.91ZM140.13,34.6l42.49-11.33c4.42-1.19,8.89-2.23,13.24-3.66,3.1-1,4.36-.48,5.25,2.93,6,23.28,12.36,46.49,18.59,69.73,11.43,42.67,22.79,85.37,34.39,128,1.13,4.13.34,5.37-3.75,6.4q-25.69,6.5-51.18,13.74c-3.38,1-4.14-.11-4.87-2.88q-23.65-88.69-47.4-177.37a212.52,212.52,0,0,0-6.76-21.85V43q0,94.28.11,188.56c0,4.5-1.13,5.67-5.61,5.59-17.39-.27-34.79-.2-52.18,0-3.42,0-4.4-.84-4.4-4.34q.17-102.9,0-205.79c0-3.38,1.07-4.08,4.17-4.06,17.89.12,35.77.15,53.66,0,3.45,0,4.7.91,4.3,4.36A65,65,0,0,0,140.13,34.6Zm-17,40.07c0-9.5-.13-19,.07-28.5.06-3.05-.82-3.93-3.86-3.84-6.87.22-13.75.18-20.63,0-2.56-.06-3.36.71-3.35,3.3q.13,29,0,58c0,2.53.72,3.44,3.33,3.38,6.88-.16,13.76-.2,20.64,0,3,.09,3.93-.8,3.87-3.86C123,93.68,123.14,84.17,123.14,74.67Zm81.55,27.88c-.05-.16-.11-.31-.15-.47q-7.72-28.92-15.42-57.85c-.49-1.84-1.46-2.3-3.23-1.81q-10.89,3-21.8,5.85c-1.65.44-2.47.89-1.89,3,5.2,19.09,10.26,38.23,15.35,57.36.41,1.52.73,2.61,3,2,7.37-2.16,14.83-4,22.26-6C203.79,104.32,205.26,104.36,204.69,102.55Zm-95.23,87.38a13.53,13.53,0,0,0-14,13.37,13.83,13.83,0,0,0,13.73,14.23,14.09,14.09,0,0,0,13.87-13.73A13.88,13.88,0,0,0,109.46,189.93ZM216.65,214.8a13.77,13.77,0,0,0,13.9-13.53,14.08,14.08,0,0,0-14-14.07,13.9,13.9,0,0,0-13.56,14A13.51,13.51,0,0,0,216.65,214.8Z"/></svg>
                            <span class="unselectable">{{ __('Archive category') }}</span>
                        </div>
                        @endif
                        <a href="{{ route('admin.forum.and.categories.dashboard') . '?selectforum=' . $forum->id }}" class="no-underline bblack bold">{{ __('Return to dashboard') }}</a>
                    </div>
                </div>
            </div>
            @endif
        @endif
    </div>
@endsection