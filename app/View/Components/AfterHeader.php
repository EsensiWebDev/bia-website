<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AfterHeader extends Component
{
    /**
     * Create a new component instance.
     */
    public $styleSection;
    public $title;
    public $titleColor;
    public $subHeading;
    public $backUrl;
    public function __construct($styleSection = null, $title = 'Our Doctor’s Academic Background', $titleColor = 'text-black', $subHeading = null, $backUrl = null)
    {
        $this->styleSection = $styleSection;
        $this->title = $title;
        $this->titleColor = $titleColor;
        $this->subHeading = $subHeading;
        $this->backUrl = $backUrl;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.after-header');
    }
}
