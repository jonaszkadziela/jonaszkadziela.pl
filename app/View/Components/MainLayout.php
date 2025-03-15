<?php

namespace App\View\Components;

use App\Support\Helpers;
use Illuminate\View\Component;
use Illuminate\View\View;

class MainLayout extends Component
{
    public ?string $hash;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $title = null,
        public ?string $bodyClass = null,
        public ?bool $withAnalytics = null,
    ) {
        $this->hash = Helpers::getCurrentGitCommitHash();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('layouts.main');
    }
}
