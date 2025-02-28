<?php

namespace App\Providers\Filament;

use App\Http\Middleware\SetLanguage;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentView;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Vite;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Blue,
                'gray' => Color::Neutral,
            ])
            ->favicon(fn () => Vite::asset('resources/images/brand/favicon.png'))
            ->darkModeBrandLogo(fn () => Vite::asset('resources/images/brand/logo-white.svg'))
            ->brandLogo(fn () => Vite::asset('resources/images/brand/logo-black.svg'))
            ->brandLogoHeight('48px')
            ->userMenuItems([
                MenuItem::make()
                    ->label(fn () => Lang::get('admin.change-language'))
                    ->url(fn () => Lang::getLocale() === 'en' ? '/language/pl' : '/language/en')
                    ->icon('heroicon-s-globe-europe-africa'),
            ])
            ->navigationItems([
                NavigationItem::make()
                    ->label(fn () => Lang::get('admin.return-to-home-page'))
                    ->url('/')
                    ->icon('heroicon-c-arrow-uturn-left')
                    ->sort(1000),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                SetLanguage::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    public function register(): void
    {
        parent::register();

        FilamentView::registerRenderHook('panels::body.end', fn () => Blade::render("@vite('resources/js/app.js')"));
    }
}
