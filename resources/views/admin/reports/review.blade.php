@extends('layouts.admin')

@section('title', 'Admin - Reportings')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.reports.review'])
@endsection

@push('scripts')
<script src="{{ asset('js/admin/reports/report.js') }}" defer></script>
@endpush

@section('content')
    <style>
        table {
            border-collapse: collapse;
            box-sizing: border-box;
        }

        table td, table th {
            border: 1px solid #a6a6a6;
            padding: 8px;
        }

        table td {
            vertical-align: top;
        }

        #thread-media-viewer {
            z-index: 58888;
        }

        table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #eee;
        }

        #thread-col {
            width: 100%;
        }

        #resource-type-col {
            min-width: 114px;
        }

        #ops-col {
            min-width: 140px; 
        }

        #rtype-col {
            min-width: 120px;
        }

        #reporter-col {
            min-width: 140px;
        }

        .button-with-left-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            padding: 3px;
            border-radius: 4px;
            background-color: #f0f0f0;
            border: 1px solid #cecece;
            transition: background-color 0.2s ease;
        }

        .button-with-left-icon:hover {
            background-color: #e8e8e8;
        }
    </style>
    <div class="flex align-center space-between top-page-title-box">
        <div class="flex align-center">
            <svg class="size17 mr8" style="fill: #1d1d1d" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M349.57,98.78C296,98.78,251.72,64,184.35,64a194.36,194.36,0,0,0-68,12A56,56,0,1,0,32,101.94V488a24,24,0,0,0,24,24H72a24,24,0,0,0,24-24V393.6c28.31-12.06,63.58-22.12,114.43-22.12,53.59,0,97.85,34.78,165.22,34.78,48.17,0,86.67-16.29,122.51-40.86A31.94,31.94,0,0,0,512,339.05V96a32,32,0,0,0-45.48-29C432.18,82.88,390.06,98.78,349.57,98.78Z"/></svg>
            <h1 class="fs22 no-margin lblack">{{ __('Review Reported Resources') }}</h1>
        </div>
        <div class="flex align-center height-max-content">
            <div class="flex align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                <a href="{{ route('admin.dashboard') }}" class="link-path">{{ __('Home') }}</a>
            </div>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Review reportings') }}</span>
            </div>
        </div>
    </div>
    <div id="admin-main-content-box">
        <!-- renders -->
        @include('partials.admin.thread.thread-render')
        @include('partials.admin.post.post-render')
        <!-- view all reports of a resource viewer -->
        <div id="view-resource-other-reports" class="global-viewer full-center none">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div class="global-viewer-content-box viewer-box-style-1" style="width: 730px;">        
                <input type="hidden" id="report-id" autocomplete="off">
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                    <span class="fs18 bold forum-color flex align-center">
                        <svg class="size16 mr8" style="fill: #1d1d1d" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M349.57,98.78C296,98.78,251.72,64,184.35,64a194.36,194.36,0,0,0-68,12A56,56,0,1,0,32,101.94V488a24,24,0,0,0,24,24H72a24,24,0,0,0,24-24V393.6c28.31-12.06,63.58-22.12,114.43-22.12,53.59,0,97.85,34.78,165.22,34.78,48.17,0,86.67-16.29,122.51-40.86A31.94,31.94,0,0,0,512,339.05V96a32,32,0,0,0-45.48-29C432.18,82.88,390.06,98.78,349.57,98.78Z"/></svg>
                        {{ __('All Thread Reports') }}
                    </span>
                    <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div id="fetch-more-resource-reports-box" class="y-auto-overflow border-box" style="max-height: 400px; padding: 14px;">
                    <table>
                        <style>
                            table th {
                                font-size: 12px;
                            }
                        </style>
                        <thead>
                            <tr class="thread-reports-table-header">
                                <th id="reporter-col" style="min-width: 160px">Reported by</th>
                                <th id="rtype-col">Report Type</th>
                                <th id="rtype-col" class="full-width">Body</th>
                                <th>Reviewed</th>
                            </tr>
                        </thead>
                        <tbody id="other-reports-content">

                        </tbody>
                        <tfoot id="fetch-more-resource-reports" class="none no-fetch">
                            <tr>
                                <td colspan="4">
                                    <div class="full-center">
                                        <svg class="spinner size20" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- view reporting body when type is moderator intervention -->
        <div id="reporting-body-viewer" class="global-viewer full-center none">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div class="viewer-box-style-1">        
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                    <span class="fs18 bold forum-color flex align-center">
                        <svg class="size16 mr8" style="fill: #1d1d1d" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M349.57,98.78C296,98.78,251.72,64,184.35,64a194.36,194.36,0,0,0-68,12A56,56,0,1,0,32,101.94V488a24,24,0,0,0,24,24H72a24,24,0,0,0,24-24V393.6c28.31-12.06,63.58-22.12,114.43-22.12,53.59,0,97.85,34.78,165.22,34.78,48.17,0,86.67-16.29,122.51-40.86A31.94,31.94,0,0,0,512,339.05V96a32,32,0,0,0-45.48-29C432.18,82.88,390.06,98.78,349.57,98.78Z"/></svg>
                        {{ __('View reporting body') }}
                    </span>
                    <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div class="full-center relative">
                    <div class="global-viewer-content-box full-dimensions y-auto-overflow" style="padding: 14px; min-height: 200px; max-height: 450px">
                        
                    </div>
                    <div class="loading-box full-center absolute" style="margin-top: -20px">
                        <svg class="loading-spinner size28 black" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <!-- thread render viewer -->
        <div id="thread-render-viewer" class="global-viewer full-center none" style="z-index: 55555">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div class="global-viewer-content-box viewer-box-style-2" style="margin-top: -26px; max-height: 90%; width: 580px; overflow-y: scroll">        
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                    <span class="fs18 bold forum-color flex align-center">
                        <svg class="size16 mr8" style="fill: #1d1d1d" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M349.57,98.78C296,98.78,251.72,64,184.35,64a194.36,194.36,0,0,0-68,12A56,56,0,1,0,32,101.94V488a24,24,0,0,0,24,24H72a24,24,0,0,0,24-24V393.6c28.31-12.06,63.58-22.12,114.43-22.12,53.59,0,97.85,34.78,165.22,34.78,48.17,0,86.67-16.29,122.51-40.86A31.94,31.94,0,0,0,512,339.05V96a32,32,0,0,0-45.48-29C432.18,82.88,390.06,98.78,349.57,98.78Z"/></svg>
                        {{ __('Thread Review') }}
                        <div class="fs8 mx8 gray unselectable">•</div>
                        <a href="" target="_blank" class="manage-link button-with-left-icon width-max-content no-underline bold lblack fs11" style="padding: 3px 8px">
                            <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 174.25 174.25"><path d="M173.15,73.91A7.47,7.47,0,0,0,168.26,68l-13.72-4.88a70.76,70.76,0,0,0-2.76-6.7L158,43.27a7.47,7.47,0,0,0-.73-7.63A87.22,87.22,0,0,0,138.6,17a7.45,7.45,0,0,0-7.62-.72l-13.14,6.24a70.71,70.71,0,0,0-6.7-2.75L106.25,6a7.46,7.46,0,0,0-5.9-4.88,79.34,79.34,0,0,0-26.45,0A7.45,7.45,0,0,0,68,6L63.11,19.72a70.71,70.71,0,0,0-6.7,2.75L43.27,16.23a7.47,7.47,0,0,0-7.63.72A87.17,87.17,0,0,0,17,35.64a7.47,7.47,0,0,0-.73,7.63l6.24,13.15a70.71,70.71,0,0,0-2.75,6.7L6,68A7.47,7.47,0,0,0,1.1,73.91,86.15,86.15,0,0,0,0,87.13a86.25,86.25,0,0,0,1.1,13.22A7.47,7.47,0,0,0,6,106.26l13.73,4.88a72.06,72.06,0,0,0,2.76,6.71L16.22,131a7.47,7.47,0,0,0,.72,7.62,87.08,87.08,0,0,0,18.71,18.7,7.42,7.42,0,0,0,7.62.72l13.14-6.24a70.71,70.71,0,0,0,6.7,2.75L68,168.27a7.45,7.45,0,0,0,5.9,4.88,86.81,86.81,0,0,0,13.22,1.1,86.94,86.94,0,0,0,13.23-1.1,7.46,7.46,0,0,0,5.9-4.88l4.88-13.73a69.83,69.83,0,0,0,6.71-2.75L131,158a7.42,7.42,0,0,0,7.62-.72,87.26,87.26,0,0,0,18.7-18.7A7.45,7.45,0,0,0,158,131l-6.25-13.14q1.53-3.25,2.76-6.71l13.72-4.88a7.46,7.46,0,0,0,4.88-5.91,86.25,86.25,0,0,0,1.1-13.22A87.44,87.44,0,0,0,173.15,73.91ZM159,93.72,146.07,98.3a7.48,7.48,0,0,0-4.66,4.92,56,56,0,0,1-4.5,10.94,7.44,7.44,0,0,0-.19,6.78l5.84,12.29a72.22,72.22,0,0,1-9.34,9.33l-12.28-5.83a7.42,7.42,0,0,0-6.77.18,56.13,56.13,0,0,1-11,4.5,7.46,7.46,0,0,0-4.91,4.66L93.71,159a60.5,60.5,0,0,1-13.18,0L76,146.07A7.48,7.48,0,0,0,71,141.41a56.29,56.29,0,0,1-11-4.5,7.39,7.39,0,0,0-6.77-.18L41,142.56a72.14,72.14,0,0,1-9.33-9.33l5.84-12.29a7.5,7.5,0,0,0-.19-6.78,56.31,56.31,0,0,1-4.5-10.94,7.48,7.48,0,0,0-4.66-4.92L15.3,93.72a60.5,60.5,0,0,1,0-13.18L28.18,76A7.48,7.48,0,0,0,32.84,71a56.29,56.29,0,0,1,4.5-11,7.48,7.48,0,0,0,.19-6.77L31.69,41A72.22,72.22,0,0,1,41,31.69l12.29,5.84a7.44,7.44,0,0,0,6.78-.18A56,56,0,0,1,71,32.85,7.5,7.5,0,0,0,76,28.19l4.58-12.88a59.27,59.27,0,0,1,13.18,0L98.3,28.19a7.49,7.49,0,0,0,4.91,4.66,56.13,56.13,0,0,1,11,4.5,7.42,7.42,0,0,0,6.77.18l12.28-5.84A72.93,72.93,0,0,1,142.56,41l-5.84,12.29a7.42,7.42,0,0,0,.19,6.77,56.81,56.81,0,0,1,4.5,11A7.48,7.48,0,0,0,146.07,76L159,80.54a60.5,60.5,0,0,1,0,13.18ZM87.12,50.8a34.57,34.57,0,1,0,34.57,34.57A34.61,34.61,0,0,0,87.12,50.8Zm0,54.21a19.64,19.64,0,1,1,19.64-19.64A19.66,19.66,0,0,1,87.12,105Z" style="stroke:#fff;stroke-miterlimit:10"/></svg>
                            <span>manage</span>
                        </a>
                    </span>
                    <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                </div>
                <style>
                    #thread-render-box .thread-container-box {
                        border-bottom: 1px solid #b7c0c6;
                    }
                </style>
                <div id="thread-render-box" style="padding: 14px;">
                    
                </div>
            </div>
        </div>

        <div>
            <div class="flex space-between align-end mb8">
                <div>
                    <h2 class="no-margin fs24 forum-color bold">{{ __('Resources get reports') }}</h2>
                    <p class="lblack no-margin fs13">The following resources get reports from community for guidelines violation or website misuse</p>
                </div>
                <div class="flex">
                    <div class="move-to-right">
                        {{ $reports->onEachSide(0)->links() }}
                    </div>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th id="thread-col">Resource Reported</th>
                        <th id="resource-type-col">Resource type</th>
                        <th id="rtype-col">Report Type</th>
                        <th id="reporter-col">Reported by</th>
                        <th id="ops-col">Operations</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                        <x-admin.report.resource-report-manage :report="$report"/>
                    @endforeach
                    @if(!$reports->count())
                        <tr>
                            <td colspan="5" class="full-height">
                                <div class="full-dimensions full-center">
                                    <h2 class="no-margin my8 lblack">No reports for the moment</h2>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection