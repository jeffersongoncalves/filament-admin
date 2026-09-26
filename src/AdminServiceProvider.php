<?php

namespace JeffersonGoncalves\Filament\Admin;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AdminServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-admin')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations();
    }
}
