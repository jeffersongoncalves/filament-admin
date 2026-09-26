<?php

namespace JeffersonGoncalves\Filament\Admin\Resources\Admins\Pages\Concerns;

use Filament\Facades\Filament;
use JeffersonGoncalves\Filament\Admin\AdminPlugin;

/**
 * Pages follow the resource configured on the plugin (AdminPlugin::make()->resource(...)),
 * so an app subclass of AdminResource keeps working without copying the pages.
 */
trait ResolvesResource
{
    public static function getResource(): string
    {
        $panel = Filament::getCurrentPanel();

        if ($panel?->hasPlugin('filament-admin')) {
            return AdminPlugin::get()->getResource();
        }

        return static::$resource;
    }
}
