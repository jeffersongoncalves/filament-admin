<?php

namespace JeffersonGoncalves\Filament\Admin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \JeffersonGoncalves\Filament\Admin\FilamentAdmin canAccessPanelUsing(?\Closure $callback)
 * @method static bool canAccessPanel(\JeffersonGoncalves\Filament\Admin\Models\Admin $admin, \Filament\Panel $panel)
 *
 * @see \JeffersonGoncalves\Filament\Admin\FilamentAdmin
 */
class FilamentAdmin extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \JeffersonGoncalves\Filament\Admin\FilamentAdmin::class;
    }
}
