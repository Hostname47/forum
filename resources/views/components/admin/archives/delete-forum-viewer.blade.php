<div>
    <div class="flex" style="margin-bottom: 12px">
        <svg class="size18 mr8" style="margin-top: 2px" fill="#202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            {!! $forum->icon !!}
        </svg>
        <h2 class="forum-color fs20 no-margin">{{ $forum->forum }} Forum - <span class="gray">Archived</span></h2>
    </div>
    <div class="section-style fs13 lblack mb8">
        <p class="no-margin">Here you can delete the forum and sweep up everything in there including all categories and their associated threads and activities.</p>
        <p class="no-margin mt4">The forum must be <strong>archived</strong> in order to be deleted.</p>
    </div>
    <p class="fs13 no-margin">By deleting this forum, all resources and activities in its categories will be deleted permanently.</p>
    <p class="fs13 no-margin mt4" style="line-height: 1.5">Once you confirm, and press delete button, the process will begin</p>
    <div class="section-style border-box mt4 mb8">
        <p class="fs13 no-margin lblack">This process may take some time (sometimes minutes), depends on the size of forum and its categories and how many resources it includs.</p>
    </div>

    <div class="flex align-center mb4">
        <svg class="mr4 size15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M18.66,68.29c-.45-26.81,21.7-49.6,48.58-50a49.62,49.62,0,0,1,50.68,48.86c.58,27.16-21.52,50.15-48.55,50.49A49.71,49.71,0,0,1,18.66,68.29ZM68.23,97.81A29.81,29.81,0,1,0,38.55,68.19,29.83,29.83,0,0,0,68.23,97.81ZM18.66,191.6c-.51-26.59,21.39-49.43,48-50a49.63,49.63,0,0,1,51.25,48.77c.63,26.94-21.21,50-48,50.56A49.72,49.72,0,0,1,18.66,191.6ZM68.3,221a29.81,29.81,0,1,0-29.75-29.55A29.81,29.81,0,0,0,68.3,221ZM240.12,67.6c.54,26.57-21.44,49.49-48,50.07a49.7,49.7,0,0,1-51.29-48.76c-.73-26.83,21.25-50,48-50.57C217,17.73,239.54,39.35,240.12,67.6Zm-19.9.32A29.77,29.77,0,1,0,190.29,97.8,29.76,29.76,0,0,0,220.22,67.92Zm19.9,122.93c.52,26.58-21.46,49.48-48,50a49.69,49.69,0,0,1-51.26-48.79c-.71-26.83,21.28-50,48-50.53C217.05,141,239.57,162.61,240.12,190.85Zm-19.9.18a29.77,29.77,0,1,0-29.81,30A29.74,29.74,0,0,0,220.22,191Z"/></svg>
        <span class="bold">Forum categories</span>
    </div>
    <table class="full-width">
        <tr>
            <th class="category-column">category</th>
            <th class="category-desc-column">description</th>
            <th class="category-state-column">status</th>
        </tr>
        @foreach($categories as $category)
            <tr class="category-row">
                <input type="hidden" class="category-id" autocomplete="off" value="{{ $category->id }}">
                <td class="bold">{{ $category->category }}</td>
                <td>{{ $category->descriptionslice }}</td>
                @php 
                    $status = $category->status;
                    $cscolor = ($status->slug == 'live') ? 'green' : (($status->slug == 'closed') ? 'red' : (($status->slug == 'under-review') ? 'blue' : 'gray' ));
                @endphp
                <td class="bold {{ $cscolor }}">{{ $category->status->slug }}</td>
            </tr>
        @endforeach
        @if(!$categories->count())
        <tr>
            <td colspan="4">
                <div class="full-center">
                    <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"></path></svg>
                    <p class="my4 text-center">The forum doesn't contain any categories yet.</p>
                </div>
            </td>
        </tr>
        @endif
    </table>

    <p class="bold forum-color" style="margin: 12px 0 4px 0">Confirmation</p>
    <p class="no-margin mb4 bblack">Please type <strong>{{ auth()->user()->username }}::delete-forum::{{ $forum->slug }}</strong> to confirm.</p>
    <div>
        <input type="text" autocomplete="off" class="full-width input-style-1" id="delete-forum-confirm-input" style="padding: 8px 10px">
        <input type="hidden" id="delete-forum-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}::delete-forum::{{ $forum->slug }}">
    </div>
    <div class="flex" style="margin-top: 12px">
        <div class="flex align-center full-width">
            <div id="delete-forum-button" class="disabled-red-button-style red-button-style full-center full-width">
                <div class="relative size14 mr4">
                    <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.13,22.58c1.78.15,3.56.41,5.34.41,17.56,0,35.12.06,52.68,0,2.72,0,4.05.29,4.05,3.64Q65,130,65.19,233.42c0,3.25-1.16,3.7-4,3.7-19.36,0-38.72.1-58.08.18ZM48,74.3c0-9.5-.05-19,0-28.51,0-2.41-.49-3.52-3.24-3.45-7,.18-14.09.2-21.13,0-2.91-.08-3.54,1-3.52,3.68q.14,28.75,0,57.51c0,3,1.11,3.54,3.75,3.49,6.71-.15,13.44-.25,20.15,0,3.44.14,4.07-1.17,4-4.24C47.86,93.31,48,83.81,48,74.3ZM34.08,189.91a13.85,13.85,0,0,0-13.84,13.65,14.05,14.05,0,0,0,13.62,14,13.9,13.9,0,0,0,14-14A13.62,13.62,0,0,0,34.08,189.91ZM140.13,34.6l42.49-11.33c4.42-1.19,8.89-2.23,13.24-3.66,3.1-1,4.36-.48,5.25,2.93,6,23.28,12.36,46.49,18.59,69.73,11.43,42.67,22.79,85.37,34.39,128,1.13,4.13.34,5.37-3.75,6.4q-25.69,6.5-51.18,13.74c-3.38,1-4.14-.11-4.87-2.88q-23.65-88.69-47.4-177.37a212.52,212.52,0,0,0-6.76-21.85V43q0,94.28.11,188.56c0,4.5-1.13,5.67-5.61,5.59-17.39-.27-34.79-.2-52.18,0-3.42,0-4.4-.84-4.4-4.34q.17-102.9,0-205.79c0-3.38,1.07-4.08,4.17-4.06,17.89.12,35.77.15,53.66,0,3.45,0,4.7.91,4.3,4.36A65,65,0,0,0,140.13,34.6Zm-17,40.07c0-9.5-.13-19,.07-28.5.06-3.05-.82-3.93-3.86-3.84-6.87.22-13.75.18-20.63,0-2.56-.06-3.36.71-3.35,3.3q.13,29,0,58c0,2.53.72,3.44,3.33,3.38,6.88-.16,13.76-.2,20.64,0,3,.09,3.93-.8,3.87-3.86C123,93.68,123.14,84.17,123.14,74.67Zm81.55,27.88c-.05-.16-.11-.31-.15-.47q-7.72-28.92-15.42-57.85c-.49-1.84-1.46-2.3-3.23-1.81q-10.89,3-21.8,5.85c-1.65.44-2.47.89-1.89,3,5.2,19.09,10.26,38.23,15.35,57.36.41,1.52.73,2.61,3,2,7.37-2.16,14.83-4,22.26-6C203.79,104.32,205.26,104.36,204.69,102.55Zm-95.23,87.38a13.53,13.53,0,0,0-14,13.37,13.83,13.83,0,0,0,13.73,14.23,14.09,14.09,0,0,0,13.87-13.73A13.88,13.88,0,0,0,109.46,189.93ZM216.65,214.8a13.77,13.77,0,0,0,13.9-13.53,14.08,14.08,0,0,0-14-14.07,13.9,13.9,0,0,0-13.56,14A13.51,13.51,0,0,0,216.65,214.8Z"/></svg>
                    <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                    </svg>
                </div>
                <span class="fs12 bold">I understand the consequences, delete forum</span>
                <input type="hidden" class="forum-id" value="{{ $forum->id }}" autocomplete="off">
            </div>
        </div>
    </div>
</div>