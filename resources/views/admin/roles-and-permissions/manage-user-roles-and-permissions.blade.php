@extends('layouts.admin')

@section('title', 'R&P - Manage roles')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.rap', 'subpage'=>'admin.rap.manage.user'])
@endsection

@push('scripts')
<script src="{{ asset('js/admin/roles-and-permissions/users-management.js') }}" defer></script>
<script src="{{ asset('js/admin/roles-and-permissions/roles-management.js') }}" defer></script>
@endpush

@push('styles')
<link href="{{ asset('css/admin/rap.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/admin/user.css') }}" rel="stylesheet"/>
@endpush

@section('content')
    <style>
        #rap-members-search-result-box {
            padding: 8px;
            background-color: #f9f9f9;
            border: 1px solid #bdbdbd;
            border-top: unset;
            border-radius: 0 0 4px 4px;
            position: absolute;
        }

        .rap-search-member {
            padding: 8px;
            background-color: #f2f2f2;
            border: 1px solid #c3ced0;
            border-radius: 3px;
            transition: all 0.4s ease;
        }

        .rap-search-member:hover {
            background-color: #e4e8e8;
        }
    </style>
    <div class="flex align-center space-between top-page-title-box">
        <div class="flex align-center">
            <svg class="mr8 size20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
            <h1 class="fs22 no-margin lblack">{{ __('Manage user roles and permissions') }}</h1>
        </div>
        <div class="flex align-center height-max-content">
            <div class="flex align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                <a href="{{ route('admin.dashboard') }}" class="link-path">{{ __('Home') }}</a>
            </div>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Manage user roles and permissions') }}</span>
            </div>
        </div>
    </div>
    <div id="admin-main-content-box" style="min-height: 480px">
        @if(is_null($user))
        <div class="full-center flex-column" style='margin-top: 30px'>
            <h2 class="fs20 lblack no-margin">Search for a user</h2>
            <p class="fs13 lblack no-margin">Search for a user by username to manage</p>
            <div style="margin-top: 12px; min-width: 450px;">
                <div class="relative">
                    <svg class="absolute size14" fill="#5b5b5b" style="top: 10px; left: 12px;" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"></path></svg>
                    <input type="text" class="search-input-style full-width border-box" id="rap-member-search-input" autocomplete="off" placeholder="search by username">
                    <div class="button-style-4 full-center absolute" id="search-for-member-to-manage-rap" style="right: 0; top: 0; height: 18px;">
                        <svg class="size14 mr4" fill="#5b5b5b" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"></path></svg>
                        <span class="bold forum-color">search</span>
                    </div>
                </div>
                <div class="relative">
                    <div id="rap-members-search-result-box" class="full-width scrolly none" style="max-height: 300px;">
                        <input type="hidden" id="k" autocomplete="off">
                        <div class="results-container none">
                            results
                        </div>
                        <a href="" class="rap-search-member rap-search-member-factory mb4 flex no-underline none">
                            <input type="hidden" class="uid" autocomplete="off">
                            <img src="" class="size40 rounded mr8 user-avatar" alt="" style="border: 3px solid #9f9f9f;">
                            <div>
                                <p class="no-margin"><span class="bold user-fullname lblack">Mouad Nassri</span> - <span class="fs11 bold blue user-role">Site owner</span></p>
                                <span class="block bold fs12 lblack user-username">codename49</span>
                            </div>
                        </a>
                        <div id="rap-users-search-fetch-more-results" class="full-center none" style='height: 32px;'>
                            <svg class="spinner size20" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <!-- loading -->
                        <div class="search-loading full-center flex-column none" style="height: 65px">
                            <svg class="spinner size28 black" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                            <span class="fs12 lblack fs11 bold" style="margin-top: 5px;">searching</span>
                        </div>
                        <!-- no results found -->
                        <div class="no-results-found-box full-center none">
                            <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                            <p class="fs13 gray no-margin bold">Users not found with this username</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <input type="hidden" id="user-id" value="{{ $user->id }}" autocomplete="off">
        <!-- grant role to user -->
        @if($can_grant_role_to_user)
        <div id="grant-role-to-user-viewer" class="global-viewer full-center none">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div class="viewer-box-style-1" style="width: 600px;">
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                    <div class="flex align-center">
                        <svg class="size16 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.69,169.38a27,27,0,0,1-5.88,5.8q-34.91,27.48-69.75,55.06a14.94,14.94,0,0,1-9.89,3.47c-35.2-.18-69.89-4.6-104.24-12.07-2.74-.6-3.6-1.72-3.59-4.61q.21-38.29,0-76.58c0-2.65.72-4.14,3.09-5.4,11.29-6,23-7.36,34.58-1.79,14.76,7.07,30,11.26,46.44,11.65,13.83.32,25.22,12,27.06,25.75.44,3.24-.64,3.76-3.6,3.73-17.78-.13-35.57-.07-53.36-.06-6.18,0-9.58,2.68-9.56,7.43s3.41,7.38,9.61,7.38c16.8,0,33.6-.15,50.39.07a41,41,0,0,0,28.06-10.14c6.9-5.86,13.95-11.55,21.05-17.16s15-8.07,24-6.61c6.41,1,11.74,3.82,15.61,9.14ZM94.61,40.87c-6.3.1-8.86,2.69-8.93,9.09,0,3.13-.2,6.27,0,9.38.22,2.92-.49,4.19-3.7,3.89a88,88,0,0,0-9.88,0C66,63.31,63.6,65.73,63.44,72c-.09,3.29,0,6.59,0,9.88,0,9,2,11,11.15,11,19.94,0,39.87.1,59.8-.07,3.9,0,5.94.79,7.55,4.82,9.06,22.68,31.87,35.3,56,31.43,23-3.68,41.3-23.08,43.06-45.69,2-25.31-12.1-47-35.48-54.7-22.74-7.47-47.27,1.72-60.1,22.15-2.54,4-2.47,10.5-7.18,12s-10.11.34-15.21.34c-7.69,0-7.69,0-7.69-7.68,0-14-.62-14.61-14.79-14.61C98.57,40.87,96.59,40.84,94.61,40.87Zm72.66,37a22.2,22.2,0,1,1,22.27,22.29A22.18,22.18,0,0,1,167.27,77.88ZM48.69,149c.05-3.29-.57-4.55-4.22-4.46-10.52.26-21,.07-31.58.1-6.68,0-9.25,2.58-9.26,9.24q0,35.28,0,70.58c0,6.59,2.63,9.12,9.36,9.14q12.82.06,25.66,0c7.55,0,9.93-2.39,10-10.08,0-12.34,0-24.68,0-37C48.62,174,48.51,161.53,48.69,149ZM182.17,78.39a7.31,7.31,0,1,0,7.08-7.84A7.33,7.33,0,0,0,182.17,78.39Z"/></svg>
                        <span class="fs20 bold forum-color">{{ __('Grant role to user') }}</span>
                    </div>
                    <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div class="full-center relative">
                    <div class="flex full-dimensions y-auto-overflow" style="padding: 14px; min-height: 200px; max-height: 450px">
                        <div class="global-viewer-content-box height-max-content none">

                        </div>
                        <div class="role-selection-box flex flex-column full-width" style='min-height: 200px'>
                            <style>
                                .select-button-style {
                                    height: 76px;
                                    width: 76px;
                                    cursor: pointer;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-direction: column;
                                    border-radius: 50%;
                                    border: 6px solid #2ca0ff;
                                    color: #181818;
                                    margin: 8px 4px 2px 4px;
                                    transition: all 0.2s ease;
                                }

                                .select-button-style:hover {
                                    background-color: #2ca0ff;
                                    color: white;
                                }

                                .selected-role-to-grant-style {
                                    background-color: #5fb7ff;
                                    border-color: #5fb7ff;
                                    color: white;
                                    cursor: default;
                                }
                            </style>
                            <h3 class="no-margin mb4 forum-color">Select role</h3>
                            <p class="no-margin fs13">Select from the following list the role you want to attach to "<span class="bold blue">{{ $user->username }}</span>"</p>
                            <div class="flex align-center" style="flex: 1">
                                <div class="flex flex-wrap space-around full-width">
                                    @foreach($allroles as $role)
                                    <div>
                                        @php $hasrole = $user->has_role($role->slug); @endphp
                                        <div class="@if(!$hasrole) select-role-to-grant-viewer @else selected-role-to-grant-style @endif select-button-style">
                                            <input type="hidden" class="role-name" value="{{ $role->role }}" autocomplete="off">
                                            @if(!$hasrole)    
                                            <span class="fs11 italic">select :</span>
                                            @endif
                                            <span class="fs12 bold text-center unselectable" style="max-width: 60px;">{{ $role->role }}</span>
                                            <input type="hidden" class="role-id" value="{{ $role->id }}" autocomplete="off">
                                        </div>
                                        @if($hasrole)
                                        <span class="block italic text-center gray fs11">(has already)</span>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="loading-box flex flex-column align-center absolute none" style="margin-top: -20px">
                        <svg class="spinner size30 black" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                        <span class="fs12 bold gray mt8 loading-text">opening "<span class="role-name">admin</span>" role attaching viewer..</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- revoke role from user -->
        @if($can_revoke_role_from_user)
        <div id="revoke-role-from-user-viewer" class="global-viewer full-center none">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div class="viewer-box-style-1" style="width: 600px;">
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                    <div class="flex align-center">
                        <svg class="size16 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M167.69,256.92c-4.4-51.22,37.26-92.87,89-89,0,28.5-.05,57,.09,85.51,0,3-.6,3.55-3.55,3.54C224.71,256.86,196.2,256.92,167.69,256.92ZM19.86,3.86c-16.27,0-16.31.05-16.31,16.07q0,94.91,0,189.79c0,7.15,2.26,9.84,8.61,9.85,38.23.05,76.47,0,114.7.08,2.56,0,3.43-.63,3.3-3.27a77.64,77.64,0,0,1,1.45-19.65c8.29-39.74,41.06-66.4,81.87-66.2,5.11,0,6-1.32,6-6.12-.22-36.58-.11-73.15-.12-109.73,0-8.73-2.06-10.81-10.65-10.81H19.86Zm49.8,76.56c-4.07-4.07-4-4.72.84-9.54s5.56-5,9.55-1C90.24,80,100.39,90.26,111.43,101.34c0-5.58,0-10,0-14.31,0-3.5,1.63-5.17,5.14-5,1.64,0,3.29,0,4.94,0,3.26-.07,4.84,1.45,4.82,4.76,0,10.7.07,21.4-.06,32.1-.05,5-2.7,7.64-7.66,7.71-10.7.15-21.41,0-32.11.07-3.27,0-4.87-1.54-4.8-4.82,0-1.48.07-3,0-4.44-.24-3.94,1.48-5.8,5.52-5.66,4.21.14,8.44,0,13.87,0C89.94,100.65,79.78,90.55,69.66,80.42Z"/></svg>
                        <span class="fs20 bold forum-color">{{ __('Revoke role from user') }}</span>
                    </div>
                    <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div class="full-center relative">
                    <div class="global-viewer-content-box full-dimensions y-auto-overflow" style="padding: 14px; min-height: 200px; max-height: 450px">
                        
                    </div>
                    <div class="loading-box full-center absolute" style="margin-top: -20px">
                        <svg class="spinner size28 black" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- grant permissions viewer -->
        @if($can_grant_permission_to_user)
        <div id="attach-permissions-to-user-viewer" class="global-viewer full-center none">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div class="viewer-box-style-1" style="width: 600px;">
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                    <div class="flex align-center">
                        <svg class="size16 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M147,2.42h18.91c1.35,2,3.59,1,5.36,1.5C195.88,10.2,212.71,25.18,220,49.5s1.76,46.27-15.55,64.88c-9,9.71-18.69,18.84-28.07,28.23q-24.8,24.81-49.61,49.62C117,202,105.42,206.8,91.67,204.94c-16.76-2.27-28.49-11.59-33.88-27.58S56.28,146.94,68,134.82c7.74-8,15.69-15.74,23.54-23.6q26.58-26.56,53.16-53.11c5.57-5.53,12.73-6.59,19.14-3.16,6.25,3.36,9.28,9.85,8,17.21-.7,4.17-3.3,7.1-6.15,10q-37.34,37.27-74.6,74.6c-4.71,4.73-5,10.11-1.08,14.06,3.72,3.73,9.14,3.82,13.33-.36,26.32-26.22,52.79-52.3,78.68-78.95,13-13.34,11.8-34.73-1.36-47.5a34,34,0,0,0-48,.15q-40.71,40.23-80.92,81c-18.81,19.13-21.72,49.17-7.67,72.05,20.19,32.87,65.31,38.12,93,10.62,30.73-30.5,61.25-61.21,91.88-91.81,11.22-11.22,23.46-8.73,29.38,6v8c-1.76,2.32-3.27,4.88-5.31,6.93-31.6,31.69-63,63.58-95,94.86-21.81,21.31-48.64,29.56-78.53,24.23-35.29-6.3-59.88-27-71.14-61.12s-4.36-65.49,20.47-91.53c26.76-28.07,54.65-55,82.14-82.42,8.27-8.24,18.31-13.47,29.58-16.47C142.77,3.76,145.25,4.28,147,2.42Z"/></svg>
                        <span class="fs20 bold forum-color">Attach permissions to user</span>
                    </div>
                    <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div class="viewer-scrollable-box scrolly" style="padding: 14px; max-height: 430px">
                    <input type="hidden" id="at-least-one-selected-permission-to-user-attach-message" value="You need to select at least one permission to attach to user" autocomplete="off">
                    <div class="section-style fs13 lblack mb8">
                        <span class="fs15 bold forum-color">Attach permissions to "<span class="blue">{{ $user->username }}</span>" user</span>
                        <p class="no-margin mt8">Here you can attach permissions to "{{ $user->username }}". Before proceding this process, consider the following points</p>
                        <div class="ml8 mt8">
                            <div class="flex mt4">
                                <div class="fs10 mr8 mt4 gray">•</div>
                                <p class="no-margin" style="line-height: 1.5">Once the selected permissions get attached to this user, he will be able to <strong>perform all activities</strong> allowed by the selected permissions.</p>
                            </div>
                        </div>
                    </div>
                    <div class="simple-line-separator my4"></div>
                    <div style="margin-top: 14px;">
                        <span class="block fs12 forum-color bold mb4">Attach permissions to :</span>
                        <div class="section-style" style="padding: 6px">
                            <div class="flex">
                                <img src="{{ $user->sizedavatar(100, '-h') }}" class="size60 rounded" style="border: 1px solid #ddd;" alt="">
                                <div class="ml8">
                                    <h3 class="no-margin">{{ $user->fullname }}</h3>
                                    <span class="fs12 lblack bold block">{{ $user->username }}</span>
                                    @if($hr = $user->high_role())
                                    <span class="fs11 blue bold block">{{ $hr->role }}</span>
                                    @else
                                    <em class="fs11 gray block">normal user</em>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 14px">
                        <div>
                            <style>
                                .already-attached-permission-button-style {
                                    font-size: 11px;
                                    border-radius: 4px;
                                    padding: 7px 12px;
                                    background-color: #e6ffe5;
                                    cursor: default;
                                    text-decoration: none;
                                    border: 1px solid #99bf98;
                                    transition: all 0.2s ease;
                                    font-weight: bold;
                                    color: #0d460d;
                                }
                            </style>
                            <span class="block fs12 forum-color bold">Select permissions to attach :</span>
                            <p class="fs13 gray no-margin mb4">Select at least one permission that you want to attach to this user</p>
                            <div id="all-permissions-box" class="flex flex-wrap section-style y-auto-overflow" style="padding: 10px; max-height: 260px;">
                                @foreach($allspermissions as $scope=>$permissions)
                                    <span class="block bold blue fs11 mb4" style="flex-basis: 100%">{{ ucfirst($scope) }}</span>
                                    @foreach($permissions as $permission)
                                        @if($permission->already_attached_to_user($user->username))
                                        <div class="already-attached-permission-button-style mr4 mb4 fs11" title="Permission already attached to '{{ $user->username }}'">
                                            <span>{{ $permission->permission }}</span>
                                            <span class="block fs10 normal-weight">(already atached)</span>
                                        </div>
                                        @else
                                        <div class="button-style-4 custom-checkbox-button flex align-center mr4 mb4 fs11 height-max-content permission-to-attach-to-user">
                                            <span class="permission-name">{{ $permission->permission }}</span>
                                            <div class="custom-checkbox size12 ml8" style="border-radius: 2px">
                                                <svg class="size10 custom-checkbox-tick none" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M173.9,439.4,7.5,273a25.59,25.59,0,0,1,0-36.2l36.2-36.2a25.59,25.59,0,0,1,36.2,0L192,312.69,432.1,72.6a25.59,25.59,0,0,1,36.2,0l36.2,36.2a25.59,25.59,0,0,1,0,36.2L210.1,439.4a25.59,25.59,0,0,1-36.2,0Z"/></svg>
                                                <input type="hidden" class="checkbox-status" autocomplete="off" value="0">
                                                <input type="hidden" class="pid" value="{{ $permission->id }}" autocomplete="off">
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="simple-line-separator mt8 mb4"></div>
                    <div style="margin-top: 12px">
                        <p class="no-margin mb2 bold forum-color">Confirmation</p>
                        <p class="no-margin mb4 bblack">Please type <strong>{{ auth()->user()->username }}::attach-permissions-to::{{ $user->username }}</strong> to confirm.</p>
                        <div>
                            <input type="text" autocomplete="off" class="full-width input-style-1" id="attach-permissions-to-user-confirm-input" style="padding: 8px 10px" placeholder="attach permission(s) to user confirmation">
                            <input type="hidden" id="attach-permissions-to-user-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}::attach-permissions-to::{{ $user->username }}">
                        </div>
                        <div class="flex align-center" style="margin-top: 12px">
                            <div id="attach-permissions-to-user-button" class="disabled-green-button-style green-button-style full-center">
                                <div class="relative size14 mr4">
                                    <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M147,2.42h18.91c1.35,2,3.59,1,5.36,1.5C195.88,10.2,212.71,25.18,220,49.5s1.76,46.27-15.55,64.88c-9,9.71-18.69,18.84-28.07,28.23q-24.8,24.81-49.61,49.62C117,202,105.42,206.8,91.67,204.94c-16.76-2.27-28.49-11.59-33.88-27.58S56.28,146.94,68,134.82c7.74-8,15.69-15.74,23.54-23.6q26.58-26.56,53.16-53.11c5.57-5.53,12.73-6.59,19.14-3.16,6.25,3.36,9.28,9.85,8,17.21-.7,4.17-3.3,7.1-6.15,10q-37.34,37.27-74.6,74.6c-4.71,4.73-5,10.11-1.08,14.06,3.72,3.73,9.14,3.82,13.33-.36,26.32-26.22,52.79-52.3,78.68-78.95,13-13.34,11.8-34.73-1.36-47.5a34,34,0,0,0-48,.15q-40.71,40.23-80.92,81c-18.81,19.13-21.72,49.17-7.67,72.05,20.19,32.87,65.31,38.12,93,10.62,30.73-30.5,61.25-61.21,91.88-91.81,11.22-11.22,23.46-8.73,29.38,6v8c-1.76,2.32-3.27,4.88-5.31,6.93-31.6,31.69-63,63.58-95,94.86-21.81,21.31-48.64,29.56-78.53,24.23-35.29-6.3-59.88-27-71.14-61.12s-4.36-65.49,20.47-91.53c26.76-28.07,54.65-55,82.14-82.42,8.27-8.24,18.31-13.47,29.58-16.47C142.77,3.76,145.25,4.28,147,2.42Z"/></svg>
                                    <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                </div>
                                <span class="bold">Attach permissions to user</span>
                            </div>
                            <span class="bold no-underline forum-color pointer close-global-viewer ml8">cancel</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- revoke permissions from a user -->
        @if($can_revoke_permission_from_user)
        <div id="detach-permissions-from-user-viewer" class="global-viewer full-center none">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div class="viewer-box-style-1" style="width: 600px;">
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                    <div class="flex align-center">
                        <svg class="size16 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M167.69,256.92c-4.4-51.22,37.26-92.87,89-89,0,28.5-.05,57,.09,85.51,0,3-.6,3.55-3.55,3.54C224.71,256.86,196.2,256.92,167.69,256.92ZM19.86,3.86c-16.27,0-16.31.05-16.31,16.07q0,94.91,0,189.79c0,7.15,2.26,9.84,8.61,9.85,38.23.05,76.47,0,114.7.08,2.56,0,3.43-.63,3.3-3.27a77.64,77.64,0,0,1,1.45-19.65c8.29-39.74,41.06-66.4,81.87-66.2,5.11,0,6-1.32,6-6.12-.22-36.58-.11-73.15-.12-109.73,0-8.73-2.06-10.81-10.65-10.81H19.86Zm49.8,76.56c-4.07-4.07-4-4.72.84-9.54s5.56-5,9.55-1C90.24,80,100.39,90.26,111.43,101.34c0-5.58,0-10,0-14.31,0-3.5,1.63-5.17,5.14-5,1.64,0,3.29,0,4.94,0,3.26-.07,4.84,1.45,4.82,4.76,0,10.7.07,21.4-.06,32.1-.05,5-2.7,7.64-7.66,7.71-10.7.15-21.41,0-32.11.07-3.27,0-4.87-1.54-4.8-4.82,0-1.48.07-3,0-4.44-.24-3.94,1.48-5.8,5.52-5.66,4.21.14,8.44,0,13.87,0C89.94,100.65,79.78,90.55,69.66,80.42Z"/></svg>
                        <span class="fs20 bold forum-color">Detach permissions from user</span>
                    </div>
                    <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div class="viewer-scrollable-box scrolly" style="padding: 14px; max-height: 430px">
                    <input type="hidden" id="at-least-one-selected-permission-to-user-detach-message" value="You need to select at least one permission to fetach from user" autocomplete="off">
                    <div class="section-style fs13 lblack mb8">
                        <span class="fs15 bold forum-color">Detach permissions from "<span class="blue">{{ $user->username }}</span>" user</span>
                        <p class="no-margin mt8">Here you can detach permissions from "{{ $user->username }}". Before proceding this process, consider the following points</p>
                        <div class="ml8 mt8">
                            <div class="flex mt4">
                                <div class="fs10 mr8 mt4 gray">•</div>
                                <p class="no-margin" style="line-height: 1.5">Once the selected permissions get detached from this user, he will not be able to <strong>perform any activity</strong> associated with the selected permissions.</p>
                            </div>
                        </div>
                    </div>
                    <div class="simple-line-separator my4"></div>
                    <div style="margin-top: 14px;">
                        <span class="block fs12 forum-color bold mb4">Detach permissions from :</span>
                        <div class="section-style" style="padding: 6px">
                            <div class="flex">
                                <img src="{{ $user->sizedavatar(100, '-h') }}" class="size60 rounded" style="border: 1px solid #ddd;" alt="">
                                <div class="ml8">
                                    <h3 class="no-margin">{{ $user->fullname }}</h3>
                                    <span class="fs12 lblack bold block">{{ $user->username }}</span>
                                    @if($hr = $user->high_role())
                                    <span class="fs11 blue bold block">{{ $hr->role }}</span>
                                    @else
                                    <em class="fs11 gray block">normal user</em>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 14px">
                        <div>
                            <span class="block fs12 forum-color bold">Select permissions to detach :</span>
                            <p class="fs13 gray no-margin mb4">The following permissions are already granted to this user. You need to select at least one permission that you want to detach from this user</p>
                            <div id="all-permissions-box" class="flex flex-wrap section-style y-auto-overflow" style="padding: 10px; max-height: 260px;">
                                @foreach($spermissions as $scope=>$permissions)
                                    <span class="block bold blue fs11 mb4" style="flex-basis: 100%">{{ ucfirst($scope) }}</span>
                                    @foreach($permissions as $permission)
                                    <div class="button-style-4 custom-checkbox-button flex align-center mr4 mb4 fs11 height-max-content permission-to-detach-from-user">
                                        <span class="permission-name">{{ $permission->permission }}</span>
                                        <div class="custom-checkbox size12 ml8" style="border-radius: 2px">
                                            <svg class="size10 custom-checkbox-tick none" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M173.9,439.4,7.5,273a25.59,25.59,0,0,1,0-36.2l36.2-36.2a25.59,25.59,0,0,1,36.2,0L192,312.69,432.1,72.6a25.59,25.59,0,0,1,36.2,0l36.2,36.2a25.59,25.59,0,0,1,0,36.2L210.1,439.4a25.59,25.59,0,0,1-36.2,0Z"/></svg>
                                            <input type="hidden" class="checkbox-status" autocomplete="off" value="0">
                                            <input type="hidden" class="pid" value="{{ $permission->id }}" autocomplete="off">
                                        </div>
                                    </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="simple-line-separator mt8 mb4"></div>
                    <div style="margin-top: 12px">
                        <p class="no-margin mb2 bold forum-color">Confirmation</p>
                        <p class="no-margin mb4 bblack">Please type <strong>{{ auth()->user()->username }}::detach-permissions-from::{{ $user->username }}</strong> to confirm.</p>
                        <div>
                            <input type="text" autocomplete="off" class="full-width input-style-1" id="detach-permissions-from-user-confirm-input" style="padding: 8px 10px" placeholder="attach permission(s) to user confirmation">
                            <input type="hidden" id="detach-permissions-from-user-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}::detach-permissions-from::{{ $user->username }}">
                        </div>
                        <div class="flex align-center" style="margin-top: 12px">
                            <div id="detach-permissions-from-user-button" class="disabled-red-button-style red-button-style full-center">
                                <div class="relative size14 mr4">
                                    <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M167.69,256.92c-4.4-51.22,37.26-92.87,89-89,0,28.5-.05,57,.09,85.51,0,3-.6,3.55-3.55,3.54C224.71,256.86,196.2,256.92,167.69,256.92ZM19.86,3.86c-16.27,0-16.31.05-16.31,16.07q0,94.91,0,189.79c0,7.15,2.26,9.84,8.61,9.85,38.23.05,76.47,0,114.7.08,2.56,0,3.43-.63,3.3-3.27a77.64,77.64,0,0,1,1.45-19.65c8.29-39.74,41.06-66.4,81.87-66.2,5.11,0,6-1.32,6-6.12-.22-36.58-.11-73.15-.12-109.73,0-8.73-2.06-10.81-10.65-10.81H19.86Zm49.8,76.56c-4.07-4.07-4-4.72.84-9.54s5.56-5,9.55-1C90.24,80,100.39,90.26,111.43,101.34c0-5.58,0-10,0-14.31,0-3.5,1.63-5.17,5.14-5,1.64,0,3.29,0,4.94,0,3.26-.07,4.84,1.45,4.82,4.76,0,10.7.07,21.4-.06,32.1-.05,5-2.7,7.64-7.66,7.71-10.7.15-21.41,0-32.11.07-3.27,0-4.87-1.54-4.8-4.82,0-1.48.07-3,0-4.44-.24-3.94,1.48-5.8,5.52-5.66,4.21.14,8.44,0,13.87,0C89.94,100.65,79.78,90.55,69.66,80.42Z"/></svg>
                                    <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                </div>
                                <span class="bold">Detach permissions from user</span>
                            </div>
                            <span class="bold no-underline forum-color pointer close-global-viewer ml8">cancel</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(Session::has('message'))
            <div class="green-message-container mb8">
                <p class="green-message">{!! Session::get('message') !!}</p>
            </div>
        @endif
        <div class="um-media-box relative">
            <div class="um-cover-container pointer">
                @if($user->cover)
                <img src="{{ $user->cover }}" class="um-cover" alt="">
                @endif
            </div>
            <div class="um-after-cover flex">
                <img src="{{ $user->sizedavatar(100, '-h') }}" class="um-avatar pointer" style="border: 1px solid #ddd;" alt="">
                <div class="flex space-between full-width height-max-content">
                    <div class="ml8 mt4">
                        <a href="{{ $user->profilelink }}" class="no-underline blue bold no-margin lblack fs20">{{ $user->fullname }}</a>
                        <p class="no-margin lblack fs13">username: <span class="bold">{{ $user->username }}</span></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- user roles -->
        <div style="margin-top: 12px">
            <div class="flex align-center mb4">
                <div class="flex align-center">
                    <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.12,231.24c2.31-3.71,3.06-8.13,5.64-11.76a36.53,36.53,0,0,1,14.13-11.94c-6-5.69-9.23-12.14-8.34-20.21a21.81,21.81,0,0,1,8-14.77,22.21,22.21,0,0,1,30,1.73c8.91,9.18,8.22,21.91-1.78,32.9,2.87,2.14,5.94,4.06,8.58,6.46,7.19,6.54,10.59,14.89,10.81,24.54.14,6.25.1,12.5.14,18.75-21.12,0-42.23-.05-63.34.06-2.81,0-4.05-.27-3.9-3.64C3.35,246,3.12,238.61,3.12,231.24Zm252.72,25.7c0-6.42.14-12.85,0-19.26-.32-11.65-5.39-20.8-15-27.44-1.46-1-3-1.93-4.51-2.92,10.06-10.85,11-23,2.57-32.36A22.2,22.2,0,0,0,209,172a21.26,21.26,0,0,0-8.41,13.48c-1.51,8.68,1.38,16,7.89,21.91-13.05,7.83-19.22,17.23-19.62,29.81-.21,6.58-.12,13.17-.17,19.75Zm-92.8,0c0-6.42.09-12.85-.09-19.27a33,33,0,0,0-13-26c-2-1.61-4.3-2.92-6.49-4.38,10.35-11,10.92-24.16,1.56-33.38a22.16,22.16,0,0,0-30.72-.32c-9.69,9.21-9.27,22.38,1.27,33.8-1.28.78-2.53,1.49-3.74,2.29-9.73,6.38-15.15,15.39-15.76,27-.36,6.73-.12,13.5-.15,20.25ZM96,77.28a87.53,87.53,0,0,1-.07,11.34c-.45,4.15,1.32,4.76,4.94,4.72,16.77-.17,33.53-.06,50.3-.08,3.77,0,8.79,1.31,11-.59,2.61-2.26.6-7.43.87-11.33,1.1-16.44-4.23-29.59-19.56-37.45C153.86,32,154.27,19,144.7,9.93A22.16,22.16,0,0,0,114,10.2c-9.3,9.07-8.77,22.19,1.61,33.66C102.06,51.07,95.58,62.15,96,77.28ZM33.4,122.86c-3.47,0-4.5,1-4.39,4.42.26,7.41.15,14.83,0,22.24,0,2.26.6,3.1,3,3.26,11.75.78,11.88.86,11.82-10.59,0-3.45.94-4.44,4.4-4.41,20.88.15,41.77.07,62.66.07,10.84,0,10.94,0,11,10.87,0,2.82.48,4,3.73,4.09,11,.13,11.14.28,11.15-10.84,0-3.16.78-4.21,4.09-4.19q35,.21,70.07,0c3.36,0,4,1.15,4.05,4.25,0,11.09.12,10.95,11.17,10.78,3.27-.06,3.75-1.34,3.69-4.12-.16-7.08-.29-14.18,0-21.25.18-3.85-1.16-4.6-4.74-4.58-25.82.14-51.65.08-77.47.08-10.66,0-10.76,0-10.76-10.63,0-3-.48-4.34-4-4.34-10.85,0-11-.17-10.9,10.6,0,3.39-.79,4.5-4.33,4.45-14-.21-28-.08-41.94-.08C61.69,122.94,47.54,123.05,33.4,122.86Z"/></svg>
                    <p class="no-margin bold forum-color fs16">Roles acquired</p>
                </div>
                <div class="gray height-max-content fs8 bold" style="margin: 0 12px">•</div>
                @if($can_grant_role_to_user)
                <div class="green-button-style flex align-center open-grant-role-to-user-dialog" style="padding: 6px 9px">
                    <svg class="size14 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.69,169.38a27,27,0,0,1-5.88,5.8q-34.91,27.48-69.75,55.06a14.94,14.94,0,0,1-9.89,3.47c-35.2-.18-69.89-4.6-104.24-12.07-2.74-.6-3.6-1.72-3.59-4.61q.21-38.29,0-76.58c0-2.65.72-4.14,3.09-5.4,11.29-6,23-7.36,34.58-1.79,14.76,7.07,30,11.26,46.44,11.65,13.83.32,25.22,12,27.06,25.75.44,3.24-.64,3.76-3.6,3.73-17.78-.13-35.57-.07-53.36-.06-6.18,0-9.58,2.68-9.56,7.43s3.41,7.38,9.61,7.38c16.8,0,33.6-.15,50.39.07a41,41,0,0,0,28.06-10.14c6.9-5.86,13.95-11.55,21.05-17.16s15-8.07,24-6.61c6.41,1,11.74,3.82,15.61,9.14ZM94.61,40.87c-6.3.1-8.86,2.69-8.93,9.09,0,3.13-.2,6.27,0,9.38.22,2.92-.49,4.19-3.7,3.89a88,88,0,0,0-9.88,0C66,63.31,63.6,65.73,63.44,72c-.09,3.29,0,6.59,0,9.88,0,9,2,11,11.15,11,19.94,0,39.87.1,59.8-.07,3.9,0,5.94.79,7.55,4.82,9.06,22.68,31.87,35.3,56,31.43,23-3.68,41.3-23.08,43.06-45.69,2-25.31-12.1-47-35.48-54.7-22.74-7.47-47.27,1.72-60.1,22.15-2.54,4-2.47,10.5-7.18,12s-10.11.34-15.21.34c-7.69,0-7.69,0-7.69-7.68,0-14-.62-14.61-14.79-14.61C98.57,40.87,96.59,40.84,94.61,40.87Zm72.66,37a22.2,22.2,0,1,1,22.27,22.29A22.18,22.18,0,0,1,167.27,77.88ZM48.69,149c.05-3.29-.57-4.55-4.22-4.46-10.52.26-21,.07-31.58.1-6.68,0-9.25,2.58-9.26,9.24q0,35.28,0,70.58c0,6.59,2.63,9.12,9.36,9.14q12.82.06,25.66,0c7.55,0,9.93-2.39,10-10.08,0-12.34,0-24.68,0-37C48.62,174,48.51,161.53,48.69,149ZM182.17,78.39a7.31,7.31,0,1,0,7.08-7.84A7.33,7.33,0,0,0,182.17,78.39Z"/></svg>
                    <span class="fs11 bold">grant role</span>
                </div>
                @else
                <div class="disabled-green-button-style green-button-style flex align-center" title="you don't have permission to grant roles to users" style="padding: 6px 9px">
                    <svg class="size14 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.69,169.38a27,27,0,0,1-5.88,5.8q-34.91,27.48-69.75,55.06a14.94,14.94,0,0,1-9.89,3.47c-35.2-.18-69.89-4.6-104.24-12.07-2.74-.6-3.6-1.72-3.59-4.61q.21-38.29,0-76.58c0-2.65.72-4.14,3.09-5.4,11.29-6,23-7.36,34.58-1.79,14.76,7.07,30,11.26,46.44,11.65,13.83.32,25.22,12,27.06,25.75.44,3.24-.64,3.76-3.6,3.73-17.78-.13-35.57-.07-53.36-.06-6.18,0-9.58,2.68-9.56,7.43s3.41,7.38,9.61,7.38c16.8,0,33.6-.15,50.39.07a41,41,0,0,0,28.06-10.14c6.9-5.86,13.95-11.55,21.05-17.16s15-8.07,24-6.61c6.41,1,11.74,3.82,15.61,9.14ZM94.61,40.87c-6.3.1-8.86,2.69-8.93,9.09,0,3.13-.2,6.27,0,9.38.22,2.92-.49,4.19-3.7,3.89a88,88,0,0,0-9.88,0C66,63.31,63.6,65.73,63.44,72c-.09,3.29,0,6.59,0,9.88,0,9,2,11,11.15,11,19.94,0,39.87.1,59.8-.07,3.9,0,5.94.79,7.55,4.82,9.06,22.68,31.87,35.3,56,31.43,23-3.68,41.3-23.08,43.06-45.69,2-25.31-12.1-47-35.48-54.7-22.74-7.47-47.27,1.72-60.1,22.15-2.54,4-2.47,10.5-7.18,12s-10.11.34-15.21.34c-7.69,0-7.69,0-7.69-7.68,0-14-.62-14.61-14.79-14.61C98.57,40.87,96.59,40.84,94.61,40.87Zm72.66,37a22.2,22.2,0,1,1,22.27,22.29A22.18,22.18,0,0,1,167.27,77.88ZM48.69,149c.05-3.29-.57-4.55-4.22-4.46-10.52.26-21,.07-31.58.1-6.68,0-9.25,2.58-9.26,9.24q0,35.28,0,70.58c0,6.59,2.63,9.12,9.36,9.14q12.82.06,25.66,0c7.55,0,9.93-2.39,10-10.08,0-12.34,0-24.68,0-37C48.62,174,48.51,161.53,48.69,149ZM182.17,78.39a7.31,7.31,0,1,0,7.08-7.84A7.33,7.33,0,0,0,182.17,78.39Z"/></svg>
                    <span class="fs11 bold">grant role</span>
                </div>
                @endif
            </div>
            <div class="y-auto-overflow" style="max-height: 200px">
                @if($roles->count())
                <p class="my4 fs12 lblack lh15">The following role(s) are currently acquired by this user</p>
                <div class="flex flex-wrap">
                    @foreach($roles as $role)
                        <div class="button-style-4 flex align-center lblack bold fs12 mx4 my4 relative">
                            <span>{{ $role->role }}</span>
                            @if($can_revoke_role_from_user)
                            <div class="open-revoke-role-from-user-dialog x-close-container-style" style="right: -10px; top: -10px; width: 18px; height: 18px; min-width: 18px;">
                                <span class="x-close unselectable" style="font-size: 8px">✖</span>
                                <input type="hidden" class="role-id" value="{{ $role->id }}" autocomplete="off">
                            </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @else
                <div class="flex align-center section-style width-max-content">
                    <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                    <p class="no-margin fs12 italic gray">This user is a normal user and does not have any role for the moment</p>
                </div>
                @endif
            </div>
        </div>

        <!-- user permissions -->
        <div style="margin-top: 12px">
            <div class="flex align-center mb4">
                <div class="flex align-center">
                    <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130.34,245.7q-40.65,0-81.31,0c-10.29,0-13.65-3.39-13.65-13.66q0-60.49,0-121c0-9.82,3.61-13.39,13.47-13.41,5,0,9.93-.19,14.87.07,3,.15,3.43-1,3.47-3.63C67.32,83.05,66.29,72,69,61c7.38-29.7,34.36-49.32,66.07-47.81,28.86,1.38,53.84,24.47,58.24,53.66,1.36,9.06.6,18.15.71,27.22,0,2.69.58,3.73,3.49,3.61,5.61-.24,11.24-.14,16.86,0,7.2.11,11.43,4.23,11.44,11.43q.09,62.47,0,125c0,7.7-4.13,11.62-12.18,11.63Q172,245.76,130.34,245.7Zm-.09-148c13,0,26.09-.07,39.13,0,2.67,0,3.83-.49,3.71-3.47-.24-5.94.09-11.9-.12-17.83-.79-22.48-16.7-39.91-38.29-42.1-20.86-2.12-40.25,11.75-45.25,32.56-2.11,8.77-.85,17.76-1.32,26.65-.19,3.69,1.22,4.26,4.49,4.21C105.15,97.54,117.7,97.65,130.25,97.65Zm.37,42.41a31.73,31.73,0,0,0-.29,63.46,32,32,0,0,0,32-31.67A31.61,31.61,0,0,0,130.62,140.06Z"/></svg>
                    <p class="no-margin bold forum-color fs16">Permissions acquired</p>
                </div>
                <div class="flex align-center" style="margin-left: 14px">
                    @if($can_grant_permission_to_user)
                    <div class="green-button-style flex align-center open-attach-permissions-to-user-dialog" style="padding: 6px 9px">
                        <svg class="size10 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.22,3.31c3.07,2.55,4.08,5.71,4.06,9.78-.17,27.07,0,54.14-.18,81.21,0,3.57.69,4.66,4.49,4.63,27.24-.19,54.47-.11,81.71-.1,7.36,0,9.39,2,9.4,9.25q0,21.4,0,42.82c0,7-2.1,9.06-9.09,9.06-27.24,0-54.48.09-81.71-.09-3.85,0-4.83.95-4.8,4.81.17,27.07.1,54.14.09,81.21,0,7.65-1.94,9.59-9.56,9.6q-21.4,0-42.82,0c-6.62,0-8.75-2.19-8.75-8.91,0-27.4-.1-54.8.09-82.2,0-3.8-1.06-4.51-4.62-4.49-27.08.16-54.15,0-81.22.18-4.07,0-7.23-1-9.78-4.06V102.8c2.55-3.08,5.72-4.08,9.79-4.06,27.09.17,54.18,0,81.27.18,3.68,0,4.58-.87,4.55-4.56-.17-27.09,0-54.18-.18-81.27,0-4.06,1-7.23,4.06-9.78Z"></path></svg>
                        <span class="fs11 bold">direct permissions grant</span>
                    </div>
                    @else
                    <div class="disabled-green-button-style green-button-style flex align-center" title="you don't have permission to grant permissions directly to user" style="padding: 6px 9px">
                        <svg class="size10 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.22,3.31c3.07,2.55,4.08,5.71,4.06,9.78-.17,27.07,0,54.14-.18,81.21,0,3.57.69,4.66,4.49,4.63,27.24-.19,54.47-.11,81.71-.1,7.36,0,9.39,2,9.4,9.25q0,21.4,0,42.82c0,7-2.1,9.06-9.09,9.06-27.24,0-54.48.09-81.71-.09-3.85,0-4.83.95-4.8,4.81.17,27.07.1,54.14.09,81.21,0,7.65-1.94,9.59-9.56,9.6q-21.4,0-42.82,0c-6.62,0-8.75-2.19-8.75-8.91,0-27.4-.1-54.8.09-82.2,0-3.8-1.06-4.51-4.62-4.49-27.08.16-54.15,0-81.22.18-4.07,0-7.23-1-9.78-4.06V102.8c2.55-3.08,5.72-4.08,9.79-4.06,27.09.17,54.18,0,81.27.18,3.68,0,4.58-.87,4.55-4.56-.17-27.09,0-54.18-.18-81.27,0-4.06,1-7.23,4.06-9.78Z"></path></svg>
                        <span class="fs11 bold">direct permissions grant</span>
                    </div>
                    @endif
                    <div class="gray height-max-content fs8 bold mx8">•</div>
                    @if($can_revoke_permission_from_user)
                    <div class="red-button-style flex align-center open-detach-permissions-from-user-dialog" style="padding: 6px 9px">
                        <svg class="size12 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.19,144V114.32c2.06-1.67,1.35-4.2,1.78-6.3Q19.81,30.91,94.83,7.28c6.61-2.07,13.5-3.26,20.26-4.86h26.73c1.44,1.93,3.6.92,5.39,1.2C215,14.2,261.83,74.5,254.91,142.49c-6.25,61.48-57.27,110-119,113.3A127.13,127.13,0,0,1,4.9,155.18C4.09,151.45,4.42,147.42,2.19,144Zm126.75-30.7c-19.8,0-39.6.08-59.4-.08-3.24,0-4.14.82-4.05,4,.24,8.08.21,16.17,0,24.25-.07,2.83.77,3.53,3.55,3.53q59.89-.14,119.8,0c2.8,0,3.6-.74,3.53-3.54-.18-8.08-.23-16.17,0-24.25.1-3.27-.85-4.06-4.06-4C168.55,113.4,148.75,113.33,128.94,113.33Z"/></svg>
                        <span class="fs11 bold">direct permissions revoke</span>
                    </div>
                    @else
                    <div class="disabled-red-button-style red-button-style flex align-center" title="you don't have permission to revoke permissions directly from user" style="padding: 6px 9px">
                        <svg class="size12 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.19,144V114.32c2.06-1.67,1.35-4.2,1.78-6.3Q19.81,30.91,94.83,7.28c6.61-2.07,13.5-3.26,20.26-4.86h26.73c1.44,1.93,3.6.92,5.39,1.2C215,14.2,261.83,74.5,254.91,142.49c-6.25,61.48-57.27,110-119,113.3A127.13,127.13,0,0,1,4.9,155.18C4.09,151.45,4.42,147.42,2.19,144Zm126.75-30.7c-19.8,0-39.6.08-59.4-.08-3.24,0-4.14.82-4.05,4,.24,8.08.21,16.17,0,24.25-.07,2.83.77,3.53,3.55,3.53q59.89-.14,119.8,0c2.8,0,3.6-.74,3.53-3.54-.18-8.08-.23-16.17,0-24.25.1-3.27-.85-4.06-4.06-4C168.55,113.4,148.75,113.33,128.94,113.33Z"/></svg>
                        <span class="fs11 bold">direct permissions revoke</span>
                    </div>
                    @endif
                </div>
            </div>
            <p class="my4 fs12 lblack lh15">The following permissions are currently acquired by this user</p>
            <div class="y-auto-overflow mt4" style="max-height: 250px;">
                @if($spermissions->count())
                <div class="section-style" style="padding: 10px">
                    @foreach($spermissions as $scope=>$permissions)
                        <span class="block bold blue fs11 mb4">{{ ucfirst($scope) }}</span>
                        <div class="flex flex-wrap">
                        @foreach($permissions as $permission)
                            <div class="button-style-4 mx4 my4 full-center relative">
                                <span class="permission-name fs11">{{ $permission->permission }}</span>
                                <input type="hidden" class="pid" value="{{ $permission->id }}" autocomplete="off">
                            </div>
                        @endforeach
                        </div>
                    @endforeach
                </div>
                @else
                <div class="flex align-center section-style width-max-content">
                    <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                    <em class="fs12 gray">This user does not have any attached permissions for the moment</em>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
@endsection