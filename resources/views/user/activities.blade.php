@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/activities.js') }}" defer></script>
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'user', 'subpage'=>'user.activities'])
    <div id="middle-container" class="middle-padding-1">
        <input type="hidden" class="activities-user" value="{{ $user->id }}">
        <div class="flex">
            <div class="full-width">
                @include('partials.user-space.basic-header', ['page'=>'activities'])
                <div class="flex align-end space-between my8">
                    <div>
                        @if($is_current)
                        <h1 class="no-margin fs20">{{__('My Activities')}}</h1>
                        @else
                        <h1 class="no-margin fs20">{{ $user->username }} - {{__('activities')}}</h1>
                        @endif
                    </div>
                    @if(auth()->user() && auth()->user()->id == $user->id)
                    <div class="move-to-right flex align-center relative mr8">
                        <!-- this button will be displayed only to other users and not to the activities profile owner -->
                        <svg class="size15 pointer button-with-suboptions" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <div class="suboptions-container simple-information-suboptions-container" style="width: 480px; top: calc(100% + 3px);">
                            <!-- container closer -->
                            <div class="closer-style fill-opacity-style hide-parent">
                                <svg class="size17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm0,448A200,200,0,1,1,456,256,199.94,199.94,0,0,1,256,456ZM357.8,193.8,295.6,256l62.2,62.2a12,12,0,0,1,0,17l-22.6,22.6a12,12,0,0,1-17,0L256,295.6l-62.2,62.2a12,12,0,0,1-17,0l-22.6-22.6a12,12,0,0,1,0-17L216.4,256l-62.2-62.2a12,12,0,0,1,0-17l22.6-22.6a12,12,0,0,1,17,0L256,216.4l62.2-62.2a12,12,0,0,1,17,0l22.6,22.6a12,12,0,0,1,0,17Z"/></svg>
                            </div>
                            <div class="flex mb4">
                                <svg class="size4 mr8" style="margin-top: 6px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 29.11 29.11"><image width="30" height="30" transform="translate(0 -0.89)" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsSAAALEgHS3X78AAAAp0lEQVRIS+2XQRaAIAhEB+5/Z1pRhmj2Etj0d/pyvsMqSUTwBiLqDogIed/OoBWxJ5uxcpGp+K3QMruAK/4qbBnJ2W7slALjvJt4t1Txck9xlFSx+d2oI2nlbDeySG0MXCW5oi1Q0FgpExOAf9Qp/OIURIRKxEBRYwDglf+jCNIba1FuF9G0nvTGyimObm3zb42j5F5uN+rd8lFe2EviqcD2t9OTUDkArQVWIcCC1LoAAAAASUVORK5CYII="/></svg>
                                <p class="no-margin fs12 lblack">{{ __('Private posts will not be displayed in any section') }}.</p>
                            </div>
                            <div class="flex">
                                <svg class="size4 mr8" style="margin-top: 6px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 29.11 29.11"><image width="30" height="30" transform="translate(0 -0.89)" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsSAAALEgHS3X78AAAAp0lEQVRIS+2XQRaAIAhEB+5/Z1pRhmj2Etj0d/pyvsMqSUTwBiLqDogIed/OoBWxJ5uxcpGp+K3QMruAK/4qbBnJ2W7slALjvJt4t1Txck9xlFSx+d2oI2nlbDeySG0MXCW5oi1Q0FgpExOAf9Qp/OIURIRKxEBRYwDglf+jCNIba1FuF9G0nvTGyimObm3zb42j5F5uN+rd8lFe2EviqcD2t9OTUDkArQVWIcCC1LoAAAAASUVORK5CYII="/></svg>
                                <p class="no-margin fs12 lblack">{{ __('Followers only posts will not be displayed in any section as well') }}.</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="activities-sections-container">
                    <div class="activities-sections-header-container flex x-auto-overflow">
                        <div class="flex inline-buttons-container activities-sections-header">
                            <div class="inline-button-style align-center selected-inline-button-style activity-section-switcher" style="border-top-left-radius: 4px">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M492.21,3.82a21.45,21.45,0,0,0-22.79-1l-448,256a21.34,21.34,0,0,0,3.84,38.77L171.77,346.4l9.6,145.67a21.3,21.3,0,0,0,15.48,19.12,22,22,0,0,0,5.81.81,21.37,21.37,0,0,0,17.41-9l80.51-113.67,108.68,36.23a21,21,0,0,0,6.74,1.11,21.39,21.39,0,0,0,21.06-17.84l64-384A21.31,21.31,0,0,0,492.21,3.82ZM184.55,305.7,84,272.18,367.7,110.06ZM220,429.28,215.5,361l42.8,14.28Zm179.08-52.07-170-56.67L447.38,87.4Z"/></svg>
                                {{ __('Posts') }}
                                <input type="hidden" class="activity-section-name" value="threads">
                            </div>
                            @if(auth()->user() && auth()->user()->id == $user->id)
                            <div class="inline-button-style align-center activity-section-switcher">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M400,0H112A48,48,0,0,0,64,48V512L256,400,448,512V48A48,48,0,0,0,400,0Zm0,428.43-144-84-144,84V54a6,6,0,0,1,6-6H394a6,6,0,0,1,6,6Z"/></svg>
                                {{ __('Saved posts') }}
                                <input type="hidden" class="activity-section-name" value="saved-threads">
                            </div>
                            @endif
                            <div class="inline-button-style align-center activity-section-switcher">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M458.4,64.3C400.6,15.7,311.3,23,256,79.3,200.7,23,111.4,15.6,53.6,64.3-21.6,127.6-10.6,230.8,43,285.5L218.4,464.2a52.52,52.52,0,0,0,75.2.1L469,285.6C522.5,230.9,533.7,127.7,458.4,64.3ZM434.8,251.8,259.4,430.5c-2.4,2.4-4.4,2.4-6.8,0L77.2,251.8c-36.5-37.2-43.9-107.6,7.3-150.7,38.9-32.7,98.9-27.8,136.5,10.5l35,35.7,35-35.7c37.8-38.5,97.8-43.2,136.5-10.6,51.1,43.1,43.5,113.9,7.3,150.8Z"/></svg>
                                @if(auth()->user() && auth()->user()->id == $user->id)
                                {{ __('Posts I liked') }}
                                @else
                                {{ __('Liked posts') }}
                                @endif
                                <input type="hidden" class="activity-section-name" value="liked-threads">
                            </div>
                            <div class="inline-button-style align-center activity-section-switcher">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                                @if(auth()->user() && auth()->user()->id == $user->id)
                                {{ __('Posts I replied on') }}
                                @else
                                {{ __('Posts replied on') }}
                                @endif
                                <input type="hidden" class="activity-section-name" value="replied-threads">
                            </div>
                            <div class="inline-button-style align-center activity-section-switcher">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M287.81,219.72h-238c-21.4,0-32.1-30.07-17-47.61l119-138.2c9.4-10.91,24.6-10.91,33.9,0l119,138.2C319.91,189.65,309.21,219.72,287.81,219.72ZM224.22,292l238,.56c21.4,0,32,30.26,16.92,47.83L359.89,478.86c-9.41,10.93-24.61,10.9-33.9-.08l-118.75-139C192.07,322.15,202.82,292,224.22,292Z" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:49px"/></svg>
                                @if(auth()->user() && auth()->user()->id == $user->id)
                                {{ __('Posts I voted on') }}
                                @else
                                {{ __('Voted posts') }}
                                @endif
                                <input type="hidden" class="activity-section-name" value="voted-threads">
                            </div>
                            @if(auth()->user() && auth()->user()->id == $user->id)
                            <div class="inline-button-style align-center activity-section-switcher">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 331.53 331.53"><path d="M197.07,216.42a11,11,0,0,1-11,11H145.46a11,11,0,0,1,0-22h40.61A11,11,0,0,1,197.07,216.42ZM331.53,51.9v68.32a11,11,0,0,1-11,11H313.4V279.63a11,11,0,0,1-11,11H29.13a11,11,0,0,1-11-11V131.22H11a11,11,0,0,1-11-11V51.9a11,11,0,0,1,11-11H320.53A11,11,0,0,1,331.53,51.9ZM291.4,131.22H221.24a56.55,56.55,0,0,1-110.94,0H40.13V268.63H291.4ZM165.77,154.77a34.61,34.61,0,0,0,32.75-23.55H133A34.6,34.6,0,0,0,165.77,154.77ZM309.53,62.9H22v46.32H309.53Z"/></svg>
                                {{ __('Archive') }}
                                <input type="hidden" class="activity-section-name" value="archived-threads">
                            </div>
                            @endif
                            @if(auth()->user() && auth()->user()->id == $user->id)
                            <div class="inline-button-style align-center activity-section-switcher">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M48,48A48,48,0,1,0,96,96,48,48,0,0,0,48,48Zm0,160a48,48,0,1,0,48,48A48,48,0,0,0,48,208Zm0,160a48,48,0,1,0,48,48A48,48,0,0,0,48,368Zm448,16H176a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V400A16,16,0,0,0,496,384Zm0-320H176a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V80A16,16,0,0,0,496,64Zm0,160H176a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V240A16,16,0,0,0,496,224Z"/></svg>
                                {{ __('Activity log') }}
                                <input type="hidden" class="activity-section-name" value="activity-log">
                            </div>
                            @endif
                        </div>
                    </div>
                    <div id="activities-sections-content" class="relative">
                        <div id="activities-sections-loading-container" class="none full-center">
                            <div class="flex flex-column align-center">
                                <svg class="size24 spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                </svg>
                                <p class="bold">{{ __('Please wait') }}</p>
                            </div>
                        </div>
                        <x-activities.sections.threads :user="$user" :data="['threadscount'=>$userthreadscount]"/>
                    </div>
                </div>
            </div>
            <div id="right-panel">
                <x-user.right-panel-user-card :user="$user" withcover="true" :data="['threadscount'=>$userthreadscount]"/>
            </div>
        </div>
    </div>
@endsection