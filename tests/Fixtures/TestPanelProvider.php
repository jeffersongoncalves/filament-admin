<?php

namespace JeffersonGoncalves\Filament\Admin\Tests\Fixtures;

use Filament\Panel;
use Filament\PanelProvider;
use JeffersonGoncalves\Filament\Admin\AdminPlugin;
use JeffersonGoncalves\Filament\Admin\Pages\Auth\Login;

class TestPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->authGuard('admin')
            ->plugins([
                AdminPlugin::make(),
            ]);
    }
}
