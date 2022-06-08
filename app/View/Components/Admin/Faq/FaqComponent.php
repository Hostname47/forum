<?php

namespace App\View\Components\Admin\Faq;

use Illuminate\View\Component;
use App\Models\FAQ;

class FaqComponent extends Component
{
    public $faq;

    public function __construct(FAQ $faq)
    {
        $this->faq = $faq;    
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.faq.faq-component', $data);
    }
}
