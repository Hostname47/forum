<?php

namespace App\View\Components\Admin\Archives;

use Illuminate\View\Component;

class DeleteCategoryViewer extends Component
{
    public $category;
    public $forum;
    public $categoriescount;

    public function __construct($category)
    {
        $this->category = $category;
        $this->forum = $category->forum()->withoutGlobalScopes()->first();
        $this->categoriescount = $this->forum->categories()->withoutGlobalScopes()->count(); // If it's 2, this means when category deleted the forum also gets deleted
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.archives.delete-category-viewer', $data);
    }
}
