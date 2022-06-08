<div>
    <div class="flex" style="margin-bottom: 12px">
        <svg class="size18 mr8" style="margin-top: 2px" fill="#202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            {!! $forum->icon !!}
        </svg>
        <div>
            <h2 class="forum-color fs20 no-margin">{{ $forum->forum }} Forum</h2>
            <div class="flex">
                <svg class="size14 mx8" style="margin-top: 3px" fill="#d2d2d2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"/></svg>
                <p class="my4 bold forum-color">category : {{ $category->category }}</p>
            </div>
        </div>
    </div>
    @if($categoriescount == 2)
    <div class="red-section-style fs13 lblack mb8 flex">
        <svg class="size16 mr4" style="min-width: 16px" fill="rgb(68, 5, 5)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M133.28,5.08h5.82c9.12,3.68,11.64,7.49,11.63,17.56q0,41.69,0,83.36a33.18,33.18,0,0,0,.09,4.35c.31,2.52,1.7,4.18,4.37,4.33,2.94.17,4.49-1.56,5-4.22a23.31,23.31,0,0,0,.13-4.35q0-37.8,0-75.6c0-9.49,5.91-15.89,14.48-15.79,8.25.09,14.27,6.68,14.25,15.71q-.06,42.41-.18,84.8a27.74,27.74,0,0,0,.18,4.83c.48,2.7,2.11,4.43,5,4.2,2.58-.2,4-1.82,4.27-4.43.08-.8.07-1.61.07-2.42q0-28.35-.08-56.7c0-4.12.44-8.06,2.94-11.5A14.34,14.34,0,0,1,217.17,44c6.35,2,10.1,7.94,10.09,16q-.06,61.06-.12,122.13a121.16,121.16,0,0,1-.74,13c-3.19,28.63-19.47,47.82-47.27,55.18-16.37,4.33-33,3.7-49.46.47-20-3.93-36.55-13.65-48.09-30.64-15.76-23.21-31-46.74-46.51-70.16a20.9,20.9,0,0,1-2.13-4.32c-4.68-12.84,4.91-25.12,18.14-23.18,5.55.81,9.81,3.87,13.1,8.36,6.31,8.63,12.63,17.25,19.68,26.87,0-16.64,0-31.95,0-47.25q0-35.13,0-70.27c0-7.58,3.18-12.62,9.24-15,10.31-4,19.76,3.91,19.66,16.09-.19,22.29-.11,44.58-.16,66.87,0,3.33.51,6.46,4.68,6.48s4.75-3.09,4.75-6.42c0-28.11.2-56.22-.13-84.33C121.79,14.87,124.51,8.36,133.28,5.08Z"/></svg>
        <div>
            <p class="no-margin">You cannot delete this category because forums <strong>need at least one category to be available</strong>, and the parent forum of this category has only this category.</p>
            <p class="no-margin mt8">If you would like to delete all categories of this forum and create new ones, then you need to add <strong>at least one new category</strong> in order to be able to add this, or delete the whole forum, and then create a new forum with new categories.</p>
        </div>
    </div>
    @endif
    <div class="section-style fs13 lblack mb8">
        <p class="no-margin">Here you can delete the category and sweep up everything in there. But before that, you have to consider the following points :</p>
        <div class="ml8 mt8">
            <div class="flex align-center">
                <div class="fs10 mr8 gray">•</div>
                <p class="no-margin">You cannot delete <strong>announcements categories</strong> because announcements only deleted when the forum is deleted.</p>
            </div>
            <div class="flex align-center">
                <div class="fs10 mr8 gray">•</div>
                <p class="no-margin mt4">The category must be <strong>archived</strong> in order to be deleted.</p>
            </div>
        </div>
    </div>
    <p class="fs13 no-margin">By deleting this category, all resources and activities in there will be deleted permanently.</p>
    <p class="fs13 no-margin mt4" style="line-height: 1.5">Once you confirm, and press delete button, the process will begin</p>
    <div class="section-style border-box mt4 mb8">
        <p class="fs13 no-margin lblack">This process may take some time (sometimes minutes), depends on the size of category and how many resources it included.</p>
    </div>
    
    @if($categoriescount != 2)
    <p class="bold forum-color" style="margin: 12px 0 4px 0">Confirmation</p>
    <p class="no-margin mb4 bblack">Please type <strong>{{ auth()->user()->username }}::delete-category::{{ $category->category }}</strong> to confirm.</p>
    <div>
        <input type="text" autocomplete="off" class="full-width input-style-1" id="delete-category-confirm-input" style="padding: 8px 10px">
        <input type="hidden" id="delete-category-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}::delete-category::{{ $category->category }}">
    </div>
    <div class="flex" style="margin-top: 12px">
        <div class="flex align-center full-width">
            <div id="delete-category-button" class="disabled-red-button-style red-button-style full-center full-width">
                <div class="relative size14 mr4">
                    <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.13,22.58c1.78.15,3.56.41,5.34.41,17.56,0,35.12.06,52.68,0,2.72,0,4.05.29,4.05,3.64Q65,130,65.19,233.42c0,3.25-1.16,3.7-4,3.7-19.36,0-38.72.1-58.08.18ZM48,74.3c0-9.5-.05-19,0-28.51,0-2.41-.49-3.52-3.24-3.45-7,.18-14.09.2-21.13,0-2.91-.08-3.54,1-3.52,3.68q.14,28.75,0,57.51c0,3,1.11,3.54,3.75,3.49,6.71-.15,13.44-.25,20.15,0,3.44.14,4.07-1.17,4-4.24C47.86,93.31,48,83.81,48,74.3ZM34.08,189.91a13.85,13.85,0,0,0-13.84,13.65,14.05,14.05,0,0,0,13.62,14,13.9,13.9,0,0,0,14-14A13.62,13.62,0,0,0,34.08,189.91ZM140.13,34.6l42.49-11.33c4.42-1.19,8.89-2.23,13.24-3.66,3.1-1,4.36-.48,5.25,2.93,6,23.28,12.36,46.49,18.59,69.73,11.43,42.67,22.79,85.37,34.39,128,1.13,4.13.34,5.37-3.75,6.4q-25.69,6.5-51.18,13.74c-3.38,1-4.14-.11-4.87-2.88q-23.65-88.69-47.4-177.37a212.52,212.52,0,0,0-6.76-21.85V43q0,94.28.11,188.56c0,4.5-1.13,5.67-5.61,5.59-17.39-.27-34.79-.2-52.18,0-3.42,0-4.4-.84-4.4-4.34q.17-102.9,0-205.79c0-3.38,1.07-4.08,4.17-4.06,17.89.12,35.77.15,53.66,0,3.45,0,4.7.91,4.3,4.36A65,65,0,0,0,140.13,34.6Zm-17,40.07c0-9.5-.13-19,.07-28.5.06-3.05-.82-3.93-3.86-3.84-6.87.22-13.75.18-20.63,0-2.56-.06-3.36.71-3.35,3.3q.13,29,0,58c0,2.53.72,3.44,3.33,3.38,6.88-.16,13.76-.2,20.64,0,3,.09,3.93-.8,3.87-3.86C123,93.68,123.14,84.17,123.14,74.67Zm81.55,27.88c-.05-.16-.11-.31-.15-.47q-7.72-28.92-15.42-57.85c-.49-1.84-1.46-2.3-3.23-1.81q-10.89,3-21.8,5.85c-1.65.44-2.47.89-1.89,3,5.2,19.09,10.26,38.23,15.35,57.36.41,1.52.73,2.61,3,2,7.37-2.16,14.83-4,22.26-6C203.79,104.32,205.26,104.36,204.69,102.55Zm-95.23,87.38a13.53,13.53,0,0,0-14,13.37,13.83,13.83,0,0,0,13.73,14.23,14.09,14.09,0,0,0,13.87-13.73A13.88,13.88,0,0,0,109.46,189.93ZM216.65,214.8a13.77,13.77,0,0,0,13.9-13.53,14.08,14.08,0,0,0-14-14.07,13.9,13.9,0,0,0-13.56,14A13.51,13.51,0,0,0,216.65,214.8Z"/></svg>
                    <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                    </svg>
                </div>
                <span class="fs13 bold">I understand the consequences, delete category</span>
                <input type="hidden" class="category-id" value="{{ $category->id }}" autocomplete="off">
            </div>
        </div>
    </div>
    @endif
</div>