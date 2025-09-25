<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CTASection extends Component
{
    /**
     * Create a new component instance.
     */
    public $bg;
    public $title;
    public $titleColor;
    public $btnUrl;
    public $btnText;
    public function __construct(
        $bg = 'bg-white',
        $title = 'Ready To Transform Your Smile and Live Happier?',
        $titleColor = 'text-[#343A40]',
        $btnUrl = '#default',
        $btnText = 'MEET THE DENTIST'
    ) {
        $this->bg = $bg;
        $this->title = $title;
        $this->titleColor = $titleColor;;
        $this->btnUrl = $btnUrl;
        $this->btnText = $btnText;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cta-section');
    }
}
