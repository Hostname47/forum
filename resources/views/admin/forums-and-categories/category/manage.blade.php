@extends('layouts.admin')

@section('title', 'Admin - Manage category')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.forums-and-categories', 'subpage'=>'forums-and-categories-category-manage'])
@endsection

@push('scripts')
<script src="{{ asset('js/admin/forums-and-categories/fac.js') }}" defer></script>
<script src="{{ asset('js/admin/forums-and-categories/category.js') }}" defer></script>
@endpush

@section('content')
    <div class="flex align-center space-between top-page-title-box">
        <div class="flex align-center">
            <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M254.7,64.53c-1.76.88-1.41,2.76-1.8,4.19a50.69,50.69,0,0,1-62,35.8c-3.39-.9-5.59-.54-7.89,2.2-2.8,3.34-6.16,6.19-9.17,9.36-1.52,1.6-2.5,2.34-4.5.28-8.79-9-17.75-17.94-26.75-26.79-1.61-1.59-1.87-2.49-.07-4.16,4-3.74,8.77-7.18,11.45-11.78,2.79-4.79-1.22-10.29-1.41-15.62C151.74,33.52,167,12.55,190.72,5.92c1.25-.35,3,0,3.71-1.69H211c.23,1.11,1.13.87,1.89,1,3.79.48,7.43,1.2,8.93,5.45s-1.06,7-3.79,9.69c-6.34,6.26-12.56,12.65-19,18.86-1.77,1.72-2,2.75,0,4.57,5.52,5.25,10.94,10.61,16.15,16.16,2.1,2.24,3.18,1.5,4.92-.28q9.83-10.1,19.9-20c5.46-5.32,11.43-3.47,13.47,3.91.4,1.47-.4,3.32,1.27,4.41Zm0,179-25.45-43.8-28.1,28.13c13.34,7.65,26.9,15.46,40.49,23.21,6.14,3.51,8.73,2.94,13.06-2.67ZM28.2,4.23C20.7,9.09,15,15.89,8.93,22.27,4.42,27,4.73,33.56,9.28,38.48c4.18,4.51,8.7,8.69,13,13.13,1.46,1.53,2.4,1.52,3.88,0Q39.58,38,53.19,24.49c1.12-1.12,2-2,.34-3.51C47.35,15.41,42.43,8.44,35,4.23ZM217.42,185.05Q152.85,120.42,88.29,55.76c-1.7-1.7-2.63-2-4.49-.11-8.7,8.93-17.55,17.72-26.43,26.48-1.63,1.61-2.15,2.52-.19,4.48Q122,151.31,186.71,216.18c1.68,1.68,2.61,2,4.46.1,8.82-9.05,17.81-17.92,26.74-26.86.57-.58,1.12-1.17,1.78-1.88C218.92,186.68,218.21,185.83,217.42,185.05ZM6.94,212.72c.63,3.43,1.75,6.58,5.69,7.69,3.68,1,6.16-.77,8.54-3.18,6.27-6.32,12.76-12.45,18.81-19,2.61-2.82,4-2.38,6.35.16,4.72,5.11,9.65,10.06,14.76,14.77,2.45,2.26,2.1,3.51-.11,5.64C54.2,225.32,47.57,232,41,238.73c-4.92,5.08-3.25,11.1,3.57,12.9a45,45,0,0,0,9.56,1.48c35.08,1.51,60.76-30.41,51.76-64.43-.79-3-.29-4.69,1.89-6.65,3.49-3.13,6.62-6.66,10-9.88,1.57-1.48,2-2.38.19-4.17q-13.72-13.42-27.14-27.14c-1.56-1.59-2.42-1.38-3.81.11-3.11,3.3-6.56,6.28-9.53,9.7-2.28,2.61-4.37,3.25-7.87,2.31C37.45,144.33,5.87,168.73,5.85,202.7,5.6,205.71,6.3,209.22,6.94,212.72ZM47.57,71.28c6.77-6.71,13.5-13.47,20.24-20.21,8.32-8.33,8.25-8.25-.35-16.25-1.82-1.69-2.69-1.42-4.24.14-8.85,9-17.8,17.85-26.69,26.79-.64.65-1.64,2.06-1.48,2.24,3,3.38,6.07,6.63,8.87,9.62C46.08,73.44,46.7,72.14,47.57,71.28Z"/></svg>
            <h1 class="fs22 no-margin lblack">{{ __('Manage a category') }}</h1>
        </div>
        <div class="flex align-center height-max-content">
            <div class="flex align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                <a href="{{ route('admin.dashboard') }}" class="link-path">{{ __('Home') }}</a>
            </div>
            @if(!is_null($category))
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M438.09,273.32h-39.6a102.92,102.92,0,0,1,6.24,35.4V458.37a44.18,44.18,0,0,1-2.54,14.79h65.46A44.4,44.4,0,0,0,512,428.81V347.23A74,74,0,0,0,438.09,273.32ZM107.26,308.73a102.94,102.94,0,0,1,6.25-35.41H73.91A74,74,0,0,0,0,347.23v81.58a44.4,44.4,0,0,0,44.35,44.35h65.46a44.17,44.17,0,0,1-2.55-14.78Zm194-73.91H210.74a74,74,0,0,0-73.91,73.91V458.38a14.78,14.78,0,0,0,14.78,14.78H360.39a14.78,14.78,0,0,0,14.78-14.78V308.73A74,74,0,0,0,301.26,234.82ZM256,38.84a88.87,88.87,0,1,0,88.89,88.89A89,89,0,0,0,256,38.84ZM99.92,121.69a66.44,66.44,0,1,0,66.47,66.47A66.55,66.55,0,0,0,99.92,121.69Zm312.16,0a66.48,66.48,0,1,0,66.48,66.47A66.55,66.55,0,0,0,412.08,121.69Z"/></svg>
                <a href="{{ route('admin.category.manage') }}" class="link-path">{{ __('Select forum') }}</a>
            </div>
            @endif
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Manage category') }}</span>
            </div>
        </div>
    </div>
    <div id="admin-main-content-box">
        <!-- messages (errors) -->
        <div>
            <input type="hidden" id="icon-required-error-message" value="icon field is required" autocomplete="off">
            <input type="hidden" id="name-required-error-message" value="name field is required" autocomplete="off">
            <input type="hidden" id="slug-required-error-message" value="slug field is required" autocomplete="off">
            <input type="hidden" id="description-required-error-message" value="description field is required" autocomplete="off">
        </div>

        <style>
            .categories-wrapper {
                padding: 6px;
                background-color: white;
                border-radius: 6px;
                border: 1px solid rgb(177, 177, 177);
                width: max-content;
                max-height: 250px;
            }

            .section-style {
                padding: 10px;
                border-radius: 2px;
                background-color: #7c868f0f;
                border: 1px solid #7c868f2b;
                margin-bottom: 10px;
            }

            .forum-selected-button-style {
                border: 1px solid #bfbfbf;
                border-radius: 4px;
                background-color: #f2f2f2;
                cursor: default;
            }

            .ficon-viewer {
                height: 50px;
                width: 68px;
                bottom: 8px;
                right: calc(100% + 8px);
                background-color: #ececec;
                border: 1px solid #ccc;
                border-radius: 4px; 
            }
        </style>

        @if(is_null($category))
        <div class="full-center flex-column" style="margin-top: 50px">
            <div class="flex flex-column align-center select-forum-section">
                <input type="hidden" class="status-excluded" value="archived" autocomplete="off">
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
                <p class="fs13 my8">Select the category to <strong>manage</strong></p>
                <div class="categories-wrapper scrolly">
                    <div id="categories-scrollable-box" class="flex flex-column">
                        <div class="flex align-center" style="margin: 8px 12px">
                            <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                            <p class="fs13 gray no-margin">Please select a forum to list its categories</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.category.manage') }}" class="simple-suboption black full-width no-underline forum-category-select-component none">
                        <div class="flex align-center">
                            <span class="category-text"></span>
                            <div class="gray height-max-content mx8 fs10">•</div>
                            <span class="category-status fs13 bold"></span>
                        </div>
                    </a>
                    <div class="flex align-center none" id="no-categories-yet" style="margin: 8px 12px">
                        <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <p class="fs13 gray no-margin">This forum doesn't have categories yet</p>
                    </div>
                </div>
            </div>
        </div>
        @else
            @php
                $ccreator = $category->creator;

                $scolor = 'green';
                $status = $category->status;
                $archived = $status->slug == 'archived';
                $underreview = $status->slug == 'under-review';

                $farchived = $forum->status->slug == 'archived';
                $funderreview = $forum->status->slug == 'under-review';

                if($status->slug == 'closed') $scolor = 'red';
                if($status->slug == 'under-review') $scolor = 'blue';
                if($status->slug == 'archived') $scolor = 'gray';

                $fscolor = ($fstatus->slug == 'live') ? 'green' : (($fstatus->slug == 'closed') ? 'red' : (($fstatus->slug == 'under-review') ? 'blue' : 'gray' ));
            @endphp

            <!-- approve and ignore category viewers -->
            @if($underreview && $canapprove)
            <div id="category-approve-viewer" class="global-viewer full-center none">
                <!-- inputs and messages -->
                <input type="hidden" id="category-status-after-approve" autocomplete="off" value="live">
                <input type="hidden" id="parent-forum-is-archived" autocomplete="off" value="@if($farchived) 1 @else 0 @endif">
                <input type="hidden" id="parent-forum-is-under-review" autocomplete="off" value="@if($funderreview) 1 @else 0 @endif">

                <input type="hidden" id="category-status-after-approve-is-required-message" value="{{ __('You have to specify the status of category after approval') }}." autocomplete="off">
                <input type="hidden" id="parent-forum-is-archived-message" value="{{ __('You cannot approve this category because the parent forum is archived') }}." autocomplete="off">
                <input type="hidden" id="parent-forum-is-under-review-message" value="{{ __('You cannot approve this category because the parent forum is currently under review') }}." autocomplete="off">

                <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
                <div class="global-viewer-content-box viewer-box-style-1" style="width: 640px;">
                    <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                        <div class="flex align-center">
                            <svg class="size15 mr4" fill="#202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z"/></svg>
                            <span class="fs20 bold forum-color">{{ __('Approve Category') }}</span>
                        </div>
                        <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                    </div>
                    <div class="scrolly" style="padding: 14px; max-height: 430px">
                        <h2 class="fs24 forum-color my8">Approve category : {{ $category->category }}</h2>
                        @if($farchived)
                        <div class="red-section-style fs13 lblack mb8">
                            <p class="no-margin">You can't approve this category because the parent forum is currently <strong>archived</strong></p>
                        </div>
                        @endif
                        @if($funderreview)
                        <div class="red-section-style fs13 lblack mb8">
                            <p class="no-margin">You can't approve this category because the parent forum is currently <strong>under review</strong>. This category can only be approved when approving forum.</p>
                        </div>
                        @endif
                        <div class="section-style fs13 lblack mb8">
                            <p class="no-margin">Here you can approve the category and make it live to public. But before that, you have to consider the following points :</p>
                            <div class="ml8 mt8">
                                <div class="flex align-center">
                                    <div class="fs10 mr8 gray">•</div>
                                    <p class="no-margin">The parent forum should not be <strong>under review</strong> or <strong>archived</strong>.</p>
                                </div>
                                <div class="flex align-center">
                                    <div class="fs10 mr8 gray">•</div>
                                    <p class="no-margin mt4">You have to specify the <strong>status</strong> of the category after the approving it.</p>
                                </div>
                            </div>
                        </div>
                        <div style="margin: 12px">
                            <div class="flex">
                                <svg class="size18 mr8" style="margin-top: 2px" fill="#202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    {!! $forum->icon !!}
                                </svg>
                                <h2 class="forum-color fs20 no-margin">{{ $forum->forum }} Forum</h2>
                            </div>
                            <div class="flex">
                                <svg class="size14 mx8" style="margin-top: 3px" fill="#d2d2d2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"/></svg>
                                <p class="my4 bold">category : {{ $category->category }} - <span class="blue">under review</span></p>
                            </div>
                        </div>

                        <div class="fs13">
                            <div class="flex align-center mb8">
                                <svg class="size13 mr4" style="min-width: 14px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448,0H64A64.08,64.08,0,0,0,0,64V448a64.08,64.08,0,0,0,64,64H448a64.07,64.07,0,0,0,64-64V64A64.08,64.08,0,0,0,448,0Zm21.33,448A21.35,21.35,0,0,1,448,469.33H64A21.34,21.34,0,0,1,42.67,448V64A21.36,21.36,0,0,1,64,42.67H448A21.36,21.36,0,0,1,469.33,64ZM147.63,119.89a22.19,22.19,0,0,0-4.48-7c-1.07-.85-2.14-1.7-3.2-2.56a16.41,16.41,0,0,0-3.84-1.92,13.77,13.77,0,0,0-3.84-1.28,20.49,20.49,0,0,0-12.38,1.28,24.8,24.8,0,0,0-7,4.48,22.19,22.19,0,0,0-4.48,7,20.19,20.19,0,0,0,0,16.22,22.19,22.19,0,0,0,4.48,7A22.44,22.44,0,0,0,128,149.33a32.71,32.71,0,0,0,4.27-.42,13.77,13.77,0,0,0,3.84-1.28,16.41,16.41,0,0,0,3.84-1.92c1.06-.86,2.13-1.71,3.2-2.56A22.44,22.44,0,0,0,149.33,128,21.38,21.38,0,0,0,147.63,119.89ZM384,106.67H213.33a21.33,21.33,0,0,0,0,42.66H384a21.33,21.33,0,0,0,0-42.66ZM148.91,251.73a13.77,13.77,0,0,0-1.28-3.84,16.41,16.41,0,0,0-1.92-3.84c-.86-1.06-1.71-2.13-2.56-3.2a24.8,24.8,0,0,0-7-4.48,21.38,21.38,0,0,0-16.22,0,24.8,24.8,0,0,0-7,4.48c-.85,1.07-1.7,2.14-2.56,3.2a16.41,16.41,0,0,0-1.92,3.84,13.77,13.77,0,0,0-1.28,3.84,32.71,32.71,0,0,0-.42,4.27A21.1,21.1,0,0,0,128,277.33,21.12,21.12,0,0,0,149.34,256,34.67,34.67,0,0,0,148.91,251.73ZM384,234.67H213.33a21.33,21.33,0,0,0,0,42.66H384a21.33,21.33,0,0,0,0-42.66ZM147.63,375.89a20.66,20.66,0,0,0-27.74-11.52,24.8,24.8,0,0,0-7,4.48,24.8,24.8,0,0,0-4.48,7,21.38,21.38,0,0,0-1.7,8.11,21.33,21.33,0,1,0,42.66,0A17.9,17.9,0,0,0,147.63,375.89ZM384,362.67H213.33a21.33,21.33,0,0,0,0,42.66H384a21.33,21.33,0,0,0,0-42.66Z"></path></svg>
                                <p class="no-margin bold lblack fs14">Category details</p>
                            </div>
                            <p class="lblack no-margin my8 bold">Parent forum status : <span class="{{ $fscolor }}">{{ $fstatus->status }}</span></p>
                            <div class="simple-line-separator my4"></div>
                            <p class="lblack no-margin my8"><span class="bold">Category name</span> : {{ $category->category }} - (slug : {{ $category->slug }})</p>
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
                            <div class="flex my8">
                                <span class="bold lblack">Category icon :</span>
                                @if(!is_null($category->icon))
                                <div class="ficon-viewer full-center ml8">
                                    <svg class="size40" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">{!! $category->icon !!}</svg>
                                </div>
                                @else
                                <em class="lblack gray ml4">Not defined</em>
                                @endif
                            </div>
                        </div>
                        <div style="margin-top: 18px">
                            <div class="flex align-center mb8">
                                <svg class="size13 mr4" style="min-width: 14px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M197.63,2.4C199,4.24,201.19,3.45,203,4.08a32,32,0,0,1,21.4,28.77c.14,4,.18,7.93,0,11.88-.26,6.3-4.8,10.58-10.82,10.44-5.84-.13-9.9-4.25-10.17-10.51-.14-3.3.08-6.61-.09-9.91C202.94,27.81,199,23.86,192,23.52c-3-.14-5.94,0-8.91,0-6-.14-10.05-3-11.2-7.82-1.23-5.13.68-9.09,5.92-12.31a5.8,5.8,0,0,0,1-1ZM38.88,2.4c-.22.78-.87.78-1.52.94C24.43,6.58,16.51,14.91,13.46,27.71c-1.34,5.64-.74,11.53-.53,17.3a10.08,10.08,0,0,0,10.5,10.18c5.78,0,10.14-4.29,10.45-10.36.16-3.13,0-6.28,0-9.42C34.05,27.9,38,23.79,45.5,23.51c3.46-.13,6.94.06,10.4-.14,4.87-.28,7.94-3.08,9.31-7.6s-.25-8-3.59-11.09C60.7,3.83,59.05,4,58.73,2.4Zm55.56,0c-.16,1.13-1.22.84-1.87,1.21-4.47,2.56-6.49,7-5.37,11.67,1.16,4.89,4.64,8,9.88,8.1q21.56.23,43.13,0a9.75,9.75,0,0,0,9.7-7.7c1-4.8-.35-8.79-4.57-11.64-.77-.52-2-.44-2.28-1.63ZM142.29,247c0,3.87.55,7.36,4.66,9,4,1.53,6.55-.77,9.05-3.38,12.14-12.64,24.36-25.2,36.43-37.91a9.54,9.54,0,0,1,7.68-3.37c15.71.18,31.42.06,47.12.09,4,0,7.28-1,8.54-5.19,1.14-3.81-1.26-6.2-3.65-8.58q-47.88-47.85-95.75-95.74c-2.63-2.64-5.24-5.33-9.43-3.7-4.36,1.7-4.66,5.47-4.65,9.46q.06,34.47,0,68.94Q142.31,211.74,142.29,247Zm-87-33c6.06-.34,10.36-4.74,10.35-10.45a10.59,10.59,0,0,0-10.37-10.52c-3.46-.18-6.94,0-10.41-.07-6.56-.23-10.71-4.41-10.92-11-.12-3.64.14-7.29-.12-10.91a10.52,10.52,0,0,0-10-9.8c-5.11-.22-10.18,3.43-10.65,8.43-.61,6.57-1,13.26.49,19.75,3.7,15.82,16.07,24.61,34.23,24.59C50.34,213.94,52.82,214.05,55.3,213.91ZM12.86,128.57C13,135.3,17.31,140,23.27,140s10.57-4.64,10.62-11.27q.15-20.53,0-41.08c0-6.68-4.52-11.11-10.71-11-6,.07-10.17,4.3-10.3,10.87-.15,6.93,0,13.86,0,20.79C12.84,115,12.75,121.81,12.86,128.57ZM203.39,97.73c0,3.63-.16,7.28,0,10.9.32,5.93,4.46,9.91,10.13,10s10.47-3.78,10.72-9.47c.34-7.75.36-15.54,0-23.29-.27-5.64-5.21-9.48-10.87-9.28a10,10,0,0,0-9.93,9.7c-.23,3.78,0,7.6,0,11.4Zm-84,116.12a10.44,10.44,0,0,0,0-20.84c-7.56-.3-15.15-.29-22.71,0a10.44,10.44,0,0,0,0,20.84c3.77.23,7.57,0,11.35.05S115.57,214.09,119.34,213.85Z"/></svg>
                                <p class="no-margin bold lblack fs14">Select category status</p>
                            </div>
                            <p class="fs13 lblack my4">Please select the category status after approving it.</p>
                            <div class="radio-group">
                                <!-- live -->
                                <div class="flex align-center custom-radio-button pointer select-category-status-after-approve" style="padding: 6px; border: 1px solid #c8c8c8; border-radius: 4px;">
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
                                        <p class="my4 fs12">The category will be live after approval</p>
                                    </div>
                                    <input type="hidden" class="status" value="live" autocomplete="off">
                                </div>
                                <!-- closed -->
                                <div class="flex align-center custom-radio-button pointer mt8 select-category-status-after-approve" style="padding: 6px; border: 1px solid #c8c8c8; border-radius: 4px;">
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
                                        <p class="my4 fs12">The category will be closed after approval; Admins later decide whether to open it later or not</p>
                                    </div>
                                    <input type="hidden" class="status" value="closed" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <p class="my8 bold">Confirmation</p>
                        <p class="no-margin mb4 bblack">Please type <strong>{{ auth()->user()->username }}/approve-category::{{ $category->slug }}</strong> to confirm.</p>
                        <div>
                            <input type="text" autocomplete="off" class="full-width input-style-1" id="approve-category-confirm-input" style="padding: 8px 10px">
                            <input type="hidden" id="approve-category-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}/approve-category::{{ $category->slug }}">
                        </div>
                        <div class="flex" style="margin-top: 12px">
                            <div class="flex align-center full-width">
                                <div id="approve-category-button" class="disabled-green-button-style green-button-style full-center full-width">
                                    <div class="relative size14 mr4">
                                        <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"/><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"/></svg>
                                        <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                    <span class="bold fs13">approve category</span>
                                    <input type="hidden" class="category-id" value="{{ $category->id }}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($underreview && $canignore)
            <div id="category-ignore-viewer" class="global-viewer full-center none">
                <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
                <div class="global-viewer-content-box viewer-box-style-1">
                    <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                        <div class="flex align-center">
                            <svg class="size15 mr4" fill="#202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                            <span class="fs20 bold forum-color">{{ __('Ignore & Delete category under review') }}</span>
                        </div>
                        <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                    </div>
                    <div class="scrolly" style="padding: 14px; max-height: 430px">
                        <h2 class="fs24 forum-color my8">Ignore & Delete category : {{ $category->category }}</h2>
                        <div class="section-style fs13 lblack mb8">
                            <p class="no-margin">The current category is under review. If you see that this category does not fit our standards, then delete it.</p>
                        </div>
                        <div style="margin: 12px 0">
                            <div class="flex">
                                <svg class="size18 mr8" style="margin-top: 2px" fill="#202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    {!! $forum->icon !!}
                                </svg>
                                <h2 class="forum-color fs20 no-margin">{{ $forum->forum }} Forum</h2>
                            </div>
                            <div class="flex">
                                <svg class="size14 mx8" style="margin-top: 3px" fill="#d2d2d2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"/></svg>
                                <p class="my4 bold">category : {{ $category->category }} - <span class="blue">under review</span></p>
                            </div>
                        </div>

                        <div class="fs13">
                            <div class="flex align-center mb8">
                                <svg class="size13 mr4" style="min-width: 14px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448,0H64A64.08,64.08,0,0,0,0,64V448a64.08,64.08,0,0,0,64,64H448a64.07,64.07,0,0,0,64-64V64A64.08,64.08,0,0,0,448,0Zm21.33,448A21.35,21.35,0,0,1,448,469.33H64A21.34,21.34,0,0,1,42.67,448V64A21.36,21.36,0,0,1,64,42.67H448A21.36,21.36,0,0,1,469.33,64ZM147.63,119.89a22.19,22.19,0,0,0-4.48-7c-1.07-.85-2.14-1.7-3.2-2.56a16.41,16.41,0,0,0-3.84-1.92,13.77,13.77,0,0,0-3.84-1.28,20.49,20.49,0,0,0-12.38,1.28,24.8,24.8,0,0,0-7,4.48,22.19,22.19,0,0,0-4.48,7,20.19,20.19,0,0,0,0,16.22,22.19,22.19,0,0,0,4.48,7A22.44,22.44,0,0,0,128,149.33a32.71,32.71,0,0,0,4.27-.42,13.77,13.77,0,0,0,3.84-1.28,16.41,16.41,0,0,0,3.84-1.92c1.06-.86,2.13-1.71,3.2-2.56A22.44,22.44,0,0,0,149.33,128,21.38,21.38,0,0,0,147.63,119.89ZM384,106.67H213.33a21.33,21.33,0,0,0,0,42.66H384a21.33,21.33,0,0,0,0-42.66ZM148.91,251.73a13.77,13.77,0,0,0-1.28-3.84,16.41,16.41,0,0,0-1.92-3.84c-.86-1.06-1.71-2.13-2.56-3.2a24.8,24.8,0,0,0-7-4.48,21.38,21.38,0,0,0-16.22,0,24.8,24.8,0,0,0-7,4.48c-.85,1.07-1.7,2.14-2.56,3.2a16.41,16.41,0,0,0-1.92,3.84,13.77,13.77,0,0,0-1.28,3.84,32.71,32.71,0,0,0-.42,4.27A21.1,21.1,0,0,0,128,277.33,21.12,21.12,0,0,0,149.34,256,34.67,34.67,0,0,0,148.91,251.73ZM384,234.67H213.33a21.33,21.33,0,0,0,0,42.66H384a21.33,21.33,0,0,0,0-42.66ZM147.63,375.89a20.66,20.66,0,0,0-27.74-11.52,24.8,24.8,0,0,0-7,4.48,24.8,24.8,0,0,0-4.48,7,21.38,21.38,0,0,0-1.7,8.11,21.33,21.33,0,1,0,42.66,0A17.9,17.9,0,0,0,147.63,375.89ZM384,362.67H213.33a21.33,21.33,0,0,0,0,42.66H384a21.33,21.33,0,0,0,0-42.66Z"></path></svg>
                                <p class="no-margin bold lblack fs14">Category details</p>
                            </div>
                            <p class="lblack no-margin my8"><span class="bold">Category name</span> : {{ $category->category }} - (slug : {{ $category->slug }})</p>
                            <p class="lblack no-margin my8"><span class="bold">
                                Category description</span> : 
                                <span class="expand-box">
                                    <span class="expandable-text fs13 my4" style="line-height: 1.4">{{ $category->descriptionslice }}</span>
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
                            <div class="flex my8">
                                <span class="bold lblack">Category icon :</span>
                                @if(!is_null($category->icon))
                                <div class="ficon-viewer full-center ml8">
                                    <svg class="size40" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">{!! $category->icon !!}</svg>
                                </div>
                                @else
                                <em class="lblack gray ml4">Not defined</em>
                                @endif
                            </div>
                        </div>
                        <div class="simple-line-separator my8"></div>
                        <p class="my8 bold lblack">Confirmation</p>
                        <p class="no-margin mb4 bblack">Please type <strong>{{ auth()->user()->username }}/ignore&delete-category::{{ $category->slug }}</strong> to confirm.</p>
                        <div>
                            <input type="text" autocomplete="off" class="full-width input-style-1" id="ignore-category-confirm-input" style="padding: 8px 10px">
                            <input type="hidden" id="ignore-category-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}/ignore&delete-category::{{ $category->slug }}">
                        </div>
                        <div class="flex" style="margin-top: 12px">
                            <div class="flex align-center full-width">
                                <div id="ignore-ur-category-button" class="disabled-red-button-style red-button-style full-center full-width"> <!-- ur : under review -->
                                    <div class="relative size14 mr8">
                                        <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                                        <div class="spinner size14 opacity0 absolute" style="top: 0; left: 0">
                                            <svg class="size14" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16">
                                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <span class="fs13 bold unselectable">I understand, delete this category</span>
                                    <input type="hidden" class="category-id" value="{{ $category->id }}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div>
                <div class="flex" style="margin: 12px 0">
                    <svg class="size24 mr8" style="margin-top: 2px" fill="#202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        {!! $forum->icon !!}
                    </svg>
                    <div>
                        <h2 class="forum-color fs26 no-margin">{{ $forum->forum }} Forum</h2>
                        <div class="flex">
                            <svg class="size14 mx8" style="margin-top: 3px" fill="#d2d2d2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"/></svg>
                            <p class="mr4 bold no-margin" style="margin-top: 6px">category : {{ $category->category }}</p>
                        </div>
                    </div>
                </div>
                <div class="my8 none" id="category-manage-error-container">
                    <div class="flex">
                        <svg class="size14 mr4" style="min-width: 14px; margin-top: 1px" fill="rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                        <span class="error fs13 bold no-margin" id="category-manage-error"></span>
                    </div>
                </div>
                @if(Session::has('message'))
                    <div class="green-message-container my8">
                        <p class="green-message">{{ Session::get('message') }}</p>
                    </div>
                @endif
                <style>
                    .selected-status {
                        background-color: #f4f4f4;
                        cursor: default;
                    }
                </style>
                @if($underreview)
                <div style="margin: 12px 0 4px 0">
                    @if($canapprove && $canignore)
                    <p class="fs13 lblack my8">Please review carefully the category before choosing whether to approve it or ignore(delete) it.</p>
                    @else
                    <div class="section-style flex align-center my8">
                        <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <p class="fs12 bold lblack no-margin">You cannot approve or ignore under review forums due to lack of permissions.</p>
                    </div>
                    @endif
                    <!-- approve / ignore open viewer buttons -->
                    <div class="flex align-center mb8">
                        <div class="relative">
                            @if($canapprove)
                                <div class="open-category-approve-confirmation-dialog typical-button-style flex align-center" style="padding: 5px 12px">
                                    <svg class="size12 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z"/></svg>
                                    <span class="fs12 bold unselectable">review & approve</span>
                                </div>
                            @else
                                <div class="typical-button-style disabled-typical-button-style flex align-center" style="padding: 5px 12px">
                                    <svg class="size12 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z"/></svg>
                                    <span class="fs12 bold unselectable">review & approve</span>
                                </div>
                            @endif
                        </div>
                        <div class="fs10 mx8 gray">•</div>
                        <div class="relative">
                            @if($canignore)
                                <div class="open-category-ignore-dialog red-button-style flex align-center" style="padding: 5px 12px">
                                    <svg class="size12 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                                    <span class="fs12 bold unselectable">ignore & delete</span>
                                </div>
                            @else
                                <div class="red-button-style disabled-red-button-style flex align-center" style="padding: 5px 12px">
                                    <svg class="size12 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                                    <span class="fs12 bold unselectable">ignore & delete</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                <!-- category status section -->
                @if($canupdatestatus)
                <div class="section-style mb4">
                    @if(Session::has('status-updated'))
                        <div class="green-message-container my4">
                            <p class="green-message">{{ Session::get('status-updated') }}</p>
                        </div>
                    @endif

                    <p class="bold forum-color fs15 no-margin">Handle category status</p>
                    <p class="no-margin mt4 gray fs13">The category status will be changed solely along with a page reload once the status is selected.</p>
                    @if($underreview)
                    <p class="fs13 gray no-margin my8"><span class="bold lblack">Important</span> : You can't change the status of this category because it is currently <strong>under review</strong>. The category must be aproved in order for status to be updated</p>
                    @elseif($archived)
                    <p class="fs13 gray no-margin my8"><span class="bold lblack">Important</span> : You can't change the status of this categiory because it is currently <strong>archived</strong>. If you want to restore it again <a class="blue bold no-underline" href="{{ route('admin.category.restore') . '?categoryid=' . $category->id }}">click here</a></p>
                    @endif
                    <div class="my8 flex align-center">
                        <span class="flex align-center bold forum-color fs13">{{ __('Status') }} : <span class="bold {{ $scolor }} ml4">{{ $status->status }}</span></span>
                        @if(!$archived && !$underreview)
                        <div class="flex align-center">
                            <div class="fs10 mx8 gray">•</div>
                            <div class="relative">
                                <div class="button-with-suboptions button-style-2 flex align-center">
                                    <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z" style="fill:#020202"/><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z" style="fill:#181818"/></svg>
                                    <span class="fs13 unselectable" style="margin-top: -1px">change</span>
                                </div>
                                <div class="suboptions-container suboptions-container-right-style" style="left: 0">
                                    <input type="hidden" class="category-id" autocomplete="off" value="{{ $category->id }}">
                                    <div class="simple-suboption @if($status->slug=='live') selected-status @endif update-category-status" style="max-width: 270px">
                                        <div class="flex align-center">
                                            <div class="relative size14 mr4">
                                                <svg class="size14 icon-above-spinner mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.55,60.69c8,0,16,.06,24-.13,2.82-.06,4.05.4,3.92,3.66-.28,7-.16,14,0,21.08,0,2.19-.38,3.24-2.91,3.17-8.33-.22-16.66-.22-25-.3Z"/><path d="M3.55,116.64c8.16,0,16.33,0,24.49-.17,2.35,0,3.51.34,3.43,3.13q-.3,10.79,0,21.57c.08,2.79-1.08,3.17-3.43,3.13-8.16-.15-16.33-.13-24.49-.17Z"/><path d="M3.55,172.6c8.32-.09,16.65-.08,25-.3,2.53-.07,2.94,1,2.91,3.17-.1,7.19-.17,14.39,0,21.58.07,2.76-1,3.18-3.41,3.14-8.17-.13-16.34-.09-24.51-.11Z"/><path d="M59.5,256c0-8,.07-16-.12-24-.07-2.82.39-4,3.65-3.92,7,.29,14,.16,21.08,0,2.19,0,3.24.39,3.17,2.92-.22,8.32-.21,16.65-.3,25Z"/><path d="M115.45,256c0-8.17,0-16.33-.17-24.5,0-2.35.34-3.5,3.13-3.43q10.78.31,21.57,0c2.79-.07,3.17,1.08,3.13,3.43-.15,8.17-.13,16.33-.17,24.5Z"/><path d="M171.41,256c-.09-8.33-.08-16.66-.3-25-.07-2.53,1-2.95,3.17-2.92,7.19.11,14.39.17,21.57,0,2.77-.08,3.19,1,3.15,3.4-.14,8.17-.09,16.35-.11,24.52Z"/><path d="M3.55,228.55c8.43-.86,16.89-.12,25.34-.39,1.88-.06,2.6.65,2.53,2.54-.27,8.44.47,16.9-.39,25.34H25.14c-.53-1.53-2.07-1.38-3.19-1.8A28.18,28.18,0,0,1,6.41,240.33c-1-1.94-.77-4.49-2.86-5.89Z" style="fill:#020202"/><path d="M3.55,26.33c2.28-1.85,2.18-4.87,3.57-7.21,4.71-8,11.59-12.5,20.6-14.11,2.58-.46,3.86-.12,3.76,3-.23,7.16-.1,14.34-.05,21.51,0,1.8-.09,3.16-2.52,3.07-8.45-.31-16.92.46-25.36-.4Z" style="fill:#020202"/><path d="M227.36,256c-.86-8.44-.1-16.91-.4-25.36-.09-2.41,1.24-2.53,3-2.52,7.17,0,14.34.16,21.51,0,3.08-.09,3.42,1.09,3.07,3.73a27.46,27.46,0,0,1-21.88,23.24c-.67.12-1.26.17-1.42,1Z" style="fill:#020202"/><path d="M3.55,234.44c2.09,1.4,1.84,3.95,2.86,5.89A28.18,28.18,0,0,0,22,254.24c1.12.42,2.66.27,3.19,1.8-6.38,0-12.76-.12-19.14.06-2.12.06-2.58-.4-2.52-2.52C3.66,247.21,3.55,240.82,3.55,234.44Z" style="fill:#fafafa"/><path d="M59.44,130.39c0-21.92.06-43.84-.07-65.76,0-3.07.61-4.1,3.94-4.09q66,.18,132,0c3.13,0,3.72.91,3.71,3.83q-.14,66,0,132c0,2.9-.54,3.85-3.69,3.85q-66-.18-132,0c-3.3,0-4-1-4-4.08C59.5,174.23,59.44,152.31,59.44,130.39Zm27.79-.53c0,12.75.13,25.49-.08,38.23-.06,3.5,1,4.35,4.4,4.33q37.74-.19,75.48,0c3.1,0,4.22-.65,4.2-4q-.21-38,0-76c0-3.27-1-4.09-4.14-4.08-25.16.12-50.32.17-75.48,0-3.93,0-4.51,1.34-4.45,4.78C87.35,105.35,87.23,117.61,87.23,129.86Z"/><path d="M73.26,4.74c3.75,0,7.51.1,11.25,0,2.13-.09,2.8.6,2.77,2.74-.12,7.5-.08,15,0,22.51,0,1.73-.32,2.69-2.38,2.67q-11.49-.13-23,0c-2,0-2.49-.69-2.47-2.55.07-7.66.09-15.33,0-23,0-2.06.85-2.42,2.61-2.37C65.76,4.8,69.51,4.74,73.26,4.74Z"/><path d="M115.32,18.62c0-3.59.18-7.18-.06-10.75-.18-2.69.87-3.23,3.32-3.19,7.17.15,14.34.14,21.51,0,2.31-.05,3.08.57,3,3q-.23,11,0,22c0,2.4-.77,3-3.07,3q-11-.18-22,0c-2.13,0-2.86-.64-2.77-2.77C115.43,26.12,115.32,22.37,115.32,18.62Z"/><path d="M184.65,32.59c-3.59,0-7.18-.11-10.76,0-2.16.08-2.8-.7-2.77-2.8.1-7.5.13-15,0-22.51C171.06,5,172,4.68,174,4.7c7.33.09,14.67.13,22,0,2.36,0,3,.66,3,3-.15,7.34-.17,14.68,0,22,.06,2.52-.87,3-3.11,2.93C192.16,32.47,188.4,32.59,184.65,32.59Z"/><path d="M240.61,88c-4.37,0-10.09,1.68-12.73-.45S227.19,79.36,227,75c-.15-3.74.13-7.51-.09-11.25-.15-2.66.87-3.25,3.34-3.2,7.17.15,14.35.13,21.52,0,2.21,0,3.16.38,3.11,2.89-.17,7.34-.16,14.68,0,22,.05,2.4-.68,3.1-3,3-3.74-.19-7.5,0-11.25,0Z"/><path d="M254.84,130.87c0,3.42-.18,6.86.06,10.26.18,2.7-.87,3.23-3.33,3.18q-10.5-.23-21,0c-2.61.06-3.72-.49-3.63-3.41.21-7,.21-14,0-21-.09-2.92,1-3.48,3.63-3.42q10.5.23,21,0c2.45,0,3.5.47,3.33,3.17C254.66,123.36,254.84,127.12,254.84,130.87Z"/><path d="M241.78,172.35c3.71.38,9.7-1.95,12.28.88,2.23,2.44.74,8.35.76,12.72,0,4.54,1.61,10.61-.68,13.23-2.64,3-8.85.78-13.51.92-4.36.12-10.24,1.5-12.72-.72-2.86-2.57-.71-8.55-.89-13-.15-3.74.07-7.5-.07-11.25-.08-2.15.69-2.84,2.8-2.77C233.5,172.45,237.25,172.35,241.78,172.35Z"/><path d="M239.83,32.59c-3.59-.34-9.25,1.87-12-.78s-.68-8.35-.85-12.7c-.14-3.75.14-7.52-.08-11.26C226.77,5,228,4.68,230.39,5c12.12,1.36,22.68,11.9,24.23,24.09.36,2.86-.39,3.76-3.24,3.59C247.8,32.43,244.19,32.59,239.83,32.59Z" style="fill:#020202"/></svg>
                                                <div class="spinner size14 opacity0 absolute" fill="#2ca0ff" style="top: 0; left: 0">
                                                    <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                                                </div>
                                            </div>
                                            <span class="fs13 bold">Live</span>
                                        </div>
                                        <p class="fs12 gray my4">Make the category available to the public users</p>
                                        <input type="hidden" class="category-status" value="live" autocomplete="off">
                                    </div>
                                    <div class="simple-suboption @if($status->slug=='closed') selected-status @endif update-category-status" style="max-width: 270px">
                                        <div class="flex align-center">
                                            <div class="relative size14 mr4">
                                                <svg class="size14 icon-above-spinner mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm0,448A200,200,0,1,1,456,256,199.94,199.94,0,0,1,256,456ZM357.8,193.8,295.6,256l62.2,62.2a12,12,0,0,1,0,17l-22.6,22.6a12,12,0,0,1-17,0L256,295.6l-62.2,62.2a12,12,0,0,1-17,0l-22.6-22.6a12,12,0,0,1,0-17L216.4,256l-62.2-62.2a12,12,0,0,1,0-17l22.6-22.6a12,12,0,0,1,17,0L256,216.4l62.2-62.2a12,12,0,0,1,17,0l22.6,22.6a12,12,0,0,1,0,17Z"/></svg>    
                                                <div class="spinner size14 opacity0 absolute" fill="#2ca0ff" style="top: 0; left: 0">
                                                    <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                                                </div>
                                            </div>
                                            <span class="fs13 bold">Closed</span>
                                        </div>
                                        <p class="fs12 gray my4">Close the category and prevent user from sharing new threads on this category</p>
                                        <input type="hidden" class="category-status" value="closed" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @else
                <div class="section-style mb4">
                    <p class="bold forum-color fs15 no-margin">Handle category status</p>
                    <p class="no-margin mt4 gray fs13">You could not update category status because you do not have permission to do so</p>
                    <div class="my8 flex align-center">
                        <div class="flex align-center">
                            <span class="flex align-center bold forum-color fs13 mr4">{{ __('status') }} :</span>
                            <span class="bold fs13 {{ $scolor }}">{{ $status->status }}</span>
                        </div>
                    </div>
                </div>
                @endif
                <div class="flex align-center my4">
                    <p class="no-margin fs13 lblack">* <strong>created</strong> by : <a href="{{ route('user.profile', ['user'=>$ccreator->username]) }}" target="_blank" class="bold blue no-underline ">{{ $ccreator->username }}</a></p>
                    @if($approver = $category->approver)
                    <div class="fs10 mx8 gray">•</div>
                    <p class="no-margin fs13 lblack"><strong>approved</strong> by : <a href="{{ route('user.profile', ['user'=>$approver->username]) }}" target="_blank" class="bold blue no-underline ">{{ $approver->username }}</a></p>
                    @endif
                </div>
                <div style="margin-top: 12px">
                    <div class="mb8">
                        <label for="category-name" class="flex align-center bold forum-color mb4">{{ __('Category name') }}<span class="ml4 err red none fs12">*</span></label>
                        <input type="text" id="category-name" class="styled-input" maxlength="255" autocomplete="off" placeholder='{{ __("Category name here") }}' value="{{ $category->category }}">
                    </div>
                    <div class="mb8">
                        <label for="category-slug" class="flex align-center bold forum-color mb4">{{ __('Category slug') }}<span class="ml4 err red none fs12">*</span></label>
                        <input type="text" id="category-slug" class="styled-input" maxlength="255" autocomplete="off" placeholder='{{ __("Category slug here") }}' value="{{ $category->slug }}">
                    </div>
                    <div class="mb8">
                        <label for="category-description" class="flex align-center bold forum-color mb4">{{ __('Description') }}<span class="ml4 err red none fs12">*</span></label>
                        <textarea id="category-description" class="styled-textarea fs14"
                            style="margin: 0; padding: 8px; width: 100%; min-height: 110px; max-height: 110px;"
                            maxlength="800"
                            spellcheck="false"
                            autocomplete="off"
                            placeholder="{{ __('Category description here') }}">{{ $category->description }}</textarea>
                    </div>
                    <div class="mb8">
                        <label for="category-icon" class="flex align-center bold forum-color mb2">
                            {{ __('Icon') }}
                            @if($issuperadmin)
                            <span class="fs12 ml4" style="font-weight: 400">(optional)</span>
                            @else
                            <span class="fs12 ml4" style="font-weight: 400">(you don't have permission to include icon. Super admins and site owners will take this step after review)</span>
                            @endif
                        </label>
                        <div class="flex align-center space-between">
                            <p class="fs12 gray my4">The icon store the content of svg tag. (Be careful, the viewport of svg should be : 0 . 0 . 512 . 512)</p>
                            <div class="relative">
                                <div class="flex align-center pointer py4 render-category-icon button-with-suboptions">
                                    <div class="size14 mr4 relative">
                                        <svg class="mr4 size14 icon-above-spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="fill:none; stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px; margin-top: 1px"><path d="M1,12S5,4,12,4s11,8,11,8-4,8-11,8S1,12,1,12ZM12,9a3,3,0,1,1-3,3A3,3,0,0,1,12,9Z"></path></svg>
                                        <div class="spinner size14 opacity0 absolute" fill="#2ca0ff" style="top: 0; left: 0">
                                            <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                                        </div>
                                    </div>
                                    <span class="mr4 fs13 bold">render</span>
                                </div>
                                <style>
                                    .category-icon-viewer {
                                        height: 85px;
                                        width: 105px;
                                        bottom: -40px;
                                        right: calc(100% + 8px);
                                        background-color: #ececec;
                                        border: 1px solid #ccc;
                                        border-radius: 4px; 
                                    }
                                </style>
                                <div class="absolute category-icon-viewer suboptions-container">
                                    <div class="full-dimensions full-center">
                                        <svg class="size60 mr4" id="category-icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <textarea id="category-icon" class="styled-textarea fs14"
                            style="margin: 0; padding: 8px; width: 100%; min-height: 110px; max-height: 110px;"
                            spellcheck="false"
                            autocomplete="off"
                            @if(!$issuperadmin)
                            disabled="disabled"
                            @endif
                            placeholder="{{ __('The content of logo svg\'s tag content') }}">{{ $category->icon }}</textarea>
                    </div>
                </div>
                @if(!$canupdate)
                <div class="section-style flex align-center my8">
                    <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                    <p class="fs12 bold lblack no-margin">You don't have the permission to update category informations. If you think this category need some changes, please contact a super admin.</p>
                </div>
                @endif
                <div class="flex align-center" style="margin: 20px 0">
                    @if($canupdate)
                    <div class="category-update-changes-button flex align-center typical-button-style mr8">
                        <div class="size14 relative mr4">
                            <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.26,58.1V233.76c-2,2.05-2.07,5-3.36,7.35-4.44,8.28-11.79,12.56-20.32,15.35H26.32c-.6-1.55-2.21-1.23-3.33-1.66C11,250.24,3.67,240.05,3.66,227.25Q3.57,130.14,3.66,33c0-16.47,12.58-29.12,29-29.15q81.1-.15,162.2,0c10,0,19.47,2.82,26.63,9.82C235,26.9,251.24,38.17,256.26,58.1ZM129.61,214.25a47.35,47.35,0,1,0,.67-94.69c-25.81-.36-47.55,21.09-47.7,47.07A47.3,47.3,0,0,0,129.61,214.25ZM108.72,35.4c-17.93,0-35.85,0-53.77,0-6.23,0-9,2.8-9.12,9-.09,7.9-.07,15.79,0,23.68.06,6.73,2.81,9.47,9.72,9.48q53.27.06,106.55,0c7.08,0,9.94-2.85,10-9.84.08-7.39.06-14.79,0-22.19S169.35,35.42,162,35.41Q135.35,35.38,108.72,35.4Z"></path><path d="M232.58,256.46c8.53-2.79,15.88-7.07,20.32-15.35,1.29-2.4,1.38-5.3,3.36-7.35,0,6.74-.11,13.49.07,20.23.05,2.13-.41,2.58-2.53,2.53C246.73,256.35,239.65,256.46,232.58,256.46Z"></path></svg>
                            <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <span class="fs12 bold white">Save changes</span>
                        <input type="hidden" class="category-id" value="{{ $category->id }}" autocomplete="off">
                    </div>
                    @else
                    <div class="flex align-center typical-button-style disabled-typical-button-style mr8">
                        <svg class="size14 icon-above-spinner mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.26,58.1V233.76c-2,2.05-2.07,5-3.36,7.35-4.44,8.28-11.79,12.56-20.32,15.35H26.32c-.6-1.55-2.21-1.23-3.33-1.66C11,250.24,3.67,240.05,3.66,227.25Q3.57,130.14,3.66,33c0-16.47,12.58-29.12,29-29.15q81.1-.15,162.2,0c10,0,19.47,2.82,26.63,9.82C235,26.9,251.24,38.17,256.26,58.1ZM129.61,214.25a47.35,47.35,0,1,0,.67-94.69c-25.81-.36-47.55,21.09-47.7,47.07A47.3,47.3,0,0,0,129.61,214.25ZM108.72,35.4c-17.93,0-35.85,0-53.77,0-6.23,0-9,2.8-9.12,9-.09,7.9-.07,15.79,0,23.68.06,6.73,2.81,9.47,9.72,9.48q53.27.06,106.55,0c7.08,0,9.94-2.85,10-9.84.08-7.39.06-14.79,0-22.19S169.35,35.42,162,35.41Q135.35,35.38,108.72,35.4Z"></path><path d="M232.58,256.46c8.53-2.79,15.88-7.07,20.32-15.35,1.29-2.4,1.38-5.3,3.36-7.35,0,6.74-.11,13.49.07,20.23.05,2.13-.41,2.58-2.53,2.53C246.73,256.35,239.65,256.46,232.58,256.46Z"></path></svg>
                        <span class="fs12 bold white">Save changes</span>
                    </div>
                    @endif
                    <a href="{{ route('admin.forum.and.categories.dashboard') }}" class="no-underline bblack bold">{{ __('Return to dashboard') }}</a>
                </div>
            </div>
        @endif
    </div>
@endsection