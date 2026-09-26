<?php

namespace JeffersonGoncalves\Filament\Admin\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use JeffersonGoncalves\Admin\AdminServiceProvider as LaravelAdminServiceProvider;
use JeffersonGoncalves\Filament\AdditionalInformation\FilamentAdditionalInformationServiceProvider;
use JeffersonGoncalves\Filament\Admin\AdminServiceProvider;
use JeffersonGoncalves\Filament\Admin\Tests\Fixtures\Admin;
use JeffersonGoncalves\Filament\Admin\Tests\Fixtures\TestPanelProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            BladeIconsServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            LivewireServiceProvider::class,
            SupportServiceProvider::class,
            FormsServiceProvider::class,
            TablesServiceProvider::class,
            ActionsServiceProvider::class,
            InfolistsServiceProvider::class,
            NotificationsServiceProvider::class,
            WidgetsServiceProvider::class,
            FilamentServiceProvider::class,
            FilamentAdditionalInformationServiceProvider::class,
            LaravelAdminServiceProvider::class,
            AdminServiceProvider::class,
            TestPanelProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
        $app['config']->set('auth.providers.admins', ['driver' => 'eloquent', 'model' => Admin::class]);
    }

    protected function defineDatabaseMigrations(): void
    {
        (include __DIR__.'/../vendor/jeffersongoncalves/laravel-admin/database/migrations/create_admins_table.php.stub')->up();
    }
}
