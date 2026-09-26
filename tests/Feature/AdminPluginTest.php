<?php

use Filament\Facades\Filament;
use Filament\Panel;
use Illuminate\Support\Facades\Hash;
use JeffersonGoncalves\Filament\Admin\AdminPlugin;
use JeffersonGoncalves\Filament\Admin\Pages\Auth\Login;
use JeffersonGoncalves\Filament\Admin\Resources\Admins\AdminResource;
use JeffersonGoncalves\Filament\Admin\Resources\Admins\Pages\CreateAdmin;
use JeffersonGoncalves\Filament\Admin\Resources\Admins\Pages\ListAdmins;
use JeffersonGoncalves\Filament\Admin\Tests\Fixtures\Admin;
use JeffersonGoncalves\Filament\Admin\Tests\Fixtures\CustomAdminResource;
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

it('can access any panel and impersonate', function () {
    $admin = Admin::factory()->make();

    expect($admin->canAccessPanel(Panel::make()->id('admin')))->toBeTrue()
        ->and($admin->canImpersonate())->toBeTrue();
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
