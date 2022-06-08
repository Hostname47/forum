@extends('layouts.admin')

@section('title', 'Admin - Internationalization')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.internationalization'])
@endsection

@push('scripts')
<script src="{{ asset('js/admin/internationalization.js') }}" defer></script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/internationalization.css') }}">
@endpush

@section('content')
    <div class="flex align-center space-between top-page-title-box">
        <div class="flex align-center">
            <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path d="M30.26,67.8c6.19,0,11.74.14,17.27-.07,2.36-.09,3.56.78,4.64,2.73a142.64,142.64,0,0,0,14.7,21.37c1.49,1.82,2.24,1.9,3.77,0A149.26,149.26,0,0,0,95.19,49.67H90.45c-27,0-54-.1-81,.11-3.94,0-4.86-1.13-4.52-4.73a57.27,57.27,0,0,0,0-9.8c-.23-3,.76-3.83,3.76-3.8,15.49.15,31-.05,46.49.15,3.46,0,4.83-.69,4.51-4.36s0-7.39-.11-11.08c-.06-2.08.38-3.14,2.79-3.05q6.39.25,12.79,0c2.32-.09,2.93.8,2.86,3-.14,4,.15,8-.1,11.94-.18,2.87.8,3.57,3.57,3.55,15.64-.13,31.28,0,46.92-.14,3.25,0,4.59.66,4.27,4.16a76,76,0,0,0,0,11.09c.15,2.53-.82,3-3.15,3-5,0-11-2-14.52.74-3.28,2.51-3.8,8.54-5.7,12.94A157.66,157.66,0,0,1,84,104.12c-1.85,2.17-2.11,3.35.33,5.28a141.3,141.3,0,0,0,15.89,11.42c2,1.19,2.81,2.21,1.67,4.6a106.47,106.47,0,0,0-4.64,11.41c-.81,2.41-1.56,2.71-3.78,1.34a143,143,0,0,1-21.69-15.73c-2.28-2.08-3.63-2-5.93,0A151.49,151.49,0,0,1,16,151.19c-2.92,1-4.23.8-4.79-2.59A52.33,52.33,0,0,0,8.3,138.39c-1.18-3.1,0-4.09,2.82-5a131.75,131.75,0,0,0,42.27-24.08c2.26-1.88,2.07-2.92.34-4.92A155.48,155.48,0,0,1,30.26,67.8ZM194.42,184.13q-16.95-42.42-33.91-84.85C158.78,95,158,89.07,154.77,86.91s-9.05-.51-13.71-.81c-3-.19-4.46.71-5.6,3.64-9.36,23.88-18.93,47.68-28.44,71.5-3.28,8.23-6.58,16.46-10,25,6,0,11.37-.11,16.76.05,2.23.07,3.19-.71,4-2.78,2.75-7.29,5.84-14.45,8.59-21.74.84-2.22,1.93-3,4.33-2.92,7.53.18,15.07,0,22.6.08,3.82,0,8.55-1.15,11.21.66s3.16,6.67,4.67,10.17c2.33,5.43,2.78,13.27,7.22,15.76,4.66,2.61,11.89.63,18,.65a6.8,6.8,0,0,0,.83-.18C194.83,185.15,194.62,184.64,194.42,184.13Zm-36.94-43.34c-7.15,0-13.76,0-20.36,0-2.62,0-1.79-1.34-1.24-2.73,3.32-8.27,6.61-16.55,10.26-25.7Z"/></svg>
            <h1 class="fs22 no-margin lblack">{{ __('Internationalization of website content') }}</h1>
        </div>
        <div class="flex align-center height-max-content">
            <div class="flex align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                <a href="{{ route('admin.dashboard') }}" class="link-path">{{ __('Home') }}</a>
            </div>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Internationalization') }}</span>
            </div>
        </div>
    </div>
    <div id="admin-main-content-box" style="padding-bottom: 0px">
        <h2 class="fs16 bold lblack no-margin mb4">Internationalization of multilanguages content</h2>
        <p class="lblack lh15 no-margin fs13">The following page deals with i18n of all website text content that can be translated to multiple languages.</p>
        <h2 class="fs15 bold lblack no-margin mb4">Process steps</h2>
        <p class="lblack lh15 no-margin mt4 fs13">The algorithm used here search for translatable text pieces in the given paths. You can either provide a directory path to search in every file within it, or path to a specific file.</p>
        
        <p class="lblack lh15 no-margin mt4 fs13"><strong>1.</strong> First we need to specify paths to directories or files we want to search for translatable keys in paths box.</p>
        <p class="lblack lh15 no-margin mt4 fs13"><strong>2.</strong> Then, for each selected path, we can spacify an array (0, 1 or more) of ignored directories or files within the path that we don't want to search in.</p>
        <p class="lblack lh15 no-margin mt4 fs13 ml8">e.g. <strong>paths</strong>: app/Http/Controllers . <strong>ignore</strong>: app/Http/Controllers/Admin</p>
        <p class="lblack lh15 no-margin mt4 fs13 ml8">Above statements will make the script search in controllers directory for every i18n pattern, but ignore all files within Admin directory.</p>
        <p class="lblack lh15 no-margin mt4 fs13"><strong>3.</strong> Then, we click on search for translatables button to get the search results. Results will be printed in result box section</p>
        <div class="my4 section-style">
            <p class="lblack lh15 no-margin fs13">Once we get the result we have an option that allows us to compare the returned keys with a translation file (like fr.json or ar.json) to extract only keys that we did not translate them yet.</p>
        </div>
        <h2 class="fs15 bold lblack no-margin mt8 mb4">Paths box</h2>
        <p class="fs13 lblack no-margin mb4">Specify path(s) you want to search in along with ignored path(s) within each path. When you click on search we will first verify if the path already exists in the selected paths; If so we deny the process, otherwise we will verify if the path exists in the server. (paths are <strong>case insensitive</strong>)</p>
        <div id="paths-box">
            <div class="mb8 error-container white-background relative none" style="padding: 8px;">
                <div class="close-parent x-close-container-style" style="right: 8px;">
                    <span class="x-close unselectable">✖</span>
                </div>
                <div class="flex">
                    <svg class="size12 mr4" style="min-width: 12px; margin-top: 1px" fill="rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                    <span class="error fs12 bold no-margin"></span>
                </div>
            </div>
            <div class="flex align-end">
                <div>
                    <label class="fs12 gray flex mb2" for="path-to-add-for-i18n-search">Enter paths that you want to search in. e.g. <strong class="ml4">app/Http/Controllers</strong>.</label>
                    <input type="text" id="path-to-add-for-i18n-search" class="styled-input mr4" placeholder="Enter a path to a directory or file">
                </div>
                <div id="add-path-to-i18n-paths-box" class="typical-button-style flex">
                    <div class="relative size14 mr4">
                        <svg class="size12 mt2 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="512px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M256,512C114.625,512,0,397.391,0,256C0,114.609,114.625,0,256,0c141.391,0,256,114.609,256,256  C512,397.391,397.391,512,256,512z M256,64C149.969,64,64,149.969,64,256s85.969,192,192,192c106.047,0,192-85.969,192-192  S362.047,64,256,64z M288,384h-64v-96h-96v-64h96v-96h64v96h96v64h-96V384z"/></svg>
                        <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="bold fs12 no-wrap block unselectable" style="margin-top: 1px">{{ __('Add path') }}</span>
                        <span class="fs10 no-wrap block unselectable">verify and add</span>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="fs14 bold lblack no-margin mt8 mb4">Specified paths</h3>
                <div id="added-paths-section" class="section-style">
                    <div id="paths-selected-for-i18n-search">
                        @foreach($paths as $path)
                        <div class="path-selected-for-i18n-search mb8 section-style white-background relative">
                            <p class="no-margin lblack fs13"><strong>path</strong> : root/<strong class="path blue">{{ $path['path'] }}</strong></p>
                            <div class="flex paths-to-exclude-box">
                                <svg class="size10 mr4" style="margin-top: 1px; margin-left: 33px;" fill="#d2d2d2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"></polygon></svg>
                                <div class="toggle-box full-width">
                                    <div class="flex align-center mt4 pointer toggle-container-button">
                                        <span class="fs11 lblack mr4">ignore sub files and directories</span>
                                        <svg class="toggle-arrow size5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02"><path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"></path></svg>
                                    </div>
                                    <div class="toggle-container paths-to-exclude-container mt4">
                                        <p class="gray fs11 my2">The ignored paths should be nested inside the selected path.</p>
                                        <div class="flex align-center">
                                            <p class="gray bold fs11 no-wrap no-margin mr4">root/<span class="path-text">{{ $path['path'] }}</span>/</p>
                                            <input type="text" class="styled-input ignore-path-input fs11" placeholder="path of directory or file to be ignored" autocomplete="off" style="padding: 5px 8px;">
                                            <div class="add-ignored-path typical-button-style flex align-center width-max-content" style="height: 11px; margin-left: -4px; border-radius: 0 3px 3px 0">
                                                <span class="fs10 bold no-wrap flex unselectable">✖ ignore path</span>
                                            </div>
                                        </div>

                                        <div class="paths-to-exclude" style="margin-left: 20px;">
                                            <span class="fs10 bold gray flex my4">ignored paths :</span>
                                            @foreach($path['ignoredpaths'] as $ignoredpath)
                                            <div class="relative flex path-to-ignore my4">
                                                <span class="x-close unselectable mr8 remove-parent pointer" style="color: #ff3030;">✖</span>
                                                <p class="fs11 bold lblack no-margin path-to-ignore-text">{{ $ignoredpath }}</p>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="remove-selected-path-for-i18n-search x-close-container-style" style="right: -8px; top: -8px;">
                                <span class="x-close unselectable">✖</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div id="no-paths-selected-for-i18n-search" class="flex align-center none">
                        <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <p class="lblack fs12 no-margin">no paths are selected for i18n search yet</p>
                    </div>
                    <!-- skeleton for paths adding -->
                    <div class="path-selected-for-i18n-search-skeleton path-selected-for-i18n-search mb8 section-style white-background relative none">
                        <p class="no-margin lblack fs13"><strong>path</strong> : root/<strong class="path blue"></strong></p>
                        <div class="flex paths-to-exclude-box none">
                            <svg class="size10 mr4" style="margin-top: 1px; margin-left: 33px;" fill="#d2d2d2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"></polygon></svg>
                            <div class="toggle-box full-width">
                                <div class="flex align-center mt4 pointer toggle-container-button">
                                    <span class="fs11 lblack mr4">ignore sub files and directories</span>
                                    <svg class="toggle-arrow size5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02"><path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"></path></svg>
                                </div>
                                <div class="toggle-container paths-to-exclude-container mt4">
                                    <p class="gray fs11 my2">The ignored paths should be nested inside the selected path.</p>
                                    <div class="flex align-center">
                                        <p class="gray bold fs11 no-wrap no-margin mr4">root/<span class="path-text"></span>/</p>
                                        <input type="text" class="styled-input ignore-path-input fs11" placeholder="path of directory or file to be ignored" autocomplete="off" style="padding: 5px 8px;">
                                        <div class="add-ignored-path typical-button-style flex align-center width-max-content" style="height: 11px; margin-left: -4px; border-radius: 0 3px 3px 0">
                                            <span class="fs10 bold no-wrap flex unselectable">✖ ignore path</span>
                                        </div>
                                    </div>

                                    <div class="paths-to-exclude" style="margin-left: 20px;">
                                        <span class="fs10 bold gray flex my4">ignored paths :</span>
                                        <!-- here will be placed ignored paths -->
                                    </div>
                                    <div class="relative flex path-to-ignore-skeleton path-to-ignore my4 none">
                                        <span class="x-close unselectable mr8 remove-parent pointer" style="color: #ff3030;">✖</span>
                                        <p class="fs11 bold lblack no-margin path-to-ignore-text"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="remove-selected-path-for-i18n-search x-close-container-style" style="right: -8px; top: -8px;">
                            <span class="x-close unselectable">✖</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- search button -->
        <div id="search-for-i18n-keys-within-paths" class="typical-button-style flex width-max-content my8">
            <div class="relative size12 mr4 mt2">
                <svg class="size12 icon-above-spinner flex" fill="white" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"></path></svg>
                <svg class="spinner size12 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                </svg>
            </div>
            <span class="fs12 no-wrap block unselectable">Search for i18n keys within paths</span>
        </div>
        <div class="simple-line-separator" style="margin: 14px 0"></div>
        <h2 class="fs15 bold lblack no-margin mt8 mb4">Keys returned from search</h2>
        <p class="fs13 lblack no-margin mb4 lh15">The following section shows the keys (translatable text keys) that needs to be translated. However, before think to add those keys to language files you need to compare those keys with the existing ones, so that you end up with only keys that are not translated yet.</p>
        <div class="section-style my8 flex">
            <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
            <p class="no-margin bold lblack fs12">Please compare the result with one of your language files before copying, in order to prevent duplicate entries</p>
        </div>
        <div id="i18n-keys-search-results-container">
            <p class="no-margin fs11 bold lblack">The result keys will be displayed in JSON format to make it easier to past the result to language file</p>
            <div class="relative mt4" style="padding-top: 28px;">
                <div id="i18n-keys-results-ops-container">
                    <p class="fs11 no-margin bold white">keys: <span id="i18n-keys-count" class="blue fs14">0</span> found</p>
                    <div class="white mx8 mt2 fs8 unselectable">•</div>
                    <div id="copy-i18n-result-keys" class="wtypical-button-style flex align-center" style="padding: 3px 7px;">
                        <svg class="size10 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352.8 352.8"><path d="M318.54,57.28H270.89V15a15,15,0,0,0-15-15H34.26a15,15,0,0,0-15,15V280.52a15,15,0,0,0,15,15H81.92V337.8a15,15,0,0,0,15,15H318.54a15,15,0,0,0,15-15V72.28A15,15,0,0,0,318.54,57.28ZM49.26,265.52V30H240.89V57.28h-144a15,15,0,0,0-15,15V265.52ZM303.54,322.8H111.92V87.28H303.54Z"></path></svg>
                        <span class="fs10 bold unselectable">copy keys</span>
                    </div>
                    <div class="white mx8 mt2 fs8 unselectable">•</div>
                    <div id="clean-i18n-results" class="wtypical-button-style flex align-center" style="padding: 3px 7px;">
                        <svg class="size10 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.22,214.12a4.7,4.7,0,0,1,4.22-4.69c12.34-1.16,23.78-11.69,25.38-24.57.43-3.47,1.27-5,5-4.58,3.08.37,6.61-.72,9.26.42,2.87,1.25,1.36,5.3,2.31,8,4.13,11.79,12.09,19,24.46,20.77,3,.45,4.58,1.24,4,4.47a6.53,6.53,0,0,0,0,1c0,3,.73,6.27-.35,8.78-1.18,2.72-5,1.3-7.59,2.16-12.24,4.07-19.57,12.2-21.33,25-.36,2.6-1,4-3.87,3.58a10.41,10.41,0,0,0-1.48,0c-3,0-6.26.73-8.78-.35-2.72-1.18-1.4-5-2.2-7.58-3.62-11.73-13.56-20.11-24.9-21.22a4.67,4.67,0,0,1-4.14-4.68Zm85.73-11c9.07,19.26,23.66,31.67,44.88,35.55,2.65.49,3.85,1.41,3.31,4.07-.86,4.27,1.28,5.9,5.15,7.11,27.62,8.63,56.87-.32,74.69-23.28,6.78-8.72,11.91-18.47,16.91-28.31,1.77-3.48.7-4.29-2.31-5.37q-44.46-16-88.84-32.34c-3.22-1.19-4.3-.54-5.78,2.41-6.78,13.57-17.81,21.47-32.82,24.13-7.29,1.3-14.41-.75-22.39-.38C83.34,192.66,85.52,198,88,203.13Zm56.59-62.94c-1.47,3.76-1.3,5.53,3,7,12.45,4.16,24.72,8.85,37.05,13.34,17.43,6.35,34.84,12.73,52.29,19,1.16.41,3,2.48,4-.29,2-5.38,4.24-10.69,3-16.71-2-9.76-8.1-15.59-17.35-18.22-3.64-1-5.5-2.74-5.77-6.63a14.74,14.74,0,0,0-4.64-9.59c-2.47-2.34-2.44-4.38-1.33-7.34q18.66-50.06,37.11-100.2c3.4-9.18,3.31-8.92-5.47-12.57-4.38-1.81-5.67-.53-7.16,3.57C226.62,46.38,213.67,81.14,200.92,116c-1,2.78-2.28,4.31-5.43,4.48a15.76,15.76,0,0,0-10.56,4.81c-2.4,2.49-4.53,2.44-7.37,1.18-3.61-1.6-7.38-2.79-9.95-2.81C156.3,123.68,148.63,129.76,144.54,140.19ZM121.36,124.1c.21-2.28-.71-3-3-3.4C102.68,118.09,95,110.37,92,94c-.63-3.48-2.94-2.94-4.68-2.49-3.54.9-9.42-3.16-10.45,2.41C74,109.49,65.48,118.57,49.81,120.77c-4.58.64-2.75,4.22-2.42,6.11.53,3.06-3.17,7.89,2.34,9.1,16.85,3.7,23.69,10.18,26.79,26.92.64,3.43,2.9,3,4.68,2.53,3.54-.92,8.22,3,10.68-2.42a3.8,3.8,0,0,0,.11-1c2.06-14.33,11.52-23.79,26.2-25.83,2.6-.37,3.41-1.32,3.17-3.73-.13-1.3,0-2.63,0-3.94C121.34,127.06,121.23,125.57,121.36,124.1Z"/></svg>
                        <span class="fs10 bold unselectable">clean results</span>
                    </div>

                    <div class="flex align-center move-to-right">
                        <div id="search-for-db-i18n-keys" class="wtypical-button-style flex align-center" style="padding: 3px 7px;">
                            <div class="relative size10 mr4">
                                <svg class="size10 icon-above-spinner flex" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 95.1 95.1"><path d="M47.56,0C25.93,0,8.39,6.39,8.39,14.28V26c0,7.89,17.54,14.28,39.17,14.28S86.73,33.89,86.73,26V14.28C86.73,6.39,69.19,0,47.56,0Zm0,47.12c-17.53,0-32.45-4.21-37.47-10a1,1,0,0,0-1.73.65c0,5.65,0,15.47,0,15.47,0,7.9,17.54,14.29,39.17,14.29s39.17-6.4,39.17-14.29c0,0,0-9.82,0-15.48A1,1,0,0,0,85,37.12C80,42.91,65.09,47.12,47.56,47.12ZM86.7,65.38A1,1,0,0,0,85,64.73c-5,5.77-19.91,10-37.41,10s-32.39-4.19-37.44-10a1,1,0,0,0-1.73.65V80.82c0,7.89,17.54,14.28,39.17,14.28s39.17-6.39,39.17-14.28Z"/></svg>
                                <svg class="spinner size10 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                </svg>
                            </div>
                            <span class="fs10 bold unselectable">get database entries</span>
                        </div>
                        <div class="white mx8 mt2 fs8 unselectable">•</div>
                        <div class="relative">
                            <div id="clean-i18n-results" class="wtypical-button-style flex align-center button-with-suboptions" style="padding: 3px 7px;">
                                <span class="fs10 bold unselectable mr4">language file compare</span>
                                <svg class="size7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"></path></svg>
                            </div>
                            <div class="suboptions-container typical-suboptions-container" style="right: 0; width: max-content; max-width: 200px;">
                                <div class="typical-suboption compare-i18n-keys-with-lang-file">
                                    <input type="hidden" class="lang" value="ar" autocomplete="off">
                                    <div class="flex align-center">
                                        <svg version="1.1" class="size12 mr4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 100.06" style="enable-background:new 0 0 122.88 100.06" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style><g><path class="st0" d="M6.38,0h110.11c3.51,0,6.39,2.87,6.39,6.38v87.29c0,3.51-2.87,6.38-6.39,6.38H6.38 c-3.51,0-6.38-2.87-6.38-6.38V6.38C0,2.87,2.87,0,6.38,0L6.38,0z M48.87,62.51H35.84l-1.87,6.13H22.24l14.01-37.21h12.59 l13.95,37.21H50.73L48.87,62.51L48.87,62.51z M46.44,54.45l-4.06-13.37L38.3,54.45H46.44L46.44,54.45z M64.05,68.64V31.43h19.16 c3.55,0,6.27,0.3,8.14,0.92c1.88,0.61,3.4,1.74,4.55,3.39c1.15,1.65,1.72,3.67,1.72,6.05c0,2.06-0.44,3.85-1.33,5.34 c-0.87,1.51-2.09,2.72-3.64,3.66c-0.98,0.59-2.33,1.08-4.04,1.47c1.37,0.46,2.36,0.91,2.99,1.37c0.42,0.3,1.03,0.96,1.84,1.96 c0.8,1,1.33,1.77,1.6,2.31l5.59,10.75H87.65l-6.14-11.35c-0.78-1.47-1.47-2.43-2.08-2.87c-0.83-0.57-1.78-0.86-2.82-0.86h-1.01 v15.07H64.05L64.05,68.64z M75.59,46.55h4.86c0.52,0,1.54-0.17,3.05-0.51c0.76-0.15,1.39-0.54,1.86-1.17 c0.49-0.63,0.73-1.35,0.73-2.17c0-1.2-0.38-2.13-1.14-2.77c-0.76-0.65-2.19-0.97-4.3-0.97h-5.06V46.55L75.59,46.55z"/></g></svg>
                                        <h4 class="no-margin fs13 lblack">Arabic version</h4>
                                        <svg class="spinner size12 opacity0 ml4" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                    <p class="fs11 no-margin gray">This will exclude all already existing keys <strong>arabic language file -ar.json- file</strong> and keep only untranslatable keys</p>
                                </div>
                                <div class="typical-suboption compare-i18n-keys-with-lang-file">
                                    <input type="hidden" class="lang" value="fr" autocomplete="off">
                                    <div class="flex align-center">
                                        <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 480"><g fill-rule="evenodd" stroke-width="1pt"><path fill="#fff" d="M0 0h640v480H0z"/><path fill="#002654" d="M0 0h213.3v480H0z"/><path fill="#ce1126" d="M426.7 0H640v480H426.7z"/></g></svg>
                                        <h4 class="no-margin fs13 lblack">French version</h4>
                                        <svg class="spinner size12 opacity0 ml4" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                    <p class="fs11 no-margin gray">This will exclude all already existing keys <strong>french language file -fr.json- file</strong> and keep only untranslatable keys</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <textarea id="i18n-keys-results-area" class="styled-input relative" style="border-radius: 0 0 3px 3px;" autocomplete="off" readonly placeholder="Your search keys will be displayed here.."></textarea>
            </div>
        </div>
    </div>
    <div style="height: 200px;"></div>
@endsection