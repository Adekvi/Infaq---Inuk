<?php

namespace App\View\Components\sekunder\terminal;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class home extends Component
{
    public string $title;

    /**
     * Create a new component instance.
     */
    public function __construct(string $title = 'Landing Page')
    {
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sekunder.terminal.home');
    }
}
