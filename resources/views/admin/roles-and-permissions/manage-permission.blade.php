@extends('layouts.admin')

@section('title', 'R&P - Manage permissions')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.rap', 'subpage'=>'admin.rap.manage.permission'])
@endsection

@push('scripts')
<script src="{{ asset('js/admin/roles-and-permissions/permissions-management.js') }}" defer></script>
<script src="{{ asset('js/admin/permissions/update-infos.js') }}" defer></script>
<script src="{{ asset('js/admin/permissions/grant.js') }}" defer></script>
<script src="{{ asset('js/admin/permissions/revoke.js') }}" defer></script>
<script src="{{ asset('js/admin/permissions/delete.js') }}" defer></script>
@endpush

@push('styles')
<link href="{{ asset('css/admin/rap.css') }}" rel="stylesheet"/>
@endpush

@section('content')
    <div class="flex align-center space-between top-page-title-box">
        <div class="flex align-center">
            <svg class="mr8 size20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130.34,245.7q-40.65,0-81.31,0c-10.29,0-13.65-3.39-13.65-13.66q0-60.49,0-121c0-9.82,3.61-13.39,13.47-13.41,5,0,9.93-.19,14.87.07,3,.15,3.43-1,3.47-3.63C67.32,83.05,66.29,72,69,61c7.38-29.7,34.36-49.32,66.07-47.81,28.86,1.38,53.84,24.47,58.24,53.66,1.36,9.06.6,18.15.71,27.22,0,2.69.58,3.73,3.49,3.61,5.61-.24,11.24-.14,16.86,0,7.2.11,11.43,4.23,11.44,11.43q.09,62.47,0,125c0,7.7-4.13,11.62-12.18,11.63Q172,245.76,130.34,245.7Zm-.09-148c13,0,26.09-.07,39.13,0,2.67,0,3.83-.49,3.71-3.47-.24-5.94.09-11.9-.12-17.83-.79-22.48-16.7-39.91-38.29-42.1-20.86-2.12-40.25,11.75-45.25,32.56-2.11,8.77-.85,17.76-1.32,26.65-.19,3.69,1.22,4.26,4.49,4.21C105.15,97.54,117.7,97.65,130.25,97.65Zm.37,42.41a31.73,31.73,0,0,0-.29,63.46,32,32,0,0,0,32-31.67A31.61,31.61,0,0,0,130.62,140.06Z"/></svg>
            <h1 class="fs22 no-margin lblack">{{ __('Manage a permission') }}</h1>
        </div>
        <div class="flex align-center height-max-content">
            <div class="flex align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                <a href="{{ route('admin.dashboard') }}" class="link-path">{{ __('Home') }}</a>
            </div>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Manage a permission') }}</span>
            </div>
        </div>
    </div>
    <!-- create permission viewer -->
    @if($cancreate)
    <div id="create-permission-viewer" class="global-viewer full-center none">
        <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
        <div class="global-viewer-content-box viewer-box-style-1" style="width: 600px;">
            <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                <div class="flex align-center">
                    <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.22,3.31c3.07,2.55,4.08,5.71,4.06,9.78-.17,27.07,0,54.14-.18,81.21,0,3.57.69,4.66,4.49,4.63,27.24-.19,54.47-.11,81.71-.1,7.36,0,9.39,2,9.4,9.25q0,21.4,0,42.82c0,7-2.1,9.06-9.09,9.06-27.24,0-54.48.09-81.71-.09-3.85,0-4.83.95-4.8,4.81.17,27.07.1,54.14.09,81.21,0,7.65-1.94,9.59-9.56,9.6q-21.4,0-42.82,0c-6.62,0-8.75-2.19-8.75-8.91,0-27.4-.1-54.8.09-82.2,0-3.8-1.06-4.51-4.62-4.49-27.08.16-54.15,0-81.22.18-4.07,0-7.23-1-9.78-4.06V102.8c2.55-3.08,5.72-4.08,9.79-4.06,27.09.17,54.18,0,81.27.18,3.68,0,4.58-.87,4.55-4.56-.17-27.09,0-54.18-.18-81.27,0-4.06,1-7.23,4.06-9.78Z"/></svg>
                    <span class="fs20 bold forum-color">{{ __('Create a new permission') }}</span>
                </div>
                <div class="pointer fs20 close-global-viewer unselectable">✖</div>
            </div>
            <div class="viewer-scrollable-box scrolly" style="padding: 14px; max-height: 430px">
                <!-- messages and inputs -->
                <input type="hidden" id="existing-permissions-names" value="{{ $permissions->pluck('permission')->implode(',') }}" autocomplete="off">
                <input type="hidden" id="existing-permissions-slugs" value="{{ $permissions->pluck('slug')->implode(',') }}" autocomplete="off">
                <input type="hidden" id="existing-permissions-scopes" value="{{ $pscopes->implode(',') }}" autocomplete="off">
                <input type="hidden" id="create-permission-scope-type" value="select" autocomplete="off">

                <input type="hidden" id="permission-name-already-exists" value="Permission name already exists" autocomplete="off">
                <input type="hidden" id="permission-slug-already-exists" value="Permission slug already exists" autocomplete="off">
                <input type="hidden" id="permission-name-required" value="Permission name is required" autocomplete="off">
                <input type="hidden" id="permission-slug-required" value="Permission slug is required" autocomplete="off">
                <input type="hidden" id="permission-description-required" value="Permission description is required" autocomplete="off">
                <input type="hidden" id="permission-scope-required" value="Permission scope is required" autocomplete="off">

                <div class="section-style fs13 lblack mb8">
                    <p class="no-margin">Here you can create a new permission and start attach it to roles and grant it to users.</p>
                    <div class="ml8 mt8">
                        <div class="flex mt4">
                            <div class="fs10 mr8 mt4 gray">•</div>
                            <p class="no-margin" style="line-height: 1.5">Permission name and slug <strong>must be unique</strong>. (You cannot have two permissions with the same name or slug).</p>
                        </div>
                    </div>
                </div>
                <div class="simple-line-separator my4"></div>
                <div>
                    <div class="flex align-center">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <p class="my8 bold forum-color">Permission Informations</p>
                    </div>
                    <div class="my8 create-permission-error-container none">
                        <div class="flex">
                            <svg class="size12 mr4" style="min-width: 14px; margin-top: 1px" fill="rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                            <span class="error fs13 bold no-margin create-permission-error"></span>
                        </div>
                    </div>
                    <div class="mb8">
                        <label for="create-permission-name-input" class="flex align-center bold forum-color fs13">{{ __('Name') }}<span class="ml4 err red none fs12">*</span></label>
                        <p class="no-margin fs12 mb4 gray">Permission name should not contain commas(,) because we use it as separator for existing names</p>
                        <input type="text" autocomplete="off" class="input-style-1 full-width" id="create-permission-name-input" placeholder="permission name" style="padding: 8px 10px">
                    </div>
                    <div class="mb8">
                        <label for="create-permission-slug-input" class="flex align-center bold forum-color fs13">{{ __('Slug') }}<span class="ml4 err red none fs12">*</span></label>
                        <p class="no-margin fs12 mb4 gray">Permission slug also should not contain commas(,) for the same reason as names</p>
                        <input type="text" autocomplete="off" class="input-style-1 full-width" id="create-permission-slug-input" placeholder="permission slug" style="padding: 8px 10px">
                    </div>
                    <div class="mb8">
                        <label for="create-permission-description-input" class="flex align-center bold forum-color mb4 fs13">{{ __('Description') }}<span class="ml4 err red none fs12">*</span></label>
                        <textarea id="create-permission-description-input" class="styled-textarea fs14"
                            style="margin: 0; padding: 8px; width: 100%; min-height: 110px; max-height: 110px;"
                            maxlength="800"
                            spellcheck="false"
                            autocomplete="off"
                            placeholder="{{ __('Permission description here') }}"></textarea>
                    </div>
                    <div class="mb8">
                        <label for="create-permission-scope-input" class="flex align-center bold forum-color fs13">{{ __('Scope') }}<span class="ml4 err red none fs12">*</span></label>
                        <p class="no-margin fs12 mb4 gray">Specify the scope where the permission will belong to, or create a new scope</p>

                        <div>
                            <div class="flex align-center">
                                <input type="radio" class="create-permission-scope-switch mr8" name="scope-switch" autocomplete="off" checked>
                                <div>
                                    <p class="fs13 no-margin gray mb4">Choose an existing scope</p>
                                    <select name="create-permission-scope-input" id="create-permission-scope-input" class="dropdown-style animated-input-selection">
                                        @foreach($pscopes as $scope)
                                        <option value="{{ $scope }}">{{ ucfirst($scope) }} <span class="gray">- management</span></option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="simple-line-separator half-width my8"></div>
                            <div class="flex align-center">
                                <input type="radio" class="create-permission-new-scope-switch mr8" name="scope-switch" autocomplete="off">
                                <div>
                                    <div class="flex align-center my4 none" id="scope-already-exists">
                                        <svg class="size12 mr4" fill="#8e3c23" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                        <span class="fs12" style="color: #8e3c23;">this scope already exists in the existings. Its better to choose it from there</span>
                                    </div>
                                    <p class="fs13 no-margin gray mb4">Create a new scope (should be lower-case & space between words & not already exists)</p>
                                    <input type="text" autocomplete="off" class="input-style-1 full-width" id="create-permission-new-scope-input" placeholder="New scope" style="padding: 8px 10px" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="simple-line-separator my8"></div>
                <p class="my8 bold forum-color">Confirmation</p>
                <p class="no-margin mb4 bblack">Please type <strong>{{ auth()->user()->username }}::create-permission</strong> to confirm.</p>
                <div>
                    <input type="text" autocomplete="off" class="full-width input-style-1" id="create-permission-confirm-input" style="padding: 8px 10px" placeholder="confirmation">
                    <input type="hidden" id="create-permission-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}::create-permission">
                </div>
                <div class="flex" style="margin-top: 12px">
                    <div class="flex align-center full-width">
                        <div id="create-permission-button" class="disabled-green-button-style green-button-style full-center full-width">
                            <div class="relative size14 mr4">
                                <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.22,3.31c3.07,2.55,4.08,5.71,4.06,9.78-.17,27.07,0,54.14-.18,81.21,0,3.57.69,4.66,4.49,4.63,27.24-.19,54.47-.11,81.71-.1,7.36,0,9.39,2,9.4,9.25q0,21.4,0,42.82c0,7-2.1,9.06-9.09,9.06-27.24,0-54.48.09-81.71-.09-3.85,0-4.83.95-4.8,4.81.17,27.07.1,54.14.09,81.21,0,7.65-1.94,9.59-9.56,9.6q-21.4,0-42.82,0c-6.62,0-8.75-2.19-8.75-8.91,0-27.4-.1-54.8.09-82.2,0-3.8-1.06-4.51-4.62-4.49-27.08.16-54.15,0-81.22.18-4.07,0-7.23-1-9.78-4.06V102.8c2.55-3.08,5.72-4.08,9.79-4.06,27.09.17,54.18,0,81.27.18,3.68,0,4.58-.87,4.55-4.56-.17-27.09,0-54.18-.18-81.27,0-4.06,1-7.23,4.06-9.78Z"/></svg>
                                <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                </svg>
                            </div>
                            <span class="bold unselectable">Create permission</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div id="admin-main-content-box">
        @if(is_null($permission))
            <div class="flex align-center mb4">
                <h2 class="no-margin fs20 lblack">Select a permission</h2>
                <div class="gray height-max-content fs10 bold" style="margin: 0 12px">•</div>
                @if($cancreate)
                <div class="green-button-style width-max-content flex align-center my4 open-create-permission-dialog">
                    <svg class="size10 mr8" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.22,3.31c3.07,2.55,4.08,5.71,4.06,9.78-.17,27.07,0,54.14-.18,81.21,0,3.57.69,4.66,4.49,4.63,27.24-.19,54.47-.11,81.71-.1,7.36,0,9.39,2,9.4,9.25q0,21.4,0,42.82c0,7-2.1,9.06-9.09,9.06-27.24,0-54.48.09-81.71-.09-3.85,0-4.83.95-4.8,4.81.17,27.07.1,54.14.09,81.21,0,7.65-1.94,9.59-9.56,9.6q-21.4,0-42.82,0c-6.62,0-8.75-2.19-8.75-8.91,0-27.4-.1-54.8.09-82.2,0-3.8-1.06-4.51-4.62-4.49-27.08.16-54.15,0-81.22.18-4.07,0-7.23-1-9.78-4.06V102.8c2.55-3.08,5.72-4.08,9.79-4.06,27.09.17,54.18,0,81.27.18,3.68,0,4.58-.87,4.55-4.56-.17-27.09,0-54.18-.18-81.27,0-4.06,1-7.23,4.06-9.78Z"></path></svg>
                    <span class="fs11 bold">create new permission</span>
                </div>
                @else
                <div class="disabled-green-button-style green-button-style width-max-content flex align-center my4">
                    <svg class="size10 mr8" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.22,3.31c3.07,2.55,4.08,5.71,4.06,9.78-.17,27.07,0,54.14-.18,81.21,0,3.57.69,4.66,4.49,4.63,27.24-.19,54.47-.11,81.71-.1,7.36,0,9.39,2,9.4,9.25q0,21.4,0,42.82c0,7-2.1,9.06-9.09,9.06-27.24,0-54.48.09-81.71-.09-3.85,0-4.83.95-4.8,4.81.17,27.07.1,54.14.09,81.21,0,7.65-1.94,9.59-9.56,9.6q-21.4,0-42.82,0c-6.62,0-8.75-2.19-8.75-8.91,0-27.4-.1-54.8.09-82.2,0-3.8-1.06-4.51-4.62-4.49-27.08.16-54.15,0-81.22.18-4.07,0-7.23-1-9.78-4.06V102.8c2.55-3.08,5.72-4.08,9.79-4.06,27.09.17,54.18,0,81.27.18,3.68,0,4.58-.87,4.55-4.56-.17-27.09,0-54.18-.18-81.27,0-4.06,1-7.23,4.06-9.78Z"></path></svg>
                    <span class="fs11 bold">create new permission</span>
                </div>
                @endif
            </div>
            <p class="no-margin lblack fs13 mb8">The following permissions are ordered by scope. Select a permission to manage, or choose a scope to only list specific scope permissions</p>
            <div class="relative">
                <div class="flex align-center width-max-content button-with-suboptions pointer fs13 py4">
                    <span class="mr4 gray unselectable">{{ __('Select a scope') }}:</span>
                    <span id="selected-scope-name" class="forum-color bold unselectable">All</span>
                    <svg class="size7 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                </div>
                <div class="suboptions-container thread-add-suboptions-container" style="width: 260px; max-height: 300px; overflow-y: scroll;">
                    <div class="no-underline thread-add-suboption select-permissions-scope">
                        <p class="no-margin scope-name bold forum-color">All</p>
                        <p class="no-margin fs12 gray">List all permissions of all scopes</p>
                        <input type="hidden" class="scope-slug" value="all" autocomplete="off">
                    </div>
                    @foreach($scopedpermissions as $scope=>$permissions)
                    <div class="no-underline thread-add-suboption select-permissions-scope">
                        <p class="no-margin scope-name bold forum-color">{{ ucfirst($scope) }} management</p>
                        <p class="no-margin fs12 gray">List all permissions of {{ $scope }} management</p>
                        <input type="hidden" class="scope-slug" value="{{ $scope }}" autocomplete="off">
                    </div>
                    @endforeach
                </div>
            </div>
            @foreach($scopedpermissions as $scope=>$permissions)
            <div class="permissions-scope-box section-style mb8">
                <input type="hidden" class="scope" value="{{ $scope }}" autocomplete="off">
                <h3 class="no-margin mb8 blue bold fs16">{{ ucfirst($scope) }}</h3>
                @foreach($permissions as $permission)
                <div class="section-style full-width mt8">
                    <div class="flex">
                        <div class="flex">
                            <span class="fs12 bold gray mr4">Permission :</span>
                            <div style="margin-top: -2px;">
                                <span class="block bold lblack fs14">{{ $permission->permission }}</span>
                                <span class="block gray fs12">{{ $permission->slug }}</span>
                            </div>
                        </div>
                        <a href="?permissionid={{ $permission->id }}" class="button-style-4 ml8" style="padding: 4px 12px; height: max-content; margin-top: -4px">
                            <svg class="mr4 size10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M254.7,64.53c-1.76.88-1.41,2.76-1.8,4.19a50.69,50.69,0,0,1-62,35.8c-3.39-.9-5.59-.54-7.89,2.2-2.8,3.34-6.16,6.19-9.17,9.36-1.52,1.6-2.5,2.34-4.5.28-8.79-9-17.75-17.94-26.75-26.79-1.61-1.59-1.87-2.49-.07-4.16,4-3.74,8.77-7.18,11.45-11.78,2.79-4.79-1.22-10.29-1.41-15.62C151.74,33.52,167,12.55,190.72,5.92c1.25-.35,3,0,3.71-1.69H211c.23,1.11,1.13.87,1.89,1,3.79.48,7.43,1.2,8.93,5.45s-1.06,7-3.79,9.69c-6.34,6.26-12.56,12.65-19,18.86-1.77,1.72-2,2.75,0,4.57,5.52,5.25,10.94,10.61,16.15,16.16,2.1,2.24,3.18,1.5,4.92-.28q9.83-10.1,19.9-20c5.46-5.32,11.43-3.47,13.47,3.91.4,1.47-.4,3.32,1.27,4.41Zm0,179-25.45-43.8-28.1,28.13c13.34,7.65,26.9,15.46,40.49,23.21,6.14,3.51,8.73,2.94,13.06-2.67ZM28.2,4.23C20.7,9.09,15,15.89,8.93,22.27,4.42,27,4.73,33.56,9.28,38.48c4.18,4.51,8.7,8.69,13,13.13,1.46,1.53,2.4,1.52,3.88,0Q39.58,38,53.19,24.49c1.12-1.12,2-2,.34-3.51C47.35,15.41,42.43,8.44,35,4.23ZM217.42,185.05Q152.85,120.42,88.29,55.76c-1.7-1.7-2.63-2-4.49-.11-8.7,8.93-17.55,17.72-26.43,26.48-1.63,1.61-2.15,2.52-.19,4.48Q122,151.31,186.71,216.18c1.68,1.68,2.61,2,4.46.1,8.82-9.05,17.81-17.92,26.74-26.86.57-.58,1.12-1.17,1.78-1.88C218.92,186.68,218.21,185.83,217.42,185.05ZM6.94,212.72c.63,3.43,1.75,6.58,5.69,7.69,3.68,1,6.16-.77,8.54-3.18,6.27-6.32,12.76-12.45,18.81-19,2.61-2.82,4-2.38,6.35.16,4.72,5.11,9.65,10.06,14.76,14.77,2.45,2.26,2.1,3.51-.11,5.64C54.2,225.32,47.57,232,41,238.73c-4.92,5.08-3.25,11.1,3.57,12.9a45,45,0,0,0,9.56,1.48c35.08,1.51,60.76-30.41,51.76-64.43-.79-3-.29-4.69,1.89-6.65,3.49-3.13,6.62-6.66,10-9.88,1.57-1.48,2-2.38.19-4.17q-13.72-13.42-27.14-27.14c-1.56-1.59-2.42-1.38-3.81.11-3.11,3.3-6.56,6.28-9.53,9.7-2.28,2.61-4.37,3.25-7.87,2.31C37.45,144.33,5.87,168.73,5.85,202.7,5.6,205.71,6.3,209.22,6.94,212.72ZM47.57,71.28c6.77-6.71,13.5-13.47,20.24-20.21,8.32-8.33,8.25-8.25-.35-16.25-1.82-1.69-2.69-1.42-4.24.14-8.85,9-17.8,17.85-26.69,26.79-.64.65-1.64,2.06-1.48,2.24,3,3.38,6.07,6.63,8.87,9.62C46.08,73.44,46.7,72.14,47.57,71.28Z"></path></svg>    
                            <span class="fs11 lblack">manage</span>
                        </a>
                    </div>
                    <p class="fs13 no-margin mt8"><span class="fs12 bold gray mr4">Description :</span> {{ $permission->description }}</p>
                </div>
                @endforeach
            </div>
            @endforeach
        @else
            <input type="hidden" id="permission-id" value="{{ $permission->id }}" autocomplete="off">
            <style>
                .permission-section {
                    background-color: #f9f9f9;
                    padding: 12px;
                    border: 1px solid #d9d9d9;
                    border-radius: 6px;
                    box-sizing: border-box;
                }

                .rounded-entity-for-permission {
                    width: 50px;
                    height: 50px;
                    border-radius: 50%;
                    border: 4px solid #52affb;
                }

                #permission-members-search-result-box {
                    padding: 12px 10px 10px 10px;
                    background-color: #f9f9f9;
                    border: 1px solid #bdbdbd;
                    border-bottom: unset;
                    border-radius: 4px 4px 0 0;
                    position: absolute;
                    bottom: calc(100% + 34px);
                }

                .permission-member-search-user, .selected-permission-member-to-get-permission {
                    padding: 8px;
                    background-color: #ecf0f0;
                    border: 1px solid #c3ced0;
                    border-radius: 3px;
                }
            </style>
            
            <!-- grant permission to user(s) viewer -->
            @if($can_grant_permission_to_users)
            <div id="grant-permission-to-users-viewer" class="global-viewer full-center none">
                <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
                <div class="viewer-box-style-1" style="width: 600px;">
                    <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                        <div class="flex align-center">
                            <svg class="size16 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.69,169.38a27,27,0,0,1-5.88,5.8q-34.91,27.48-69.75,55.06a14.94,14.94,0,0,1-9.89,3.47c-35.2-.18-69.89-4.6-104.24-12.07-2.74-.6-3.6-1.72-3.59-4.61q.21-38.29,0-76.58c0-2.65.72-4.14,3.09-5.4,11.29-6,23-7.36,34.58-1.79,14.76,7.07,30,11.26,46.44,11.65,13.83.32,25.22,12,27.06,25.75.44,3.24-.64,3.76-3.6,3.73-17.78-.13-35.57-.07-53.36-.06-6.18,0-9.58,2.68-9.56,7.43s3.41,7.38,9.61,7.38c16.8,0,33.6-.15,50.39.07a41,41,0,0,0,28.06-10.14c6.9-5.86,13.95-11.55,21.05-17.16s15-8.07,24-6.61c6.41,1,11.74,3.82,15.61,9.14ZM94.61,40.87c-6.3.1-8.86,2.69-8.93,9.09,0,3.13-.2,6.27,0,9.38.22,2.92-.49,4.19-3.7,3.89a88,88,0,0,0-9.88,0C66,63.31,63.6,65.73,63.44,72c-.09,3.29,0,6.59,0,9.88,0,9,2,11,11.15,11,19.94,0,39.87.1,59.8-.07,3.9,0,5.94.79,7.55,4.82,9.06,22.68,31.87,35.3,56,31.43,23-3.68,41.3-23.08,43.06-45.69,2-25.31-12.1-47-35.48-54.7-22.74-7.47-47.27,1.72-60.1,22.15-2.54,4-2.47,10.5-7.18,12s-10.11.34-15.21.34c-7.69,0-7.69,0-7.69-7.68,0-14-.62-14.61-14.79-14.61C98.57,40.87,96.59,40.84,94.61,40.87Zm72.66,37a22.2,22.2,0,1,1,22.27,22.29A22.18,22.18,0,0,1,167.27,77.88ZM48.69,149c.05-3.29-.57-4.55-4.22-4.46-10.52.26-21,.07-31.58.1-6.68,0-9.25,2.58-9.26,9.24q0,35.28,0,70.58c0,6.59,2.63,9.12,9.36,9.14q12.82.06,25.66,0c7.55,0,9.93-2.39,10-10.08,0-12.34,0-24.68,0-37C48.62,174,48.51,161.53,48.69,149ZM182.17,78.39a7.31,7.31,0,1,0,7.08-7.84A7.33,7.33,0,0,0,182.17,78.39Z"/></svg>
                            <span class="fs20 bold forum-color">Grant permission to user(s)</span>
                        </div>
                        <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                    </div>
                    <div class="viewer-scrollable-box scrolly" style="padding: 14px; max-height: 430px">
                        <input type="hidden" id="at-least-one-user-to-attach-permission-message" value="You need to select at least one member to attach permission into" autocomplete="off">
                        <div class="section-style fs13 lblack mb8">
                            <span class="block fs16 bold forum-color mb8">Grant "<span class="blue">{{ $permission->permission }}</span>" permission to user(s)</span>
                            <p class="no-margin">Here you can create grant "{{ $permission->permission }}" permission to members. Before proceding this process, consider the following points</p>
                            <div class="ml8 mt8">
                                <div class="flex mt4">
                                    <div class="fs10 mr8 mt4 gray">•</div>
                                    <p class="no-margin" style="line-height: 1.5">Once the selected member(s) get the permission, he will be able to perform the attached activity allowed by this permission.</p>
                                </div>
                            </div>
                        </div>
                        <div class="simple-line-separator my4"></div>
                        <div style="margin-top: 14px">
                            <div>
                                <span class="block fs12 lblack bold">Permission to be granted :</span>
                                <h3 class="no-margin forum-color fs20">{{ $permission->permission }} permission</h3>
                            </div>
                        </div>
                        <div style="margin-top: 14px">
                            <div>
                                <span class="block fs12 lblack bold">Description :</span>
                                <p class="no-margin mt4 fs13 lblack">{{ $permission->description }}</p>
                            </div>
                        </div>
                        <div class="relative" style="margin-top: 12px">
                            <span class="block mb4 fs12 lblack bold">Select member that you want to grant the permission to :</span>
                            <div class="relative">
                                <div class="relative">
                                    <svg class="absolute size14" fill="#5b5b5b" style="top: 10px; left: 12px;" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"></path></svg>
                                    <input type="text" class="search-input-style full-width border-box" id="permission-member-search-input" autocomplete="off" placeholder="find member by username">
                                    <div class="button-style-4 full-center absolute" id="permission-search-for-member-to-grant" style="right: 0; top: 0; height: 18px;">
                                        <svg class="size14 mr4" fill="#5b5b5b" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"></path></svg>
                                        <span class="bold forum-color">search</span>
                                    </div>
                                </div>
                            </div>
                            <div class="relative">
                                <div id="permission-members-search-result-box" class="full-width scrolly none" style="max-height: 273px;">
                                    <input type="hidden" id="pum-k" autocomplete="off">
                                    <div class="results-container none">
                                        results
                                    </div>
                                    <div class="permission-member-search-user permission-member-search-user-factory mb4 flex none">
                                        <input type="hidden" class="pum-uid" autocomplete="off">
                                        <a href="" class="pum-profilelink" style="height: 54px">
                                            <img src="" class="size48 rounded mr8 pum-avatar" alt="" style="border: 3px solid #9f9f9f;">
                                        </a>
                                        <div>
                                            <span class="block bold pum-fullname">Mouad Nassri</span>
                                            <span class="block bold fs13 lblack pum-username">codename49</span>
                                            <span class="block bold fs12 blue pum-role">Site owner</span>
                                        </div>
                                        <div class="button-style-4 flex align-center ml8 height-max-content permission-select-member none" style="padding: 6px 10px">
                                            <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M197.63,2.4C199,4.24,201.19,3.45,203,4.08a32,32,0,0,1,21.4,28.77c.14,4,.18,7.93,0,11.88-.26,6.3-4.8,10.58-10.82,10.44-5.84-.13-9.9-4.25-10.17-10.51-.14-3.3.08-6.61-.09-9.91C202.94,27.81,199,23.86,192,23.52c-3-.14-5.94,0-8.91,0-6-.14-10.05-3-11.2-7.82-1.23-5.13.68-9.09,5.92-12.31a5.8,5.8,0,0,0,1-1ZM38.88,2.4c-.22.78-.87.78-1.52.94C24.43,6.58,16.51,14.91,13.46,27.71c-1.34,5.64-.74,11.53-.53,17.3a10.08,10.08,0,0,0,10.5,10.18c5.78,0,10.14-4.29,10.45-10.36.16-3.13,0-6.28,0-9.42C34.05,27.9,38,23.79,45.5,23.51c3.46-.13,6.94.06,10.4-.14,4.87-.28,7.94-3.08,9.31-7.6s-.25-8-3.59-11.09C60.7,3.83,59.05,4,58.73,2.4Zm55.56,0c-.16,1.13-1.22.84-1.87,1.21-4.47,2.56-6.49,7-5.37,11.67,1.16,4.89,4.64,8,9.88,8.1q21.56.23,43.13,0a9.75,9.75,0,0,0,9.7-7.7c1-4.8-.35-8.79-4.57-11.64-.77-.52-2-.44-2.28-1.63ZM142.29,247c0,3.87.55,7.36,4.66,9,4,1.53,6.55-.77,9.05-3.38,12.14-12.64,24.36-25.2,36.43-37.91a9.54,9.54,0,0,1,7.68-3.37c15.71.18,31.42.06,47.12.09,4,0,7.28-1,8.54-5.19,1.14-3.81-1.26-6.2-3.65-8.58q-47.88-47.85-95.75-95.74c-2.63-2.64-5.24-5.33-9.43-3.7-4.36,1.7-4.66,5.47-4.65,9.46q.06,34.47,0,68.94Q142.31,211.74,142.29,247Zm-87-33c6.06-.34,10.36-4.74,10.35-10.45a10.59,10.59,0,0,0-10.37-10.52c-3.46-.18-6.94,0-10.41-.07-6.56-.23-10.71-4.41-10.92-11-.12-3.64.14-7.29-.12-10.91a10.52,10.52,0,0,0-10-9.8c-5.11-.22-10.18,3.43-10.65,8.43-.61,6.57-1,13.26.49,19.75,3.7,15.82,16.07,24.61,34.23,24.59C50.34,213.94,52.82,214.05,55.3,213.91ZM12.86,128.57C13,135.3,17.31,140,23.27,140s10.57-4.64,10.62-11.27q.15-20.53,0-41.08c0-6.68-4.52-11.11-10.71-11-6,.07-10.17,4.3-10.3,10.87-.15,6.93,0,13.86,0,20.79C12.84,115,12.75,121.81,12.86,128.57ZM203.39,97.73c0,3.63-.16,7.28,0,10.9.32,5.93,4.46,9.91,10.13,10s10.47-3.78,10.72-9.47c.34-7.75.36-15.54,0-23.29-.27-5.64-5.21-9.48-10.87-9.28a10,10,0,0,0-9.93,9.7c-.23,3.78,0,7.6,0,11.4Zm-84,116.12a10.44,10.44,0,0,0,0-20.84c-7.56-.3-15.15-.29-22.71,0a10.44,10.44,0,0,0,0,20.84c3.77.23,7.57,0,11.35.05S115.57,214.09,119.34,213.85Z"></path></svg>
                                            <span class="fs11 bold">select user</span>
                                        </div>
                                        <div class="flex align-center ml8 height-max-content already-has-permission none" style="padding: 2px">
                                            <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"></path></svg>
                                            <span class="fs12 bold green">Already has this permission</span>
                                        </div>
                                    </div>
                                    <div id="permission-users-fetch-more-results" class="full-center none" style='height: 32px;'>
                                        <svg class="spinner size20 blue" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                    <!-- loading -->
                                    <div class="search-loading full-center none" style="height: 42px">
                                        <svg class="spinner size28 absolute black" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                    <!-- no results found -->
                                    <div class="no-results-found-box full-center none">
                                        <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                        <p class="fs13 gray no-margin bold">User not found with this username</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 12px">
                            <span class="block mb4 fs12 lblack bold">Selected members</span>
                            <div id="empty-permission-members-selected-box" class="flex align-center section-style">
                                <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                <p class="fs13 gray no-margin">Select at least one member that you want to attach this permission to</p>
                            </div>
                            <div id="permission-members-selected-box" class="flex flex-wrap scrolly none" style="max-height: 160px"> <!-- psu: permission selected user -->
                                
                            </div>
                            <div class="selected-permission-member-to-get-permission selected-permission-member-to-get-permission-factory mb4 mr4 full-center flex-column relative none">
                                <input type="hidden" class="psu-id" autocomplete="off">
                                <a href="" class="psu-profilelink" style="height: 54px">
                                    <img src="{{ auth()->user()->sizedavatar(100, '-h') }}" class="size48 rounded mr8 psu-avatar" alt="" style="border: 3px solid #9f9f9f;">
                                </a>
                                <span class="block bold psu-fullname mt4">Mouad Nassri</span>
                                <span class="block bold fs13 lblack psu-username">codename49</span>
                                <span class="block bold fs12 blue psu-role">Site owner</span>

                                <!-- remove member from selected users -->
                                <div class="remove-psu-from-selection x-close-container-style">
                                    <span class="x-close unselectable">✖</span>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 12px">
                            <p class="no-margin mb2 bold forum-color">Confirmation</p>
                            <p class="no-margin mb4 bblack">Please type <strong>{{ auth()->user()->username }}::grant-permission::{{ $permission->slug }}</strong> to confirm.</p>
                            <div>
                                <input type="text" autocomplete="off" class="full-width input-style-1" id="grant-permission-to-users-confirm-input" style="padding: 8px 10px" placeholder="permission grant confirmation">
                                <input type="hidden" id="grant-permission-to-users-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}::grant-permission::{{ $permission->slug }}">
                            </div>
                            <div class="flex" style="margin-top: 12px">
                                <div class="flex align-center full-width">
                                    <div id="grant-permission-to-users-button" class="disabled-green-button-style green-button-style full-center full-width">
                                        <div class="relative size14 mr4">
                                            <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.69,169.38a27,27,0,0,1-5.88,5.8q-34.91,27.48-69.75,55.06a14.94,14.94,0,0,1-9.89,3.47c-35.2-.18-69.89-4.6-104.24-12.07-2.74-.6-3.6-1.72-3.59-4.61q.21-38.29,0-76.58c0-2.65.72-4.14,3.09-5.4,11.29-6,23-7.36,34.58-1.79,14.76,7.07,30,11.26,46.44,11.65,13.83.32,25.22,12,27.06,25.75.44,3.24-.64,3.76-3.6,3.73-17.78-.13-35.57-.07-53.36-.06-6.18,0-9.58,2.68-9.56,7.43s3.41,7.38,9.61,7.38c16.8,0,33.6-.15,50.39.07a41,41,0,0,0,28.06-10.14c6.9-5.86,13.95-11.55,21.05-17.16s15-8.07,24-6.61c6.41,1,11.74,3.82,15.61,9.14ZM94.61,40.87c-6.3.1-8.86,2.69-8.93,9.09,0,3.13-.2,6.27,0,9.38.22,2.92-.49,4.19-3.7,3.89a88,88,0,0,0-9.88,0C66,63.31,63.6,65.73,63.44,72c-.09,3.29,0,6.59,0,9.88,0,9,2,11,11.15,11,19.94,0,39.87.1,59.8-.07,3.9,0,5.94.79,7.55,4.82,9.06,22.68,31.87,35.3,56,31.43,23-3.68,41.3-23.08,43.06-45.69,2-25.31-12.1-47-35.48-54.7-22.74-7.47-47.27,1.72-60.1,22.15-2.54,4-2.47,10.5-7.18,12s-10.11.34-15.21.34c-7.69,0-7.69,0-7.69-7.68,0-14-.62-14.61-14.79-14.61C98.57,40.87,96.59,40.84,94.61,40.87Zm72.66,37a22.2,22.2,0,1,1,22.27,22.29A22.18,22.18,0,0,1,167.27,77.88ZM48.69,149c.05-3.29-.57-4.55-4.22-4.46-10.52.26-21,.07-31.58.1-6.68,0-9.25,2.58-9.26,9.24q0,35.28,0,70.58c0,6.59,2.63,9.12,9.36,9.14q12.82.06,25.66,0c7.55,0,9.93-2.39,10-10.08,0-12.34,0-24.68,0-37C48.62,174,48.51,161.53,48.69,149ZM182.17,78.39a7.31,7.31,0,1,0,7.08-7.84A7.33,7.33,0,0,0,182.17,78.39Z"></path></svg>
                                            <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                            </svg>
                                        </div>
                                        <span class="bold">Grant permission to selected user(s)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!-- detach permission from user(s) -->
            @if($can_revoke_permission_from_users)
            <div id="detach-permission-from-users-viewer" class="global-viewer full-center none">
                <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
                <div class="viewer-box-style-1" style="width: 600px;">
                    <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                        <div class="flex align-center">
                            <svg class="size16 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M167.69,256.92c-4.4-51.22,37.26-92.87,89-89,0,28.5-.05,57,.09,85.51,0,3-.6,3.55-3.55,3.54C224.71,256.86,196.2,256.92,167.69,256.92ZM19.86,3.86c-16.27,0-16.31.05-16.31,16.07q0,94.91,0,189.79c0,7.15,2.26,9.84,8.61,9.85,38.23.05,76.47,0,114.7.08,2.56,0,3.43-.63,3.3-3.27a77.64,77.64,0,0,1,1.45-19.65c8.29-39.74,41.06-66.4,81.87-66.2,5.11,0,6-1.32,6-6.12-.22-36.58-.11-73.15-.12-109.73,0-8.73-2.06-10.81-10.65-10.81H19.86Zm49.8,76.56c-4.07-4.07-4-4.72.84-9.54s5.56-5,9.55-1C90.24,80,100.39,90.26,111.43,101.34c0-5.58,0-10,0-14.31,0-3.5,1.63-5.17,5.14-5,1.64,0,3.29,0,4.94,0,3.26-.07,4.84,1.45,4.82,4.76,0,10.7.07,21.4-.06,32.1-.05,5-2.7,7.64-7.66,7.71-10.7.15-21.41,0-32.11.07-3.27,0-4.87-1.54-4.8-4.82,0-1.48.07-3,0-4.44-.24-3.94,1.48-5.8,5.52-5.66,4.21.14,8.44,0,13.87,0C89.94,100.65,79.78,90.55,69.66,80.42Z"/></svg>
                            <span class="fs20 bold forum-color">Detach permission from users</span>
                        </div>
                        <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                    </div>
                    <div class="viewer-scrollable-box scrolly" style="padding: 14px; max-height: 430px">
                        <input type="hidden" id="at-least-one-selected-user-to-detach-permission-from-message" value="You need to select at least one user to detach the permission from" autocomplete="off">
                        <div class="section-style fs13 lblack mb8">
                            <span class="fs15 bold forum-color">Detach "<span class="blue">{{ $permission->permission }}</span>" permission from user(s)</span>
                            <p class="no-margin mt8">Here you can detach "{{ $permission->permission }}" permission from members who already have this permission. Before proceding this process, consider the following points</p>
                            <div class="ml8 mt8">
                                <div class="flex mt4">
                                    <div class="fs10 mr8 mt4 gray">•</div>
                                    <p class="no-margin" style="line-height: 1.5">Once the current permission is detached from the selected member(s), they will <strong>not be able to perform the activity</strong> associated to this permission anymore.</p>
                                </div>
                            </div>
                        </div>
                        <div class="simple-line-separator my4"></div>
                        <div style="margin-top: 14px">
                            <div>
                                <span class="block fs12 forum-color bold">Permission :</span>
                                <h3 class="no-margin forum-color fs20">{{ $permission->permission }} permission</h3>
                            </div>
                        </div>

                        <div style="margin-top: 14px">
                            <span class="block fs12 forum-color bold">Select members to detach permission from :</span>
                            <span class="block fs12 gray my4 lh15">The following list is for members who are already have this permission. Choose only members that you want to detach permission from.</span>
                            <div class="section-style flex flex-wrap y-auto-overflow" style="max-height: 180px">
                                @foreach($users as $user)
                                <div class="flex align-center flex-column mx8 my8">
                                    <div class="relative custom-checkbox-button user-to-detach-permission-from-select pointer">
                                        <img src="{{ $user->sizedavatar(100, '-h') }}" class="rounded-entity-for-permission" alt="">
                                        <div class="mr4 absolute" style="top: -10px; right: -14px;">
                                            <div class="custom-checkbox size14" style="border-radius: 2px">
                                                <svg class="size10 custom-checkbox-tick none" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M173.9,439.4,7.5,273a25.59,25.59,0,0,1,0-36.2l36.2-36.2a25.59,25.59,0,0,1,36.2,0L192,312.69,432.1,72.6a25.59,25.59,0,0,1,36.2,0l36.2,36.2a25.59,25.59,0,0,1,0,36.2L210.1,439.4a25.59,25.59,0,0,1-36.2,0Z"/></svg>
                                                <input type="hidden" class="checkbox-status" autocomplete="off" value="0">
                                                <input type="hidden" class="uid" value="{{ $user->id }}" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <span class="bold blue fs11 mt4">{{ $user->username }}</span>
                                    @if($hr = $user->high_role())
                                    <span class="bold lblack fs10">{{ $hr->role }}</span>
                                    @else
                                    <em class="gray fs10">Normal user</em>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div style="margin-top: 12px">
                            <p class="no-margin mb2 bold forum-color">Confirmation</p>
                            <p class="no-margin mb4 bblack">Please type <strong>{{ auth()->user()->username }}::detach-permission::{{ $permission->slug }}</strong> to confirm.</p>
                            <div>
                                <input type="text" autocomplete="off" class="full-width input-style-1" id="detach-permission-from-users-confirm-input" style="padding: 8px 10px" placeholder="confirm detach">
                                <input type="hidden" id="detach-permission-from-users-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}::detach-permission::{{ $permission->slug }}">
                            </div>
                            <div class="flex align-center" style="margin-top: 12px">
                                <div id="detach-permission-from-users-button" class="disabled-red-button-style red-button-style full-center">
                                    <div class="relative size14 mr4">
                                        <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M167.69,256.92c-4.4-51.22,37.26-92.87,89-89,0,28.5-.05,57,.09,85.51,0,3-.6,3.55-3.55,3.54C224.71,256.86,196.2,256.92,167.69,256.92ZM19.86,3.86c-16.27,0-16.31.05-16.31,16.07q0,94.91,0,189.79c0,7.15,2.26,9.84,8.61,9.85,38.23.05,76.47,0,114.7.08,2.56,0,3.43-.63,3.3-3.27a77.64,77.64,0,0,1,1.45-19.65c8.29-39.74,41.06-66.4,81.87-66.2,5.11,0,6-1.32,6-6.12-.22-36.58-.11-73.15-.12-109.73,0-8.73-2.06-10.81-10.65-10.81H19.86Zm49.8,76.56c-4.07-4.07-4-4.72.84-9.54s5.56-5,9.55-1C90.24,80,100.39,90.26,111.43,101.34c0-5.58,0-10,0-14.31,0-3.5,1.63-5.17,5.14-5,1.64,0,3.29,0,4.94,0,3.26-.07,4.84,1.45,4.82,4.76,0,10.7.07,21.4-.06,32.1-.05,5-2.7,7.64-7.66,7.71-10.7.15-21.41,0-32.11.07-3.27,0-4.87-1.54-4.8-4.82,0-1.48.07-3,0-4.44-.24-3.94,1.48-5.8,5.52-5.66,4.21.14,8.44,0,13.87,0C89.94,100.65,79.78,90.55,69.66,80.42Z"/></svg>
                                        <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                    <span class="bold">Detach permission from users</span>
                                </div>
                                <span class="bold no-underline forum-color pointer close-global-viewer ml8">cancel</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!-- delete permission viewer -->
            @if($candelete)
            <div id="delete-permission-viewer" class="global-viewer full-center none">
                <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
                <div class="viewer-box-style-1" style="width: 600px;">
                    <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                        <div class="flex align-center">
                            <svg class="size16 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                            <span class="fs20 bold forum-color">Delete permission</span>
                        </div>
                        <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                    </div>
                    <div class="viewer-scrollable-box scrolly" style="padding: 14px; max-height: 430px">
                        <div class="section-style fs13 lblack mb8">
                            <span class="block fs18 bold lblack mb8">Delete "<span class="blue">{{ $permission->permission }}</span>" permission</span>
                            <p class="no-margin">Here you can delete "{{ $permission->permission }}" permission thoroughly. Before proceding this process, consider the following points</p>
                            <div class="ml8 mt8">
                                <div class="flex mt4">
                                    <div class="fs10 mr8 mt4 gray">•</div>
                                    <p class="no-margin" style="line-height: 1.5">Once the permission gets deleted, <strong>all its associations with roles and users gets deleted as well</strong>.</p>
                                </div>
                                <div class="flex mt4">
                                    <div class="fs10 mr8 mt4 gray">•</div>
                                    <p class="no-margin" style="line-height: 1.5">Please note that the activity related to this permission will be blocked and no one can perform it, except site owners. So be careful, and only delete permission If you are 100% sure about it.</p>
                                </div>
                            </div>
                        </div>
                        <div class="simple-line-separator my4"></div>
                        <div style="margin-top: 14px">
                            <div>
                                <span class="block fs12 gray bold">Permission to be <span class="red">deleted</span> :</span>
                                <h3 class="no-margin forum-color fs20">{{ $permission->permission }} permission</h3>
                            </div>
                        </div>
                        <div style="margin-top: 14px">
                            <div>
                                <span class="block fs12 gray bold mb4">Roles where this permission attached to :</span>
                                <div class="flex flex-wrap section-style y-auto-overflow" style="padding: 8px; max-height: 200px;">
                                    @foreach($roles as $role)
                                        <div class="button-style-4 mx4 my4 fs11 bold">{{ $role->role }}</div>
                                    @endforeach
                                    @if(!$roles->count())
                                    <div class="flex align-center">
                                        <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                        <p class="no-margin fs12 italic gray">This permission is not currently attached to any role</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 14px">
                            <span class="block fs12 gray bold mb4">Members already have this permission :</span>
                            <div class="flex flex-wrap section-style border-box" style="padding: 10px; max-height: 250px; overflow-y: auto;">
                                @foreach($users as $user)
                                <div class="flex align-center flex-column mx8 my8">
                                    <img src="{{ $user->sizedavatar(100, '-h') }}" class="rounded-entity-for-permission" alt="">
                                    <span class="bold lblack mt4">{{ $user->fullname }}</span>
                                    <span class="bold blue fs11">{{ $user->username }}</span>
                                    @if($hr = $user->high_role())
                                    <span class="bold lblack fs10">{{ $hr->role }}</span>
                                    @else
                                    <em class="fs10 gray">Normal user</em>
                                    @endif
                                </div>
                                @endforeach
                                @if(!$users->count())
                                <div class="flex align-center">
                                    <svg class="size12 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                    <p class="fs12 italic no-margin gray">This permission is not acquired by any user for the moment</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div style="margin-top: 12px">
                            <p class="no-margin mb2 bold forum-color">Confirmation</p>
                            <p class="no-margin mb4 bblack">Please type <strong>{{ auth()->user()->username }}::delete-permission::{{ $permission->slug }}</strong> to confirm.</p>
                            <div>
                                <input type="text" autocomplete="off" class="full-width input-style-1" id="delete-permission-confirm-input" style="padding: 8px 10px" placeholder="role delete confirmation">
                                <input type="hidden" id="delete-permission-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}::delete-permission::{{ $permission->slug }}">
                            </div>
                            <div class="flex" style="margin-top: 12px">
                                <div class="flex align-center">
                                    <div id="delete-permission-button" class="disabled-red-button-style red-button-style flex align-center">
                                        <div class="relative size14 mr4">
                                            <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                                            <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                            </svg>
                                        </div>
                                        <span class="bold">Delete permission</span>
                                    </div>
                                    <span class="bold no-underline forum-color pointer close-global-viewer ml8">cancel</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="flex align-end space-between mb8">
                <div class="flex align-center">
                    <svg class="mr8 size18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M254.7,64.53c-1.76.88-1.41,2.76-1.8,4.19a50.69,50.69,0,0,1-62,35.8c-3.39-.9-5.59-.54-7.89,2.2-2.8,3.34-6.16,6.19-9.17,9.36-1.52,1.6-2.5,2.34-4.5.28-8.79-9-17.75-17.94-26.75-26.79-1.61-1.59-1.87-2.49-.07-4.16,4-3.74,8.77-7.18,11.45-11.78,2.79-4.79-1.22-10.29-1.41-15.62C151.74,33.52,167,12.55,190.72,5.92c1.25-.35,3,0,3.71-1.69H211c.23,1.11,1.13.87,1.89,1,3.79.48,7.43,1.2,8.93,5.45s-1.06,7-3.79,9.69c-6.34,6.26-12.56,12.65-19,18.86-1.77,1.72-2,2.75,0,4.57,5.52,5.25,10.94,10.61,16.15,16.16,2.1,2.24,3.18,1.5,4.92-.28q9.83-10.1,19.9-20c5.46-5.32,11.43-3.47,13.47,3.91.4,1.47-.4,3.32,1.27,4.41Zm0,179-25.45-43.8-28.1,28.13c13.34,7.65,26.9,15.46,40.49,23.21,6.14,3.51,8.73,2.94,13.06-2.67ZM28.2,4.23C20.7,9.09,15,15.89,8.93,22.27,4.42,27,4.73,33.56,9.28,38.48c4.18,4.51,8.7,8.69,13,13.13,1.46,1.53,2.4,1.52,3.88,0Q39.58,38,53.19,24.49c1.12-1.12,2-2,.34-3.51C47.35,15.41,42.43,8.44,35,4.23ZM217.42,185.05Q152.85,120.42,88.29,55.76c-1.7-1.7-2.63-2-4.49-.11-8.7,8.93-17.55,17.72-26.43,26.48-1.63,1.61-2.15,2.52-.19,4.48Q122,151.31,186.71,216.18c1.68,1.68,2.61,2,4.46.1,8.82-9.05,17.81-17.92,26.74-26.86.57-.58,1.12-1.17,1.78-1.88C218.92,186.68,218.21,185.83,217.42,185.05ZM6.94,212.72c.63,3.43,1.75,6.58,5.69,7.69,3.68,1,6.16-.77,8.54-3.18,6.27-6.32,12.76-12.45,18.81-19,2.61-2.82,4-2.38,6.35.16,4.72,5.11,9.65,10.06,14.76,14.77,2.45,2.26,2.1,3.51-.11,5.64C54.2,225.32,47.57,232,41,238.73c-4.92,5.08-3.25,11.1,3.57,12.9a45,45,0,0,0,9.56,1.48c35.08,1.51,60.76-30.41,51.76-64.43-.79-3-.29-4.69,1.89-6.65,3.49-3.13,6.62-6.66,10-9.88,1.57-1.48,2-2.38.19-4.17q-13.72-13.42-27.14-27.14c-1.56-1.59-2.42-1.38-3.81.11-3.11,3.3-6.56,6.28-9.53,9.7-2.28,2.61-4.37,3.25-7.87,2.31C37.45,144.33,5.87,168.73,5.85,202.7,5.6,205.71,6.3,209.22,6.94,212.72ZM47.57,71.28c6.77-6.71,13.5-13.47,20.24-20.21,8.32-8.33,8.25-8.25-.35-16.25-1.82-1.69-2.69-1.42-4.24.14-8.85,9-17.8,17.85-26.69,26.79-.64.65-1.64,2.06-1.48,2.24,3,3.38,6.07,6.63,8.87,9.62C46.08,73.44,46.7,72.14,47.57,71.28Z"/></svg>
                    <h2 class="no-margin fs20 mb2 lblack">Manage "<span class="blue">{{ $permission->permission }}</span>" permission</h2>
                </div>
                @if($cancreate)
                <div class="green-button-style width-max-content flex align-center my4 open-create-permission-dialog">
                    <svg class="size10 mr8" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.22,3.31c3.07,2.55,4.08,5.71,4.06,9.78-.17,27.07,0,54.14-.18,81.21,0,3.57.69,4.66,4.49,4.63,27.24-.19,54.47-.11,81.71-.1,7.36,0,9.39,2,9.4,9.25q0,21.4,0,42.82c0,7-2.1,9.06-9.09,9.06-27.24,0-54.48.09-81.71-.09-3.85,0-4.83.95-4.8,4.81.17,27.07.1,54.14.09,81.21,0,7.65-1.94,9.59-9.56,9.6q-21.4,0-42.82,0c-6.62,0-8.75-2.19-8.75-8.91,0-27.4-.1-54.8.09-82.2,0-3.8-1.06-4.51-4.62-4.49-27.08.16-54.15,0-81.22.18-4.07,0-7.23-1-9.78-4.06V102.8c2.55-3.08,5.72-4.08,9.79-4.06,27.09.17,54.18,0,81.27.18,3.68,0,4.58-.87,4.55-4.56-.17-27.09,0-54.18-.18-81.27,0-4.06,1-7.23,4.06-9.78Z"></path></svg>
                    <span class="fs11 bold">create new permission</span>
                </div>
                @else
                <div class="disabled-green-button-style green-button-style width-max-content flex align-center my4">
                    <svg class="size10 mr8" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.22,3.31c3.07,2.55,4.08,5.71,4.06,9.78-.17,27.07,0,54.14-.18,81.21,0,3.57.69,4.66,4.49,4.63,27.24-.19,54.47-.11,81.71-.1,7.36,0,9.39,2,9.4,9.25q0,21.4,0,42.82c0,7-2.1,9.06-9.09,9.06-27.24,0-54.48.09-81.71-.09-3.85,0-4.83.95-4.8,4.81.17,27.07.1,54.14.09,81.21,0,7.65-1.94,9.59-9.56,9.6q-21.4,0-42.82,0c-6.62,0-8.75-2.19-8.75-8.91,0-27.4-.1-54.8.09-82.2,0-3.8-1.06-4.51-4.62-4.49-27.08.16-54.15,0-81.22.18-4.07,0-7.23-1-9.78-4.06V102.8c2.55-3.08,5.72-4.08,9.79-4.06,27.09.17,54.18,0,81.27.18,3.68,0,4.58-.87,4.55-4.56-.17-27.09,0-54.18-.18-81.27,0-4.06,1-7.23,4.06-9.78Z"></path></svg>
                    <span class="fs11 bold">create new permission</span>
                </div>
                @endif
            </div>
            @if(Session::has('message'))
                <div class="green-message-container my8">
                    <p class="green-message">{!! Session::get('message') !!}</p>
                </div>
            @endif
            <div class="flex">
                <div class="permission-section half-width mr8">
                    <!-- update/edit permission informations -->
                    <div class="flex align-center mb8">
                        <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448,0H64A64.08,64.08,0,0,0,0,64V448a64.08,64.08,0,0,0,64,64H448a64.07,64.07,0,0,0,64-64V64A64.08,64.08,0,0,0,448,0Zm21.33,448A21.35,21.35,0,0,1,448,469.33H64A21.34,21.34,0,0,1,42.67,448V64A21.36,21.36,0,0,1,64,42.67H448A21.36,21.36,0,0,1,469.33,64ZM147.63,119.89a22.19,22.19,0,0,0-4.48-7c-1.07-.85-2.14-1.7-3.2-2.56a16.41,16.41,0,0,0-3.84-1.92,13.77,13.77,0,0,0-3.84-1.28,20.49,20.49,0,0,0-12.38,1.28,24.8,24.8,0,0,0-7,4.48,22.19,22.19,0,0,0-4.48,7,20.19,20.19,0,0,0,0,16.22,22.19,22.19,0,0,0,4.48,7A22.44,22.44,0,0,0,128,149.33a32.71,32.71,0,0,0,4.27-.42,13.77,13.77,0,0,0,3.84-1.28,16.41,16.41,0,0,0,3.84-1.92c1.06-.86,2.13-1.71,3.2-2.56A22.44,22.44,0,0,0,149.33,128,21.38,21.38,0,0,0,147.63,119.89ZM384,106.67H213.33a21.33,21.33,0,0,0,0,42.66H384a21.33,21.33,0,0,0,0-42.66ZM148.91,251.73a13.77,13.77,0,0,0-1.28-3.84,16.41,16.41,0,0,0-1.92-3.84c-.86-1.06-1.71-2.13-2.56-3.2a24.8,24.8,0,0,0-7-4.48,21.38,21.38,0,0,0-16.22,0,24.8,24.8,0,0,0-7,4.48c-.85,1.07-1.7,2.14-2.56,3.2a16.41,16.41,0,0,0-1.92,3.84,13.77,13.77,0,0,0-1.28,3.84,32.71,32.71,0,0,0-.42,4.27A21.1,21.1,0,0,0,128,277.33,21.12,21.12,0,0,0,149.34,256,34.67,34.67,0,0,0,148.91,251.73ZM384,234.67H213.33a21.33,21.33,0,0,0,0,42.66H384a21.33,21.33,0,0,0,0-42.66ZM147.63,375.89a20.66,20.66,0,0,0-27.74-11.52,24.8,24.8,0,0,0-7,4.48,24.8,24.8,0,0,0-4.48,7,21.38,21.38,0,0,0-1.7,8.11,21.33,21.33,0,1,0,42.66,0A17.9,17.9,0,0,0,147.63,375.89ZM384,362.67H213.33a21.33,21.33,0,0,0,0,42.66H384a21.33,21.33,0,0,0,0-42.66Z"></path></svg>
                        <p class="no-margin bold forum-color fs16">Permission Informations</p>
                    </div>
                    <div class="section-style mb8">
                        <span class="block bold lblack mb8">Important</span>
                        <p class="no-margin fs13 mb4 lblack lh15">Please be careful when you're updating because some permissions attributes (like slug) are used in codebase checks to verify user authorization for performing activities.</p>
                        <p class="no-margin fs13 lblack lh15">Don't update permission informations unless you are 100% sure about it.(we provided a confirmation before updating)</p>
                    </div>
        
                    <!-- messages and inputs -->
                    <input type="hidden" id="permission-name-required" value="Permission name is required" autocomplete="off">
                    <input type="hidden" id="permission-slug-required" value="Permission slug is required" autocomplete="off">
                    <input type="hidden" id="permission-description-required" value="Permission description is required" autocomplete="off">
        
                    <div style="max-width: 600px">
                        <div class="mb8">
                            <label for="update-permission-name-input" class="flex align-center bold forum-color fs13">{{ __('Name') }}<span class="ml4 err red none fs12">*</span></label>
                            <p class="no-margin fs12 mb2 gray">Permission name should not contain commas(,)</p>
                            <input type="text" autocomplete="off" class="input-style-1 full-width" id="update-permission-name-input" placeholder="Permission name" value="{{ $permission->permission }}" style="padding: 8px 10px">
                        </div>
                        <div class="mb8">
                            <label for="update-permission-slug-input" class="flex align-center bold forum-color fs13">{{ __('Slug') }}<span class="ml4 err red none fs12">*</span></label>
                            <p class="no-margin fs12 mb2 gray">Permission slug also should not contain commas(,)</p>
                            <input type="text" autocomplete="off" class="input-style-1 full-width" id="update-permission-slug-input" placeholder="Permission slug" value="{{ $permission->slug }}" style="padding: 8px 10px">
                        </div>
                        <div style="margin-bottom: 14px">
                            <label for="update-permission-description-input" class="flex align-center bold forum-color mb4 fs13">{{ __('Description') }}<span class="ml4 err red none fs12">*</span></label>
                            <textarea id="update-permission-description-input" class="styled-textarea fs13"
                                style="margin: 0; padding: 8px; width: 100%; min-height: 110px; max-height: 110px;"
                                maxlength="800"
                                spellcheck="false"
                                autocomplete="off"
                                placeholder="{{ __('Permission description here') }}">{{ $permission->description }}</textarea>
                        </div>
                        <label for="update-permission-confirm-input" class="block mb4 bold forum-color">Confirmation</label>
                        <p class="no-margin mb4 lblack">Please type <strong>{{ auth()->user()->username }}::edit-permission::{{ $permission->slug }}</strong> to confirm.</p>
                        <div>
                            <input type="text" autocomplete="off" class="full-width input-style-1" id="update-permission-confirm-input" style="padding: 8px 10px" placeholder="confirmation">
                            <input type="hidden" id="update-permission-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}::edit-permission::{{ $permission->slug }}">
                        </div>
                        @if(!$canupdate)
                        <div class="section-style flex my8">
                            <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                            <p class="fs12 bold lblack no-margin">You don't have permission to update permissions informations. If you think something needs change, please contact a super admin.</p>
                        </div>
                        @endif
                        <div class="flex" style="margin-top: 12px">
                            @if($canupdate)
                            <div id="update-permission-button" class="disabled-green-button-style green-button-style full-center">
                                <div class="relative size14 mr4">
                                    <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M458.18,217.58a23.4,23.4,0,0,0-23.4,23.4V428.2a23.42,23.42,0,0,1-23.4,23.4H83.76a23.42,23.42,0,0,1-23.4-23.4V100.57a23.42,23.42,0,0,1,23.4-23.4H271a23.4,23.4,0,0,0,0-46.8H83.76a70.29,70.29,0,0,0-70.21,70.2V428.2a70.29,70.29,0,0,0,70.21,70.2H411.38a70.29,70.29,0,0,0,70.21-70.2V241A23.39,23.39,0,0,0,458.18,217.58Zm-302,56.25a11.86,11.86,0,0,0-3.21,6l-16.54,82.75a11.69,11.69,0,0,0,11.49,14,11.26,11.26,0,0,0,2.29-.23L233,359.76a11.68,11.68,0,0,0,6-3.21L424.12,171.4,341.4,88.68ZM481.31,31.46a58.53,58.53,0,0,0-82.72,0L366.2,63.85l82.73,82.72,32.38-32.39a58.47,58.47,0,0,0,0-82.72ZM155.72,273.08a11.86,11.86,0,0,0-3.21,6L136,361.8a11.69,11.69,0,0,0,11.49,14,11.26,11.26,0,0,0,2.29-.23L232.48,359a11.68,11.68,0,0,0,6-3.21L423.62,170.65,340.9,87.93ZM480.81,30.71a58.53,58.53,0,0,0-82.72,0L365.7,63.1l82.73,82.72,32.38-32.39a58.47,58.47,0,0,0,0-82.72Z"/></svg>
                                    <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                </div>
                                <span class="bold">Update permission informations</span>
                            </div>
                            @else
                            <div class="disabled-green-button-style green-button-style full-center">
                                <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M458.18,217.58a23.4,23.4,0,0,0-23.4,23.4V428.2a23.42,23.42,0,0,1-23.4,23.4H83.76a23.42,23.42,0,0,1-23.4-23.4V100.57a23.42,23.42,0,0,1,23.4-23.4H271a23.4,23.4,0,0,0,0-46.8H83.76a70.29,70.29,0,0,0-70.21,70.2V428.2a70.29,70.29,0,0,0,70.21,70.2H411.38a70.29,70.29,0,0,0,70.21-70.2V241A23.39,23.39,0,0,0,458.18,217.58Zm-302,56.25a11.86,11.86,0,0,0-3.21,6l-16.54,82.75a11.69,11.69,0,0,0,11.49,14,11.26,11.26,0,0,0,2.29-.23L233,359.76a11.68,11.68,0,0,0,6-3.21L424.12,171.4,341.4,88.68ZM481.31,31.46a58.53,58.53,0,0,0-82.72,0L366.2,63.85l82.73,82.72,32.38-32.39a58.47,58.47,0,0,0,0-82.72ZM155.72,273.08a11.86,11.86,0,0,0-3.21,6L136,361.8a11.69,11.69,0,0,0,11.49,14,11.26,11.26,0,0,0,2.29-.23L232.48,359a11.68,11.68,0,0,0,6-3.21L423.62,170.65,340.9,87.93ZM480.81,30.71a58.53,58.53,0,0,0-82.72,0L365.7,63.1l82.73,82.72,32.38-32.39a58.47,58.47,0,0,0,0-82.72Z"/></svg>
                                <span class="bold">Update permission informations</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="permission-section half-width">
                    <!-- attach/detach permission to members -->
                    <div class="flex align-center mb4">
                        <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130.34,245.7q-40.65,0-81.31,0c-10.29,0-13.65-3.39-13.65-13.66q0-60.49,0-121c0-9.82,3.61-13.39,13.47-13.41,5,0,9.93-.19,14.87.07,3,.15,3.43-1,3.47-3.63C67.32,83.05,66.29,72,69,61c7.38-29.7,34.36-49.32,66.07-47.81,28.86,1.38,53.84,24.47,58.24,53.66,1.36,9.06.6,18.15.71,27.22,0,2.69.58,3.73,3.49,3.61,5.61-.24,11.24-.14,16.86,0,7.2.11,11.43,4.23,11.44,11.43q.09,62.47,0,125c0,7.7-4.13,11.62-12.18,11.63Q172,245.76,130.34,245.7Zm-.09-148c13,0,26.09-.07,39.13,0,2.67,0,3.83-.49,3.71-3.47-.24-5.94.09-11.9-.12-17.83-.79-22.48-16.7-39.91-38.29-42.1-20.86-2.12-40.25,11.75-45.25,32.56-2.11,8.77-.85,17.76-1.32,26.65-.19,3.69,1.22,4.26,4.49,4.21C105.15,97.54,117.7,97.65,130.25,97.65Zm.37,42.41a31.73,31.73,0,0,0-.29,63.46,32,32,0,0,0,32-31.67A31.61,31.61,0,0,0,130.62,140.06Z"></path></svg>
                        <p class="no-margin bold forum-color fs16">Members already have this permission</p>
                    </div>
                    <p class="my4 fs12 lblack lh15">The following members already have this permissions. You can attach this permissions to more members as well as revoking it from its owners.</p>
                    <div class="flex align-center">
                        @if($can_grant_permission_to_users)
                        <div class="green-button-style flex align-center open-permission-grant-dialog" style="padding: 6px 12px">
                            <svg class="size8 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.22,3.31c3.07,2.55,4.08,5.71,4.06,9.78-.17,27.07,0,54.14-.18,81.21,0,3.57.69,4.66,4.49,4.63,27.24-.19,54.47-.11,81.71-.1,7.36,0,9.39,2,9.4,9.25q0,21.4,0,42.82c0,7-2.1,9.06-9.09,9.06-27.24,0-54.48.09-81.71-.09-3.85,0-4.83.95-4.8,4.81.17,27.07.1,54.14.09,81.21,0,7.65-1.94,9.59-9.56,9.6q-21.4,0-42.82,0c-6.62,0-8.75-2.19-8.75-8.91,0-27.4-.1-54.8.09-82.2,0-3.8-1.06-4.51-4.62-4.49-27.08.16-54.15,0-81.22.18-4.07,0-7.23-1-9.78-4.06V102.8c2.55-3.08,5.72-4.08,9.79-4.06,27.09.17,54.18,0,81.27.18,3.68,0,4.58-.87,4.55-4.56-.17-27.09,0-54.18-.18-81.27,0-4.06,1-7.23,4.06-9.78Z"></path></svg>
                            <span class="bold fs11">grant to new user(s)</span>
                        </div>
                        @else
                        <div class="disabled-green-button-style green-button-style flex align-center" title="you don't have permission to grant permissions to users" style="padding: 6px 12px">
                            <svg class="size8 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.22,3.31c3.07,2.55,4.08,5.71,4.06,9.78-.17,27.07,0,54.14-.18,81.21,0,3.57.69,4.66,4.49,4.63,27.24-.19,54.47-.11,81.71-.1,7.36,0,9.39,2,9.4,9.25q0,21.4,0,42.82c0,7-2.1,9.06-9.09,9.06-27.24,0-54.48.09-81.71-.09-3.85,0-4.83.95-4.8,4.81.17,27.07.1,54.14.09,81.21,0,7.65-1.94,9.59-9.56,9.6q-21.4,0-42.82,0c-6.62,0-8.75-2.19-8.75-8.91,0-27.4-.1-54.8.09-82.2,0-3.8-1.06-4.51-4.62-4.49-27.08.16-54.15,0-81.22.18-4.07,0-7.23-1-9.78-4.06V102.8c2.55-3.08,5.72-4.08,9.79-4.06,27.09.17,54.18,0,81.27.18,3.68,0,4.58-.87,4.55-4.56-.17-27.09,0-54.18-.18-81.27,0-4.06,1-7.23,4.06-9.78Z"></path></svg>
                            <span class="bold fs11">grant to new user(s)</span>
                        </div>
                        @endif
                        <div class="gray height-max-content fs10 bold mx8">•</div>
                        @if($can_revoke_permission_from_users)
                        <div class="red-button-style flex align-center open-revoke-permission-from-users-dialog" style="padding: 6px 12px">
                            <svg class="size10 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.19,144V114.32c2.06-1.67,1.35-4.2,1.78-6.3Q19.81,30.91,94.83,7.28c6.61-2.07,13.5-3.26,20.26-4.86h26.73c1.44,1.93,3.6.92,5.39,1.2C215,14.2,261.83,74.5,254.91,142.49c-6.25,61.48-57.27,110-119,113.3A127.13,127.13,0,0,1,4.9,155.18C4.09,151.45,4.42,147.42,2.19,144Zm126.75-30.7c-19.8,0-39.6.08-59.4-.08-3.24,0-4.14.82-4.05,4,.24,8.08.21,16.17,0,24.25-.07,2.83.77,3.53,3.55,3.53q59.89-.14,119.8,0c2.8,0,3.6-.74,3.53-3.54-.18-8.08-.23-16.17,0-24.25.1-3.27-.85-4.06-4.06-4C168.55,113.4,148.75,113.33,128.94,113.33Z"/></svg>
                            <span class="bold fs11">revoke permission from user(s)</span>
                        </div>
                        @else
                        <div class="disabled-red-button-style red-button-style flex align-center" title="you don't have permission to revoke permissions from users" style="padding: 6px 12px">
                            <svg class="size10 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.19,144V114.32c2.06-1.67,1.35-4.2,1.78-6.3Q19.81,30.91,94.83,7.28c6.61-2.07,13.5-3.26,20.26-4.86h26.73c1.44,1.93,3.6.92,5.39,1.2C215,14.2,261.83,74.5,254.91,142.49c-6.25,61.48-57.27,110-119,113.3A127.13,127.13,0,0,1,4.9,155.18C4.09,151.45,4.42,147.42,2.19,144Zm126.75-30.7c-19.8,0-39.6.08-59.4-.08-3.24,0-4.14.82-4.05,4,.24,8.08.21,16.17,0,24.25-.07,2.83.77,3.53,3.55,3.53q59.89-.14,119.8,0c2.8,0,3.6-.74,3.53-3.54-.18-8.08-.23-16.17,0-24.25.1-3.27-.85-4.06-4.06-4C168.55,113.4,148.75,113.33,128.94,113.33Z"/></svg>
                            <span class="bold fs11">revoke permission from user(s)</span>
                        </div>
                        @endif
                    </div>
                    <div class="flex flex-wrap section-style border-box autoscrolly" style="padding: 10px; margin: 12px 0; max-height: 250px;">
                        @foreach($users as $user)
                        <div class="flex align-center flex-column mx8 my8">
                            <img src="{{ $user->sizedavatar(100, '-h') }}" class="rounded-entity-for-permission" alt="">
                            <span class="bold blue fs11 mt4">{{ $user->username }}</span>
                            @if($hr = $user->high_role())
                            <span class="bold lblack fs10">{{ $hr->role  }}</span>
                            @else
                            <em class="gray fs10">Normal user</em>
                            @endif
                        </div>
                        @endforeach
                        @if(!$users->count())
                        <div class="flex align-center">
                            <svg class="size12 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                            <p class="fs12 no-margin italic gray">This permission is not granted by any user for the moment</p>
                        </div>
                        @endif
                    </div>

                    <!-- roles that this permission attached to -->
                    <div class="flex align-center mb4">
                        <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.12,231.24c2.31-3.71,3.06-8.13,5.64-11.76a36.53,36.53,0,0,1,14.13-11.94c-6-5.69-9.23-12.14-8.34-20.21a21.81,21.81,0,0,1,8-14.77,22.21,22.21,0,0,1,30,1.73c8.91,9.18,8.22,21.91-1.78,32.9,2.87,2.14,5.94,4.06,8.58,6.46,7.19,6.54,10.59,14.89,10.81,24.54.14,6.25.1,12.5.14,18.75-21.12,0-42.23-.05-63.34.06-2.81,0-4.05-.27-3.9-3.64C3.35,246,3.12,238.61,3.12,231.24Zm252.72,25.7c0-6.42.14-12.85,0-19.26-.32-11.65-5.39-20.8-15-27.44-1.46-1-3-1.93-4.51-2.92,10.06-10.85,11-23,2.57-32.36A22.2,22.2,0,0,0,209,172a21.26,21.26,0,0,0-8.41,13.48c-1.51,8.68,1.38,16,7.89,21.91-13.05,7.83-19.22,17.23-19.62,29.81-.21,6.58-.12,13.17-.17,19.75Zm-92.8,0c0-6.42.09-12.85-.09-19.27a33,33,0,0,0-13-26c-2-1.61-4.3-2.92-6.49-4.38,10.35-11,10.92-24.16,1.56-33.38a22.16,22.16,0,0,0-30.72-.32c-9.69,9.21-9.27,22.38,1.27,33.8-1.28.78-2.53,1.49-3.74,2.29-9.73,6.38-15.15,15.39-15.76,27-.36,6.73-.12,13.5-.15,20.25ZM96,77.28a87.53,87.53,0,0,1-.07,11.34c-.45,4.15,1.32,4.76,4.94,4.72,16.77-.17,33.53-.06,50.3-.08,3.77,0,8.79,1.31,11-.59,2.61-2.26.6-7.43.87-11.33,1.1-16.44-4.23-29.59-19.56-37.45C153.86,32,154.27,19,144.7,9.93A22.16,22.16,0,0,0,114,10.2c-9.3,9.07-8.77,22.19,1.61,33.66C102.06,51.07,95.58,62.15,96,77.28ZM33.4,122.86c-3.47,0-4.5,1-4.39,4.42.26,7.41.15,14.83,0,22.24,0,2.26.6,3.1,3,3.26,11.75.78,11.88.86,11.82-10.59,0-3.45.94-4.44,4.4-4.41,20.88.15,41.77.07,62.66.07,10.84,0,10.94,0,11,10.87,0,2.82.48,4,3.73,4.09,11,.13,11.14.28,11.15-10.84,0-3.16.78-4.21,4.09-4.19q35,.21,70.07,0c3.36,0,4,1.15,4.05,4.25,0,11.09.12,10.95,11.17,10.78,3.27-.06,3.75-1.34,3.69-4.12-.16-7.08-.29-14.18,0-21.25.18-3.85-1.16-4.6-4.74-4.58-25.82.14-51.65.08-77.47.08-10.66,0-10.76,0-10.76-10.63,0-3-.48-4.34-4-4.34-10.85,0-11-.17-10.9,10.6,0,3.39-.79,4.5-4.33,4.45-14-.21-28-.08-41.94-.08C61.69,122.94,47.54,123.05,33.4,122.86Z"/></svg>
                        <p class="no-margin bold forum-color fs16">Roles where permission attached to</p>
                    </div>
                    <p class="my4 fs12 lblack lh15">"<strong>{{ $permission->permission }}</strong>" permission is currently attached to the following role. In order to attach/detach it from a role, click on the target role to manage it from role management page</p>
                    <div class="section-style x-auto-overflow" style="max-height: 200px">
                        <div class="block gray height-max-content fs10 bold mb4">• Roles where this permission attached to</div>
                        <div class="flex flex-wrap">
                            @foreach($roles as $role)
                                <a href="{{ route('admin.rap.manage.role', ['roleid'=>$role->id]) }}" class="button-style-4 flex align-center lblack bold fs12 mx4 my4">
                                    <svg class="mr4 size13" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M254.7,64.53c-1.76.88-1.41,2.76-1.8,4.19a50.69,50.69,0,0,1-62,35.8c-3.39-.9-5.59-.54-7.89,2.2-2.8,3.34-6.16,6.19-9.17,9.36-1.52,1.6-2.5,2.34-4.5.28-8.79-9-17.75-17.94-26.75-26.79-1.61-1.59-1.87-2.49-.07-4.16,4-3.74,8.77-7.18,11.45-11.78,2.79-4.79-1.22-10.29-1.41-15.62C151.74,33.52,167,12.55,190.72,5.92c1.25-.35,3,0,3.71-1.69H211c.23,1.11,1.13.87,1.89,1,3.79.48,7.43,1.2,8.93,5.45s-1.06,7-3.79,9.69c-6.34,6.26-12.56,12.65-19,18.86-1.77,1.72-2,2.75,0,4.57,5.52,5.25,10.94,10.61,16.15,16.16,2.1,2.24,3.18,1.5,4.92-.28q9.83-10.1,19.9-20c5.46-5.32,11.43-3.47,13.47,3.91.4,1.47-.4,3.32,1.27,4.41Zm0,179-25.45-43.8-28.1,28.13c13.34,7.65,26.9,15.46,40.49,23.21,6.14,3.51,8.73,2.94,13.06-2.67ZM28.2,4.23C20.7,9.09,15,15.89,8.93,22.27,4.42,27,4.73,33.56,9.28,38.48c4.18,4.51,8.7,8.69,13,13.13,1.46,1.53,2.4,1.52,3.88,0Q39.58,38,53.19,24.49c1.12-1.12,2-2,.34-3.51C47.35,15.41,42.43,8.44,35,4.23ZM217.42,185.05Q152.85,120.42,88.29,55.76c-1.7-1.7-2.63-2-4.49-.11-8.7,8.93-17.55,17.72-26.43,26.48-1.63,1.61-2.15,2.52-.19,4.48Q122,151.31,186.71,216.18c1.68,1.68,2.61,2,4.46.1,8.82-9.05,17.81-17.92,26.74-26.86.57-.58,1.12-1.17,1.78-1.88C218.92,186.68,218.21,185.83,217.42,185.05ZM6.94,212.72c.63,3.43,1.75,6.58,5.69,7.69,3.68,1,6.16-.77,8.54-3.18,6.27-6.32,12.76-12.45,18.81-19,2.61-2.82,4-2.38,6.35.16,4.72,5.11,9.65,10.06,14.76,14.77,2.45,2.26,2.1,3.51-.11,5.64C54.2,225.32,47.57,232,41,238.73c-4.92,5.08-3.25,11.1,3.57,12.9a45,45,0,0,0,9.56,1.48c35.08,1.51,60.76-30.41,51.76-64.43-.79-3-.29-4.69,1.89-6.65,3.49-3.13,6.62-6.66,10-9.88,1.57-1.48,2-2.38.19-4.17q-13.72-13.42-27.14-27.14c-1.56-1.59-2.42-1.38-3.81.11-3.11,3.3-6.56,6.28-9.53,9.7-2.28,2.61-4.37,3.25-7.87,2.31C37.45,144.33,5.87,168.73,5.85,202.7,5.6,205.71,6.3,209.22,6.94,212.72ZM47.57,71.28c6.77-6.71,13.5-13.47,20.24-20.21,8.32-8.33,8.25-8.25-.35-16.25-1.82-1.69-2.69-1.42-4.24.14-8.85,9-17.8,17.85-26.69,26.79-.64.65-1.64,2.06-1.48,2.24,3,3.38,6.07,6.63,8.87,9.62C46.08,73.44,46.7,72.14,47.57,71.28Z"></path></svg>
                                    {{ $role->role }}
                                </a>
                            @endforeach
                        </div>
                        @if(!$roles->count())
                        <div class="flex align-center">
                            <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                            <p class="no-margin fs12 italic gray">This permission is not attached to any role for the moment</p>
                        </div>
                        @endif
                    </div>

                    <!-- delete role -->
                    <div class="flex align-center mb4" style="margin-top: 14px">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                        <p class="no-margin bold forum-color fs16">Delete permission</p>
                    </div>
                    <p class="my4 fs13 lblack lh15">Deleting the permission will revoke it from all members who have this permission already.</p>
                    <div class="section-style">
                        <span class="block bold lblack mb8">Important</span>
                        <p class="no-margin fs13 lblack lh15">Once the permission gets deleted, it will be detached from all its associated roles and users, and any activity based on this permission will be blocked.</p>
                    </div>
                    @if($candelete)
                    <div class="red-button-style width-max-content flex align-center mt8 open-delete-permission-dialog">
                        <svg class="size12 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                        <span class="fs11 bold">Delete permission</span>
                    </div>
                    @else
                    <div class="section-style flex align-center my8">
                        <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <p class="fs12 bold lblack no-margin">You don't have permission to delete permissions</p>
                    </div>
                    <div class="disabled-red-button-style red-button-style width-max-content flex align-center mt8" title="you don't have permission to delete permissions">
                        <svg class="size12 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                        <span class="fs11 bold">Delete permission</span>
                    </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection