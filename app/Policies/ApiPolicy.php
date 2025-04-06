<?php

namespace App\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policies\Policy;

class ApiPolicy extends Policy
{
    public function configure()
    {
        $this
            ->addDirective(Directive::DEFAULT, Keyword::NONE)
            ->addDirective(Directive::FRAME_ANCESTORS, Keyword::NONE);
    }
}
