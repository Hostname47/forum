<div>
    <div class="right-panel-header-container">
        <div class="flex align-center">
        <svg class="size17 mr4" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M438.09,273.32h-39.6a102.92,102.92,0,0,1,6.24,35.4V458.37a44.18,44.18,0,0,1-2.54,14.79h65.46A44.4,44.4,0,0,0,512,428.81V347.23A74,74,0,0,0,438.09,273.32ZM107.26,308.73a102.94,102.94,0,0,1,6.25-35.41H73.91A74,74,0,0,0,0,347.23v81.58a44.4,44.4,0,0,0,44.35,44.35h65.46a44.17,44.17,0,0,1-2.55-14.78Zm194-73.91H210.74a74,74,0,0,0-73.91,73.91V458.38a14.78,14.78,0,0,0,14.78,14.78H360.39a14.78,14.78,0,0,0,14.78-14.78V308.73A74,74,0,0,0,301.26,234.82ZM256,38.84a88.87,88.87,0,1,0,88.89,88.89A89,89,0,0,0,256,38.84ZM99.92,121.69a66.44,66.44,0,1,0,66.47,66.47A66.55,66.55,0,0,0,99.92,121.69Zm312.16,0a66.48,66.48,0,1,0,66.48,66.47A66.55,66.55,0,0,0,412.08,121.69Z"/></svg>
            <p class="no-margin bold fs16">{{ __('Forums') }}</p>
        </div>
        <div class="move-to-right">
            <a href="/forums" class="link-style flex align-center">
                <svg class="size14 mr4" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M352,289V416H64V128h96V64H32A32,32,0,0,0,0,96V448a32,32,0,0,0,32,32H384a32,32,0,0,0,32-32V289Z"/><path d="M505.6,131.2l-128-96A16,16,0,0,0,352,48V96H304C206.94,96,128,175,128,272a16,16,0,0,0,12.32,15.59A16.47,16.47,0,0,0,144,288a16,16,0,0,0,14.3-8.83l3.78-7.52A143.2,143.2,0,0,1,290.88,192H352v48a16,16,0,0,0,25.6,12.8l128-96a16,16,0,0,0,0-25.6Z"/></svg>
                {{ __('see all') }}
            </a>
        </div>
    </div>
    <div class="ml8">
        @foreach($forums as $forum)
        <div class="my8 py4 toggle-box">
            <div class="px8 flex align-center toggle-container-button pointer unselectable">
                <svg class="size17 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    {!! $forum->icon !!}
                </svg>
                <span class="bold">{{ __($forum->forum) }}</span>
                <svg class="toggle-arrow mx8 size7" style="margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
                    <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
                </svg>
                <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="stop-propagation move-to-right link-style fs13 mr8">{{ __('visit') }}</a>
            </div>
            <div class="toggle-container px8">
                @foreach($forum->categories()->excludeannouncements()->get() as $category)
                <div class="my8" style="margin-left: 30px">
                    <a href="{{ route('category.threads', ['forum'=>$forum->slug, 'category'=>$category->slug]) }}" class="bold blue fs13 no-underline">{{ __($category->category) }}</a>
                </div>
                @endforeach
            </div>
        </div>    
        @endforeach
    </div>
</div>