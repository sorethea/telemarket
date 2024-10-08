<?php

namespace App\Providers\Filament;

use App\Filament\Auth\Login;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;

class MarketingPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('marketing')
            ->path('')
            ->login(Login::class)
            ->databaseNotifications()
            ->databaseNotificationsPolling(2)
            ->colors([
                'primary' => Color::Indigo,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
                //BreezyCore::make()->myProfile(),
            ])
            ->discoverResources(in: app_path('Filament/Marketing/Resources'), for: 'App\\Filament\\Marketing\\Resources')
            ->discoverPages(in: app_path('Filament/Marketing/Pages'), for: 'App\\Filament\\Marketing\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Marketing/Widgets'), for: 'App\\Filament\\Marketing\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                //Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
