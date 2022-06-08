@extends('layouts.admin')

@section('title', 'R&P - Hierarchy')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.rap', 'subpage'=>'admin.rap.hierarchy'])
@endsection

@push('scripts')
<script src="{{ asset('js/admin/roles-and-permissions/hierarchy.js') }}" defer></script>
<script src="{{ asset('js/admin/roles-and-permissions/roles-management.js') }}" defer></script>
@endpush

@push('styles')
<link href="{{ asset('css/admin/rap.css') }}" rel="stylesheet"/>
@endpush

@section('content')
    <style>
        .role-users-container {
            border-bottom: unset;
        }

        .role-users-container:last-child {
            border-bottom: 1px solid #c4c4c4;
        }
    </style>
    <div id="role-review-viewer" class="global-viewer full-center none">
        <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
        <div class="viewer-box-style-1" style="width: 600px;">
            <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                <div class="flex align-center">
                    <svg class="size16 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.12,231.24c2.31-3.71,3.06-8.13,5.64-11.76a36.53,36.53,0,0,1,14.13-11.94c-6-5.69-9.23-12.14-8.34-20.21a21.81,21.81,0,0,1,8-14.77,22.21,22.21,0,0,1,30,1.73c8.91,9.18,8.22,21.91-1.78,32.9,2.87,2.14,5.94,4.06,8.58,6.46,7.19,6.54,10.59,14.89,10.81,24.54.14,6.25.1,12.5.14,18.75-21.12,0-42.23-.05-63.34.06-2.81,0-4.05-.27-3.9-3.64C3.35,246,3.12,238.61,3.12,231.24Zm252.72,25.7c0-6.42.14-12.85,0-19.26-.32-11.65-5.39-20.8-15-27.44-1.46-1-3-1.93-4.51-2.92,10.06-10.85,11-23,2.57-32.36A22.2,22.2,0,0,0,209,172a21.26,21.26,0,0,0-8.41,13.48c-1.51,8.68,1.38,16,7.89,21.91-13.05,7.83-19.22,17.23-19.62,29.81-.21,6.58-.12,13.17-.17,19.75Zm-92.8,0c0-6.42.09-12.85-.09-19.27a33,33,0,0,0-13-26c-2-1.61-4.3-2.92-6.49-4.38,10.35-11,10.92-24.16,1.56-33.38a22.16,22.16,0,0,0-30.72-.32c-9.69,9.21-9.27,22.38,1.27,33.8-1.28.78-2.53,1.49-3.74,2.29-9.73,6.38-15.15,15.39-15.76,27-.36,6.73-.12,13.5-.15,20.25ZM96,77.28a87.53,87.53,0,0,1-.07,11.34c-.45,4.15,1.32,4.76,4.94,4.72,16.77-.17,33.53-.06,50.3-.08,3.77,0,8.79,1.31,11-.59,2.61-2.26.6-7.43.87-11.33,1.1-16.44-4.23-29.59-19.56-37.45C153.86,32,154.27,19,144.7,9.93A22.16,22.16,0,0,0,114,10.2c-9.3,9.07-8.77,22.19,1.61,33.66C102.06,51.07,95.58,62.15,96,77.28ZM33.4,122.86c-3.47,0-4.5,1-4.39,4.42.26,7.41.15,14.83,0,22.24,0,2.26.6,3.1,3,3.26,11.75.78,11.88.86,11.82-10.59,0-3.45.94-4.44,4.4-4.41,20.88.15,41.77.07,62.66.07,10.84,0,10.94,0,11,10.87,0,2.82.48,4,3.73,4.09,11,.13,11.14.28,11.15-10.84,0-3.16.78-4.21,4.09-4.19q35,.21,70.07,0c3.36,0,4,1.15,4.05,4.25,0,11.09.12,10.95,11.17,10.78,3.27-.06,3.75-1.34,3.69-4.12-.16-7.08-.29-14.18,0-21.25.18-3.85-1.16-4.6-4.74-4.58-25.82.14-51.65.08-77.47.08-10.66,0-10.76,0-10.76-10.63,0-3-.48-4.34-4-4.34-10.85,0-11-.17-10.9,10.6,0,3.39-.79,4.5-4.33,4.45-14-.21-28-.08-41.94-.08C61.69,122.94,47.54,123.05,33.4,122.86Z"/></svg>
                    <span class="fs20 bold forum-color">{{ __('Role Review') }}</span>
                </div>
                <div class="pointer fs20 close-global-viewer unselectable">✖</div>
            </div>
            <div class="full-center relative">
                <div class="global-viewer-content-box full-dimensions scrolly" style="padding: 14px; min-height: 200px; max-height: 450px">
                    
                </div>
                <svg class="loading-viewer-spinner size36 absolute black" fill="none" viewBox="0 0 16 16">
                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                </svg>
            </div>
        </div>
    </div>
    <div class="flex align-center space-between top-page-title-box">
        <div class="flex align-center">
            <svg class="mr8 size20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M122.69,171.45c0-10.09-.09-20.17,0-30.25,0-2.77-.27-4.09-3.63-4-8.25.28-16.53.23-24.78,0-3-.08-3.75,1-3.41,3.65a27.53,27.53,0,0,1,0,4c-.22,9.51-6.79,16.17-16.33,16.24q-23.29.15-46.61,0c-9.75-.06-16.32-6.8-16.39-16.66q-.12-15.12,0-30.24c.08-9.85,6.66-16.49,16.49-16.54q23.06-.12,46.11,0c10.08,0,16.6,6.69,16.74,16.83.09,7,.09,7,6.94,7s13.89-.18,20.82.07c3.24.13,4.08-.81,4.05-4-.16-19.17-.09-38.34-.07-57.51,0-16.06,9.84-25.78,26-25.8,6.28,0,12.56-.09,18.84,0,2.16,0,3-.56,2.78-2.76a43.09,43.09,0,0,1,0-5.45c.32-8.71,6.78-15.48,15.44-15.58q24.28-.27,48.59,0a15.47,15.47,0,0,1,15.24,15.23q.33,16.35,0,32.72A15.55,15.55,0,0,1,234,73.78q-24,.24-48.09,0c-9-.1-15.45-7.1-15.61-16.44-.13-7.31-.13-7.31-7.58-7.31-4.95,0-9.91-.05-14.87,0-6.24.08-9.25,2.92-9.27,9-.06,19.67,0,39.33-.09,59,0,2.93.95,3.51,3.63,3.46,8.1-.17,16.2-.26,24.29,0,3.42.12,4.34-1.08,3.91-4.16a23.62,23.62,0,0,1,0-3.47c.21-9.53,6.75-16.18,16.29-16.24q23.31-.15,46.61,0c9.78.06,16.35,6.74,16.43,16.62q.13,15.12,0,30.25c-.08,9.85-6.67,16.51-16.47,16.57q-23.06.14-46.12,0c-10.09-.05-16.62-6.7-16.74-16.83-.09-7-.09-7-6.94-7-7.27,0-14.54.09-21.81,0-2.37-.05-3.06.63-3,3,.09,20,0,40,.09,60,0,5.07,3,8.24,7.85,8.38,7.1.2,14.21,0,21.32.1,1.87,0,2.72-.47,2.56-2.48a49.52,49.52,0,0,1,0-5.45c.26-9,6.73-15.77,15.65-15.86q24-.24,48.1,0a15.55,15.55,0,0,1,15.53,15.46c.2,10.74.18,21.49,0,32.23a15.62,15.62,0,0,1-15.81,15.7q-23.81.21-47.6,0c-9.34-.09-15.76-7-15.89-16.66-.1-7.1-.1-7.1-7.29-7.1-5.46,0-10.91.07-16.37,0-13.55-.21-23.77-10.37-23.93-23.89C122.59,191,122.69,181.2,122.69,171.45Z"/></svg>
            <h1 class="fs22 no-margin lblack">{{ __('Roles & Permissions - hierarchy') }}</h1>
        </div>
        <div class="flex align-center height-max-content">
            <div class="flex align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                <a href="{{ route('admin.dashboard') }}" class="link-path">{{ __('Home') }}</a>
            </div>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Roles & permissions') }}</span>
            </div>
        </div>
    </div>
    <div id="admin-main-content-box">
        <h2 class="no-margin fs22 lblack" style="margin-bottom: 12px">Hierarchy of members roles & permissions </h2>
        <h3 class="no-margin mb8 fs15 forum-color">Default roles & permissions</h3>
        <p class="lblack no-margin fs13 mb4">The following diagram lists all existing roles and their default attached permissions. the table below shows all members with roles from higher to lower priority.</p>
        <div class="section-style fs12 lblack" style="padding: 10px">
            <p class="no-margin" style="line-height: 1.5">Permissions attached to roles <strong>could be revoked</strong> later; If a particular user is an admin, this means he can warn or strike a user (admin by default has these 2 permissions), but a super admin could revoke these permissions from that admin, which means that <strong>permissions are not strongly fixed to roles</strong>.</p>
            <p class="no-margin mt8" style="line-height: 1.5">If a user is an admin, then he can warn a user; but we could have an admin without this permission.</p>
            <p class="no-margin mt8" style="line-height: 1.5">The permissions attached to each role in the following diagram are the <strong>default ones</strong>. For now, <strong>only site owners could grant</strong>/<strong>revoke</strong> permissions to/from users.</p>
        </div>
        <div class="flex justify-center" style="margin: 12px 0 40px 0">
            <div class="flex align-center">
                @foreach($roles as $role)
                <div class="open-role-review-dialog rounded-entity full-center flex-column bold lblack relative">
                    <input type="hidden" class="role-id" value="{{ $role->id }}" autocomplete="off">
                    @if($role->slug == 'site-owner')
                    <svg class="size20" style="margin-top: -18px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.44,172.34c-10.15,14.26-25.88,18.13-41.5,21.48-43.65,9.35-87.82,10-132.06,5.81-20.18-1.9-40.31-4.88-59.29-12.74-5-2.07-9.8-4.58-13.76-8.36-7.07-6.75-7-14.28.28-20.79s16.06-9.27,25-12c7.48-2.28,7.64-2.16,8.08,5.36.51,8.47,5.39,13.72,12.37,17.54,12.18,6.68,25.66,8.72,39.12,10.42a273.28,273.28,0,0,0,89-2.87c8.2-1.66,16.17-4,23.41-8.45s11.29-10.5,10.57-19c-.41-4.91,1.19-5.3,5.38-4,7.64,2.44,15.22,4.9,22.25,8.84,5.28,3,9.22,7,11.18,12.84Zm-88.5-.17c12-1.77,23.93-3.57,34.76-9.58,5.6-3.11,9.07-7.2,8.51-14.09-.58-7.18-.45-14.41-1.09-21.58-1.28-14.37-3.68-28.52-9.74-41.81-9.14-20-25.42-28.5-46.66-23.8-9.94,2.19-19.17,6.43-28,11.51a23.2,23.2,0,0,1-15.59,2.63,207,207,0,0,0-21.46-2.33c-11.61-.5-21.11,3.7-27.4,14A52.88,52.88,0,0,0,56,98.65c-5.58,17.25-5.48,35.16-5.91,53-.11,4.68,3.07,7.85,6.88,10.09a50.94,50.94,0,0,0,10.65,4.9c20.56,6.33,41.72,7.84,68,7.93A204.19,204.19,0,0,0,167.94,172.17Z"/></svg>
                    @endif
                    <span class="text-center">{{ $role->role }}</span>
                    <div class="def-role-permissions-box">
                        @if($role->slug == 'site-owner')
                        <svg class="size14 mr8" style="min-width: 14px" fill="#7e838a" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"/></svg>
                        <span class="fs10 bold lblack" style="margin-top: 6px; width: max-content">Absolute control</span>
                        @endif
                    </div>
                </div>
                @if(!$loop->last)
                <div class="full-center flex-column">
                    <p class="no-margin fs10 bold gray mb4">manages</p>
                    <div class="simple-line-separator" style="width: 64px; background-color: #7e838a;"></div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        <h3 class="no-margin mb8 fs16 forum-color">Roles & permissions members</h3>
        <p class="fs13 no-margin mb4">The following diagram shows roles and acquiring members from high priority to lower priority.</p>
        <div>
            <div class="flex role-users-container" style="background-color: #dbe0e882">
                <div class="role-users-role-desc lblack full-center border-box" style="width: 260px">
                    <span class="no-margin bold">Role description</span>
                </div>
                <div class="role-users-users-section lblack full-center" style="flex: 1">
                    <span class="no-margin bold">Users with roles</span>
                </div>
            </div>
            @foreach($rolesusers as $roleslug=>$roleusers)
            @php 
                $r = \App\Models\Role::where('slug', $roleslug)->first();
            @endphp
            <div class="flex role-users-container">
                <div class="role-users-role-desc lblack fs13 border-box" style="width: 260px">
                    <div class="flex align-end mb4">
                        <p class="no-margin bold blue fs15">{{ $r->role }}</p>
                        <a href="{{ route('admin.rap.manage.role') . '?roleid=' . $r->id }}" class="button-style-4 full-center move-to-right no-underline black" style="padding: 4px 10px;">
                            <svg class="mr4 size11" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M254.7,64.53c-1.76.88-1.41,2.76-1.8,4.19a50.69,50.69,0,0,1-62,35.8c-3.39-.9-5.59-.54-7.89,2.2-2.8,3.34-6.16,6.19-9.17,9.36-1.52,1.6-2.5,2.34-4.5.28-8.79-9-17.75-17.94-26.75-26.79-1.61-1.59-1.87-2.49-.07-4.16,4-3.74,8.77-7.18,11.45-11.78,2.79-4.79-1.22-10.29-1.41-15.62C151.74,33.52,167,12.55,190.72,5.92c1.25-.35,3,0,3.71-1.69H211c.23,1.11,1.13.87,1.89,1,3.79.48,7.43,1.2,8.93,5.45s-1.06,7-3.79,9.69c-6.34,6.26-12.56,12.65-19,18.86-1.77,1.72-2,2.75,0,4.57,5.52,5.25,10.94,10.61,16.15,16.16,2.1,2.24,3.18,1.5,4.92-.28q9.83-10.1,19.9-20c5.46-5.32,11.43-3.47,13.47,3.91.4,1.47-.4,3.32,1.27,4.41Zm0,179-25.45-43.8-28.1,28.13c13.34,7.65,26.9,15.46,40.49,23.21,6.14,3.51,8.73,2.94,13.06-2.67ZM28.2,4.23C20.7,9.09,15,15.89,8.93,22.27,4.42,27,4.73,33.56,9.28,38.48c4.18,4.51,8.7,8.69,13,13.13,1.46,1.53,2.4,1.52,3.88,0Q39.58,38,53.19,24.49c1.12-1.12,2-2,.34-3.51C47.35,15.41,42.43,8.44,35,4.23ZM217.42,185.05Q152.85,120.42,88.29,55.76c-1.7-1.7-2.63-2-4.49-.11-8.7,8.93-17.55,17.72-26.43,26.48-1.63,1.61-2.15,2.52-.19,4.48Q122,151.31,186.71,216.18c1.68,1.68,2.61,2,4.46.1,8.82-9.05,17.81-17.92,26.74-26.86.57-.58,1.12-1.17,1.78-1.88C218.92,186.68,218.21,185.83,217.42,185.05ZM6.94,212.72c.63,3.43,1.75,6.58,5.69,7.69,3.68,1,6.16-.77,8.54-3.18,6.27-6.32,12.76-12.45,18.81-19,2.61-2.82,4-2.38,6.35.16,4.72,5.11,9.65,10.06,14.76,14.77,2.45,2.26,2.1,3.51-.11,5.64C54.2,225.32,47.57,232,41,238.73c-4.92,5.08-3.25,11.1,3.57,12.9a45,45,0,0,0,9.56,1.48c35.08,1.51,60.76-30.41,51.76-64.43-.79-3-.29-4.69,1.89-6.65,3.49-3.13,6.62-6.66,10-9.88,1.57-1.48,2-2.38.19-4.17q-13.72-13.42-27.14-27.14c-1.56-1.59-2.42-1.38-3.81.11-3.11,3.3-6.56,6.28-9.53,9.7-2.28,2.61-4.37,3.25-7.87,2.31C37.45,144.33,5.87,168.73,5.85,202.7,5.6,205.71,6.3,209.22,6.94,212.72ZM47.57,71.28c6.77-6.71,13.5-13.47,20.24-20.21,8.32-8.33,8.25-8.25-.35-16.25-1.82-1.69-2.69-1.42-4.24.14-8.85,9-17.8,17.85-26.69,26.79-.64.65-1.64,2.06-1.48,2.24,3,3.38,6.07,6.63,8.87,9.62C46.08,73.44,46.7,72.14,47.57,71.28Z"/></svg>
                            <span class="no-wrap fs11 bold">manage role</span>
                        </a>
                    </div>
                    <p class="no-margin lblack fs13"><strong>Description</strong> : {{ $r->description }}</p>
                </div>
                <div class="role-users-users-section" style="flex: 1; overflow-x: auto; max-width: 1px"> <!-- this will be updated dynamically at run time (look at hierarchy js file) -->
                    <div class="full-center width-max-content full-height" style="padding: 14px 10px;">
                        @foreach($roleusers as $u)
                        <div class="user-role-entity relative">
                            <div class="relative">
                                <img src="{{ $u->sizedavatar(100, '-h') }}" class="user-rounded-entity-avatar" alt="">
                                <div class="relative role-user-manage-button-and-section">
                                    <svg class="size14 button-with-suboptions pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><g><path d="M5 13h90v14H5z"/><path d="M5 43h90v14H5z"/><path d="M5 73h90v14H5z"/></g></svg>
                                    <div class="suboptions-container suboptions-container-right-style" style="top: calc(100% + 2px); left: 0">
                                        <a href="{{ route('admin.rap.manage.user') . '?uid=' . $u->id }}" class="no-underline mb4 simple-suboption flex align-center" style="padding: 5px 12px">
                                            <svg class="mr8 size12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M254.7,64.53c-1.76.88-1.41,2.76-1.8,4.19a50.69,50.69,0,0,1-62,35.8c-3.39-.9-5.59-.54-7.89,2.2-2.8,3.34-6.16,6.19-9.17,9.36-1.52,1.6-2.5,2.34-4.5.28-8.79-9-17.75-17.94-26.75-26.79-1.61-1.59-1.87-2.49-.07-4.16,4-3.74,8.77-7.18,11.45-11.78,2.79-4.79-1.22-10.29-1.41-15.62C151.74,33.52,167,12.55,190.72,5.92c1.25-.35,3,0,3.71-1.69H211c.23,1.11,1.13.87,1.89,1,3.79.48,7.43,1.2,8.93,5.45s-1.06,7-3.79,9.69c-6.34,6.26-12.56,12.65-19,18.86-1.77,1.72-2,2.75,0,4.57,5.52,5.25,10.94,10.61,16.15,16.16,2.1,2.24,3.18,1.5,4.92-.28q9.83-10.1,19.9-20c5.46-5.32,11.43-3.47,13.47,3.91.4,1.47-.4,3.32,1.27,4.41Zm0,179-25.45-43.8-28.1,28.13c13.34,7.65,26.9,15.46,40.49,23.21,6.14,3.51,8.73,2.94,13.06-2.67ZM28.2,4.23C20.7,9.09,15,15.89,8.93,22.27,4.42,27,4.73,33.56,9.28,38.48c4.18,4.51,8.7,8.69,13,13.13,1.46,1.53,2.4,1.52,3.88,0Q39.58,38,53.19,24.49c1.12-1.12,2-2,.34-3.51C47.35,15.41,42.43,8.44,35,4.23ZM217.42,185.05Q152.85,120.42,88.29,55.76c-1.7-1.7-2.63-2-4.49-.11-8.7,8.93-17.55,17.72-26.43,26.48-1.63,1.61-2.15,2.52-.19,4.48Q122,151.31,186.71,216.18c1.68,1.68,2.61,2,4.46.1,8.82-9.05,17.81-17.92,26.74-26.86.57-.58,1.12-1.17,1.78-1.88C218.92,186.68,218.21,185.83,217.42,185.05ZM6.94,212.72c.63,3.43,1.75,6.58,5.69,7.69,3.68,1,6.16-.77,8.54-3.18,6.27-6.32,12.76-12.45,18.81-19,2.61-2.82,4-2.38,6.35.16,4.72,5.11,9.65,10.06,14.76,14.77,2.45,2.26,2.1,3.51-.11,5.64C54.2,225.32,47.57,232,41,238.73c-4.92,5.08-3.25,11.1,3.57,12.9a45,45,0,0,0,9.56,1.48c35.08,1.51,60.76-30.41,51.76-64.43-.79-3-.29-4.69,1.89-6.65,3.49-3.13,6.62-6.66,10-9.88,1.57-1.48,2-2.38.19-4.17q-13.72-13.42-27.14-27.14c-1.56-1.59-2.42-1.38-3.81.11-3.11,3.3-6.56,6.28-9.53,9.7-2.28,2.61-4.37,3.25-7.87,2.31C37.45,144.33,5.87,168.73,5.85,202.7,5.6,205.71,6.3,209.22,6.94,212.72ZM47.57,71.28c6.77-6.71,13.5-13.47,20.24-20.21,8.32-8.33,8.25-8.25-.35-16.25-1.82-1.69-2.69-1.42-4.24.14-8.85,9-17.8,17.85-26.69,26.79-.64.65-1.64,2.06-1.48,2.24,3,3.38,6.07,6.63,8.87,9.62C46.08,73.44,46.7,72.14,47.57,71.28Z"/></svg>
                                            <div class="black fs13">{{ __('Manage user r&p') }}</div>
                                        </a>
                                        <a href="{{ route('admin.user.manage') . '?uid=' . $u->id }}" class="no-underline simple-suboption flex align-center" style="padding: 5px 12px">
                                            <svg class="mr8 size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
                                            <div class="black fs13">{{ __('User admin profile') }}</div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <span class="bold forum-color">{{ $u->lightusername }}</span>
                            <div class="fs10 text-center" style="max-width: 80px">
                                <span class="bold forum-color fs10 block blue">{{ $r->role }}</span>
                            </div>
                            <div class="straight-vline absolute" style="bottom: 100%"></div>
                            <div class="straight-vline absolute" style="top: 100%"></div>
                        </div>
                        @endforeach
                        @if(!$roleusers->count())
                        <div class="flex align-center border-box" style="margin-left: 12px">
                            <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                            <p class="no-margin fs13 italic gray">There are no members acquire this role for the moment</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection