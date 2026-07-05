<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class PrintLayout extends Component
{
    public $sale;

    public function __construct($sale)
    {
        $this->sale = $sale;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.print');
    }
}
