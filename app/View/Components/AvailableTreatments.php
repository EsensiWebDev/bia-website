<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AvailableTreatments extends Component
{
    /**
     * Create a new component instance.
     */
    public $treatments;
    public $category;
    public $stylesection;
    public $title;
    public $titleColor;
    public function __construct($treatments = null, $category = null, $stylesection = null, $title = 'Available Treatments', $titleColor = 'text-[#203B6E]')
    {
        $this->treatments = $treatments;
        $this->category = $category;
        $this->stylesection = $stylesection;
        $this->title = $title;
        $this->titleColor = $titleColor;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.available-treatments');
    }
}
