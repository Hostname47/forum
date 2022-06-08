<?php

namespace App\View\Components\Admin\Forumsandcategories;

use Illuminate\View\Component;
use App\Models\Forum;

class CategoriesSection extends Component
{
    public $categories;
    public $forum;
    public function __construct(Forum $forum)
    {
        $this->categories = $forum->categories()->withoutGlobalScopes()->with(['status'])->orderBy('status_id')->get();
        $this->forum = $forum;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.forumsandcategories.categories-section', $data);
    }
}
