<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OurDoctorsBg extends Component
{
    /**
     * Create a new component instance.
     */

    public $bg;
    public $title;
    public $titleColor;
    public function __construct($bg = 'bg-gray-50', $title = 'Our Doctor’s Academic Background', $titleColor = 'text-black')
    {
        $this->bg = $bg;
        $this->title = $title;
        $this->titleColor = $titleColor;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.our-doctors-bg');
    }
}
