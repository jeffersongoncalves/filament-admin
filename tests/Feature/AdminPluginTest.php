<?php

use Filament\Facades\Filament;
use Filament\Panel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use JeffersonGoncalves\Filament\Admin\AdminPlugin;
use JeffersonGoncalves\Filament\Admin\Facades\FilamentAdmin;
use JeffersonGoncalves\Filament\Admin\Pages\Auth\Login;
use JeffersonGoncalves\Filament\Admin\Resources\AdminResource;
use JeffersonGoncalves\Filament\Admin\Resources\AdminResource\Pages\CreateAdmin;
use JeffersonGoncalves\Filament\Admin\Resources\AdminResource\Pages\ListAdmins;
use JeffersonGoncalves\Filament\Admin\Tests\Fixtures\Admin;
use JeffersonGoncalves\Filament\Admin\Tests\Fixtures\CustomAdminResource;
use JeffersonGoncalves\Filament\Admin\Tests\Fixtures\DenyAllGate;
use Livewire\Livewire;

beforeEach(function () {
    Filament::setCurrentPanel(Filament::getPanel('admin'));
});

it('registers the admin resource on the panel', function () {
    expect(Filament::getPanel('admin')->getResources())->toContain(AdminResource::class)
        ->and(AdminResource::getModel())->toBe(Admin::class);
});

it('serves the resource under /admins', function () {
    expect(AdminResource::getUrl('index'))->toEndWith('/admin/admins');
});

it('lets the app swap in its own resource and pages follow it', function () {
    $panel = Panel::make()->id('custom')->plugin(AdminPlugin::make()->resource(CustomAdminResource::class));

    expect($panel->getResources())->toContain(CustomAdminResource::class)
        ->not->toContain(AdminResource::class);

    Filament::setCurrentPanel($panel);

    expect(ListAdmins::getResource())->toBe(CustomAdminResource::class);
});

it('ships translated labels', function (string $locale, string $plural, string $group) {
    app()->setLocale($locale);

    expect(AdminResource::getPluralModelLabel())->toBe($plural)
        ->and(AdminResource::getNavigationGroup())->toBe($group);
})->with([
    ['en', 'Admins', 'Management'],
    ['pt_BR', 'Administradores', 'Gerenciamento'],
    ['es', 'Administradores', 'Gestión'],
    ['de', 'Administratoren', 'Verwaltung'],
    ['fr', 'Administrateurs', 'Gestion'],
]);

it('keeps every locale in sync with en', function () {
    $keys = fn (string $file): array => array_keys(Arr::dot(require $file));
    $en = $keys(__DIR__.'/../../resources/lang/en/resources/admin.php');
    $files = glob(__DIR__.'/../../resources/lang/*/resources/admin.php');

    expect($files)->toHaveCount(19);

    foreach ($files as $file) {
        expect($keys($file))->toEqualCanonicalizing($en, $file);
    }
});

it('lets the plugin set the navigation group', function () {
    AdminPlugin::get()->navigationGroup('Team');

    expect(AdminResource::getNavigationGroup())->toBe('Team');
});

it('lets active admins access any panel and impersonate', function () {
    $admin = Admin::factory()->make();

    expect($admin->canAccessPanel(Panel::make()->id('admin')))->toBeTrue()
        ->and($admin->canImpersonate())->toBeTrue()
        ->and(Admin::factory()->inactive()->make()->canAccessPanel(Panel::make()->id('admin')))->toBeFalse();
});

it('locks a deactivated admin out of an already open session', function () {
    $admin = Admin::factory()->create();
    $this->actingAs($admin, 'admin');

    $this->get(AdminResource::getUrl('index'))->assertSuccessful();

    $admin->update(['status' => false]);

    $this->get(AdminResource::getUrl('index'))->assertForbidden();
});

it('lets the app override the panel gate through the facade', function () {
    FilamentAdmin::canAccessPanelUsing(fn (Admin $admin, Panel $panel): bool => $panel->getId() === 'admin');

    $inactive = Admin::factory()->inactive()->make();

    expect($inactive->canAccessPanel(Panel::make()->id('admin')))->toBeTrue()
        ->and($inactive->canAccessPanel(Panel::make()->id('other')))->toBeFalse();

    FilamentAdmin::canAccessPanelUsing(null);
});

it('lets the app override the panel gate through config', function () {
    config(['filament-admin.can_access_panel' => DenyAllGate::class]);

    expect(Admin::factory()->make()->canAccessPanel(Panel::make()->id('admin')))->toBeFalse();
});

it('lists admins', function () {
    $admins = Admin::factory()->count(3)->create();
    $this->actingAs($admins->first(), 'admin');

    Livewire::test(ListAdmins::class)->assertCanSeeTableRecords($admins);
});

it('creates an admin with a hashed password', function () {
    $this->actingAs(Admin::factory()->create(), 'admin');

    Livewire::test(CreateAdmin::class)
        ->fillForm([
            'status' => true,
            'name' => 'Root',
            'email' => 'root@example.com',
            'password' => 'secret123',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $admin = Admin::query()->where('email', 'root@example.com')->sole();

    expect(Hash::check('secret123', $admin->password))->toBeTrue();
});

it('only lets active admins log in through the admin guard', function () {
    Admin::factory()->create(['email' => 'on@example.com', 'password' => 'secret123']);
    Admin::factory()->inactive()->create(['email' => 'off@example.com', 'password' => 'secret123']);

    Livewire::test(Login::class)
        ->fillForm(['email' => 'off@example.com', 'password' => 'secret123'])
        ->call('authenticate')
        ->assertHasFormErrors(['email']);

    $this->assertGuest('admin');

    Livewire::test(Login::class)
        ->fillForm(['email' => 'on@example.com', 'password' => 'secret123'])
        ->call('authenticate')
        ->assertHasNoFormErrors();

    $this->assertAuthenticated('admin');
});
