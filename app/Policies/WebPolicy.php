<?php

namespace App\Policies;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policies\Policy;
use Spatie\Csp\Scheme;
use Spatie\Csp\Value;

class WebPolicy extends Policy
{
    private bool $isTelescopeRequest;

    public function configure()
    {
        $this
            ->addDirective(Directive::BASE, Keyword::SELF)
            ->addDirective(Directive::CONNECT, Keyword::SELF)
            ->addDirective(Directive::DEFAULT, Keyword::SELF)
            ->addDirective(Directive::FONT, Keyword::SELF)
            ->addDirective(Directive::FORM_ACTION, Keyword::SELF)
            ->addDirective(Directive::IMG, [
                Keyword::SELF,
                'https://ui-avatars.com', // Needed for user avatars
            ])
            ->addDirective(Directive::MEDIA, Keyword::SELF)
            ->addDirective(Directive::OBJECT, Keyword::NONE)
            ->addDirective(Directive::SCRIPT, Keyword::SELF)
            ->addDirective(Directive::STYLE, [
                Keyword::SELF,
                Keyword::UNSAFE_INLINE, // Needed for PrimeVue Tooltip directive
            ]);

        $this->isTelescopeRequest = Str::startsWith(request()->path(), 'telescope');

        if ($this->isTelescopeRequest) {
            $this
                ->addDirective(Directive::FONT, 'https://fonts.bunny.net')
                ->addDirective(Directive::STYLE, 'https://fonts.bunny.net')
                ->addDirective(Directive::SCRIPT, [
                    Keyword::UNSAFE_EVAL,
                    Keyword::UNSAFE_INLINE,
                ]);
        }

        $this->addProductionDirectives();
        $this->addLocalDirectives();
        $this->addDebugModeDirectives();
    }

    private function addProductionDirectives(): void
    {
        if (!App::isProduction()) {
            return;
        }

        $this
            ->addDirective(Directive::CONNECT, [
                'https://*.analytics.google.com',
                'https://*.google-analytics.com',
                'https://*.googletagmanager.com',
            ])
            ->addDirective(Directive::IMG, [
                'https://*.google-analytics.com',
                'https://*.googletagmanager.com',
            ])
            ->addDirective(Directive::SCRIPT, 'https://*.googletagmanager.com')
            ->addDirective(Directive::UPGRADE_INSECURE_REQUESTS, Value::NO_VALUE);

        if (!$this->isTelescopeRequest) {
            $this->addNonceForDirective(Directive::SCRIPT);
        }
    }

    private function addLocalDirectives(): void
    {
        if (!App::isLocal()) {
            return;
        }

        $this
            ->addDirective(Directive::CONNECT, Scheme::WS)
            ->addDirective(Directive::FONT, 'http://localhost:*')
            ->addDirective(Directive::IMG, 'http://localhost:*')
            ->addDirective(Directive::SCRIPT, [
                Keyword::UNSAFE_INLINE, // Needed for Laravel Debugbar
                'http://localhost:*',
            ])
            ->addDirective(Directive::STYLE, 'http://localhost:*');
    }

    private function addDebugModeDirectives(): void
    {
        if (!App::hasDebugModeEnabled()) {
            return;
        }

        $this
            ->addDirective(Directive::FONT, Scheme::DATA) // Needed for Laravel Debugbar
            ->addDirective(Directive::IMG, Scheme::DATA) // Needed for Laravel Debugbar
            ->addDirective(Directive::SCRIPT, Keyword::UNSAFE_INLINE); // Needed for Laravel Debugbar
    }
}
