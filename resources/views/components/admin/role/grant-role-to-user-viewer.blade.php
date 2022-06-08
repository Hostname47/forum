
<div class="flex align-center pointer back-to-role-grant-to-user-selection">
    <svg class="mr4 size12" fill="#2ca0ff" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M31.7,239l136-136a23.9,23.9,0,0,1,33.8-.1l.1.1,22.6,22.6a23.91,23.91,0,0,1,.1,33.8l-.1.1L127.9,256l96.4,96.4a23.91,23.91,0,0,1,.1,33.8l-.1.1L201.7,409a23.9,23.9,0,0,1-33.8.1l-.1-.1L31.8,273a23.93,23.93,0,0,1-.26-33.84l.16-.16Z"></path></svg>
    <span class="bold blue fs12">back to role selection</span>
</div>
<div class="flex align-center space-between my8" style="padding: 0 20px">
    <div class="relative">
        <span class="fs12 bold gray absolute width-max-content" style="top: -15px; left: 0">granted role:</span>
        <h3 class="fs20 forum-color text-center no-margin" style="max-width: 160px">{{ $role->role }}</h3>
    </div>
    <div class="relative full-center" style="flex: 1; margin: 0 8px;">
        <div class="simple-line-separator full-width"></div>
        <span class="absolute fs11 gray bold" style="margin-top: -44px">grant to</span>
        <svg class="size28 absolute" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.69,169.38a27,27,0,0,1-5.88,5.8q-34.91,27.48-69.75,55.06a14.94,14.94,0,0,1-9.89,3.47c-35.2-.18-69.89-4.6-104.24-12.07-2.74-.6-3.6-1.72-3.59-4.61q.21-38.29,0-76.58c0-2.65.72-4.14,3.09-5.4,11.29-6,23-7.36,34.58-1.79,14.76,7.07,30,11.26,46.44,11.65,13.83.32,25.22,12,27.06,25.75.44,3.24-.64,3.76-3.6,3.73-17.78-.13-35.57-.07-53.36-.06-6.18,0-9.58,2.68-9.56,7.43s3.41,7.38,9.61,7.38c16.8,0,33.6-.15,50.39.07a41,41,0,0,0,28.06-10.14c6.9-5.86,13.95-11.55,21.05-17.16s15-8.07,24-6.61c6.41,1,11.74,3.82,15.61,9.14ZM94.61,40.87c-6.3.1-8.86,2.69-8.93,9.09,0,3.13-.2,6.27,0,9.38.22,2.92-.49,4.19-3.7,3.89a88,88,0,0,0-9.88,0C66,63.31,63.6,65.73,63.44,72c-.09,3.29,0,6.59,0,9.88,0,9,2,11,11.15,11,19.94,0,39.87.1,59.8-.07,3.9,0,5.94.79,7.55,4.82,9.06,22.68,31.87,35.3,56,31.43,23-3.68,41.3-23.08,43.06-45.69,2-25.31-12.1-47-35.48-54.7-22.74-7.47-47.27,1.72-60.1,22.15-2.54,4-2.47,10.5-7.18,12s-10.11.34-15.21.34c-7.69,0-7.69,0-7.69-7.68,0-14-.62-14.61-14.79-14.61C98.57,40.87,96.59,40.84,94.61,40.87Zm72.66,37a22.2,22.2,0,1,1,22.27,22.29A22.18,22.18,0,0,1,167.27,77.88ZM48.69,149c.05-3.29-.57-4.55-4.22-4.46-10.52.26-21,.07-31.58.1-6.68,0-9.25,2.58-9.26,9.24q0,35.28,0,70.58c0,6.59,2.63,9.12,9.36,9.14q12.82.06,25.66,0c7.55,0,9.93-2.39,10-10.08,0-12.34,0-24.68,0-37C48.62,174,48.51,161.53,48.69,149ZM182.17,78.39a7.31,7.31,0,1,0,7.08-7.84A7.33,7.33,0,0,0,182.17,78.39Z"/></svg>
    </div>
    <div class="flex flex-column align-center">
        <img src="{{ $user->sizedavatar(100, '-h') }}" class="size60 rounded" alt="">
        <span class="bold lblack fs11 mt4">{{ $user->username }}</span>
        @if($hr = $user->high_role())
        <span class="bold blue fs10">{{ $hr->role }}</span>
        @else
        <em class="gray fs10">normal user</em>
        @endif
    </div>
</div>
<div class="my8 section-style" style="padding: 10px">
    <span class="block mb4 bold lblack">Note</span>
    <p class="no-margin fs12 lblack lh15">Once the selected user get the role, all associated permissions (listed below) of that role will be given to that user as well; which allow him to perform all activities permitted by those permissions.</p>
</div>
<div class="flex align-center mb8">
    <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.12,231.24c2.31-3.71,3.06-8.13,5.64-11.76a36.53,36.53,0,0,1,14.13-11.94c-6-5.69-9.23-12.14-8.34-20.21a21.81,21.81,0,0,1,8-14.77,22.21,22.21,0,0,1,30,1.73c8.91,9.18,8.22,21.91-1.78,32.9,2.87,2.14,5.94,4.06,8.58,6.46,7.19,6.54,10.59,14.89,10.81,24.54.14,6.25.1,12.5.14,18.75-21.12,0-42.23-.05-63.34.06-2.81,0-4.05-.27-3.9-3.64C3.35,246,3.12,238.61,3.12,231.24Zm252.72,25.7c0-6.42.14-12.85,0-19.26-.32-11.65-5.39-20.8-15-27.44-1.46-1-3-1.93-4.51-2.92,10.06-10.85,11-23,2.57-32.36A22.2,22.2,0,0,0,209,172a21.26,21.26,0,0,0-8.41,13.48c-1.51,8.68,1.38,16,7.89,21.91-13.05,7.83-19.22,17.23-19.62,29.81-.21,6.58-.12,13.17-.17,19.75Zm-92.8,0c0-6.42.09-12.85-.09-19.27a33,33,0,0,0-13-26c-2-1.61-4.3-2.92-6.49-4.38,10.35-11,10.92-24.16,1.56-33.38a22.16,22.16,0,0,0-30.72-.32c-9.69,9.21-9.27,22.38,1.27,33.8-1.28.78-2.53,1.49-3.74,2.29-9.73,6.38-15.15,15.39-15.76,27-.36,6.73-.12,13.5-.15,20.25ZM96,77.28a87.53,87.53,0,0,1-.07,11.34c-.45,4.15,1.32,4.76,4.94,4.72,16.77-.17,33.53-.06,50.3-.08,3.77,0,8.79,1.31,11-.59,2.61-2.26.6-7.43.87-11.33,1.1-16.44-4.23-29.59-19.56-37.45C153.86,32,154.27,19,144.7,9.93A22.16,22.16,0,0,0,114,10.2c-9.3,9.07-8.77,22.19,1.61,33.66C102.06,51.07,95.58,62.15,96,77.28ZM33.4,122.86c-3.47,0-4.5,1-4.39,4.42.26,7.41.15,14.83,0,22.24,0,2.26.6,3.1,3,3.26,11.75.78,11.88.86,11.82-10.59,0-3.45.94-4.44,4.4-4.41,20.88.15,41.77.07,62.66.07,10.84,0,10.94,0,11,10.87,0,2.82.48,4,3.73,4.09,11,.13,11.14.28,11.15-10.84,0-3.16.78-4.21,4.09-4.19q35,.21,70.07,0c3.36,0,4,1.15,4.05,4.25,0,11.09.12,10.95,11.17,10.78,3.27-.06,3.75-1.34,3.69-4.12-.16-7.08-.29-14.18,0-21.25.18-3.85-1.16-4.6-4.74-4.58-25.82.14-51.65.08-77.47.08-10.66,0-10.76,0-10.76-10.63,0-3-.48-4.34-4-4.34-10.85,0-11-.17-10.9,10.6,0,3.39-.79,4.5-4.33,4.45-14-.21-28-.08-41.94-.08C61.69,122.94,47.54,123.05,33.4,122.86Z"></path></svg>
    <span class="forum-color bold">Role informations</span>
</div>

<div class="flex mb8">
    <p class="no-margin forum-color fs12 bold mr8">Role :</p>
    <div style="margin-top: -1px">
        <h4 class="no-margin fs16 bold lblack">{{ $role->role }}</h4>
        <span class="fs13 gray block" style="margin-top: -1px">{{ $role->slug }}</span>
    </div>
</div>

<p class="lblack no-margin fs13"><span class="bold forum-color fs12 mr4">Description :</span>{{ $role->description }}</p>

<div style="margin: 12px 0">
    <span class="forum-color bold fs12 mb4 block">Role permissions</span>
    <div class="section-style border-box y-auto-overflow" style="padding: 10px; margin: 2px 0 12px 0; max-height: 250px;">
        @if($role->permissions()->count())
        <div class="flex flex-wrap">
            @foreach($role->permissions->groupBy('scope') as $scope=>$permissions)
                <span class="flex bold blue fs11 my4" style="flex-basis: 100%">{{ ucfirst($scope) }}</span>
                @foreach($permissions as $permission)
                <div class="button-style-4 mb8 mr8 full-center relative">
                    <span class="permission-name fs11">{{ $permission->permission }}</span>
                    <input type="hidden" class="pid" value="{{ $permission->id }}" autocomplete="off">
                </div>
                @endforeach
            @endforeach
        </div>
        @else
        <div class="flex align-center">
            <svg class="size12 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
            <p class="fs12 no-margin gray">This role does not have any attached permission for the moment</p>
        </div>
        @endif
    </div>
</div>

<label for="grant-role-to-user-confirm-input" class="block mb4 bold forum-color">Confirmation</label>
<p class="no-margin mb4 lblack">Please type <strong>{{ auth()->user()->username }}::grant-role::{{ $role->slug }}</strong> to confirm.</p>
<div>
    <input type="text" autocomplete="off" class="full-width input-style-1" id="grant-role-to-user-confirm-input" style="padding: 8px 10px" placeholder="confirmation">
    <input type="hidden" id="grant-role-to-user-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}::grant-role::{{ $role->slug }}">
</div>
<div class="flex align-center" style="margin-top: 12px">
    <div id="grant-role-to-user-button" class="disabled-green-button-style green-button-style full-center">
        <div class="relative size14 mr4">
            <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.69,169.38a27,27,0,0,1-5.88,5.8q-34.91,27.48-69.75,55.06a14.94,14.94,0,0,1-9.89,3.47c-35.2-.18-69.89-4.6-104.24-12.07-2.74-.6-3.6-1.72-3.59-4.61q.21-38.29,0-76.58c0-2.65.72-4.14,3.09-5.4,11.29-6,23-7.36,34.58-1.79,14.76,7.07,30,11.26,46.44,11.65,13.83.32,25.22,12,27.06,25.75.44,3.24-.64,3.76-3.6,3.73-17.78-.13-35.57-.07-53.36-.06-6.18,0-9.58,2.68-9.56,7.43s3.41,7.38,9.61,7.38c16.8,0,33.6-.15,50.39.07a41,41,0,0,0,28.06-10.14c6.9-5.86,13.95-11.55,21.05-17.16s15-8.07,24-6.61c6.41,1,11.74,3.82,15.61,9.14ZM94.61,40.87c-6.3.1-8.86,2.69-8.93,9.09,0,3.13-.2,6.27,0,9.38.22,2.92-.49,4.19-3.7,3.89a88,88,0,0,0-9.88,0C66,63.31,63.6,65.73,63.44,72c-.09,3.29,0,6.59,0,9.88,0,9,2,11,11.15,11,19.94,0,39.87.1,59.8-.07,3.9,0,5.94.79,7.55,4.82,9.06,22.68,31.87,35.3,56,31.43,23-3.68,41.3-23.08,43.06-45.69,2-25.31-12.1-47-35.48-54.7-22.74-7.47-47.27,1.72-60.1,22.15-2.54,4-2.47,10.5-7.18,12s-10.11.34-15.21.34c-7.69,0-7.69,0-7.69-7.68,0-14-.62-14.61-14.79-14.61C98.57,40.87,96.59,40.84,94.61,40.87Zm72.66,37a22.2,22.2,0,1,1,22.27,22.29A22.18,22.18,0,0,1,167.27,77.88ZM48.69,149c.05-3.29-.57-4.55-4.22-4.46-10.52.26-21,.07-31.58.1-6.68,0-9.25,2.58-9.26,9.24q0,35.28,0,70.58c0,6.59,2.63,9.12,9.36,9.14q12.82.06,25.66,0c7.55,0,9.93-2.39,10-10.08,0-12.34,0-24.68,0-37C48.62,174,48.51,161.53,48.69,149ZM182.17,78.39a7.31,7.31,0,1,0,7.08-7.84A7.33,7.33,0,0,0,182.17,78.39Z"/></svg>
            <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
            </svg>
        </div>
        <span class="bold">Grant role</span>
        <input type="hidden" class="rid" value="{{ $role->id }}" autocomplete="off">
        <input type="hidden" class="uid" value="{{ $user->id }}" autocomplete="off">
    </div>
    <span class="bold no-underline forum-color pointer close-global-viewer ml8">cancel</span>
</div>