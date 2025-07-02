<?php

namespace App\View\Components\utama\layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class main extends Component
{
    public string $title;

    /**
     * Create a new component instance.
     */
    public function __construct(string $title = 'Dashboard Superadmin')
    {
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.utama.layout.main');
    }
}
