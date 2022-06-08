<div id="view-other-thread-reports" class="global-viewer full-center none">
    <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
    <div class="global-viewer-content-box viewer-box-style-2" style="margin-top: -46px">        
        <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
            <span class="fs20 bold forum-color flex align-center">
                <svg class="size20 mr8" style="fill: #1d1d1d" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M349.57,98.78C296,98.78,251.72,64,184.35,64a194.36,194.36,0,0,0-68,12A56,56,0,1,0,32,101.94V488a24,24,0,0,0,24,24H72a24,24,0,0,0,24-24V393.6c28.31-12.06,63.58-22.12,114.43-22.12,53.59,0,97.85,34.78,165.22,34.78,48.17,0,86.67-16.29,122.51-40.86A31.94,31.94,0,0,0,512,339.05V96a32,32,0,0,0-45.48-29C432.18,82.88,390.06,98.78,349.57,98.78Z"/></svg>
                {{ __('All Thread Reports') }}
            </span>
            <div class="pointer fs20 close-global-viewer unselectable">✖</div>
        </div>
        <div class="scrolly" style="max-height: 340px; padding: 14px">
            <table>
                <thead>
                    <tr class="thread-reports-table-header">
                        <th id="reporter-col" style="min-width: 160px">Reported by</th>
                        <th id="rtype-col">Report Type</th>
                        <th id="rtype-col" class="full-width">Body</th>
                        <th id="rtype-col" class="full-width">Reviewed</th>
                    </tr>
                </thead>
                <tbody id="other-reports-content">
                    
                </tbody>
            </table>
        </div>
        <div class="flex" style="padding: 14px">
            <div class="move-to-right">
                <div class="flex align-center">
                    <button class="close-global-viewer button-style">
                        <div class="btn-text">{{ __('Hide') }}</div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>