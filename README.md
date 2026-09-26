<div class="filament-hidden">

![Filament Admin](https://raw.githubusercontent.com/jeffersongoncalves/filament-admin/3.x/art/jeffersongoncalves-filament-admin.png)

</div>

# Filament Admin

Filament `Admin` model, `AdminResource`, status-aware Login page and plugin for a separate `admin` guard. Built on [laravel-admin](https://github.com/jeffersongoncalves/laravel-admin).

## Compatibility

| Branch | Filament | Package version |
|--------|----------|-----------------|
| 3.x | 5.x | ^3.0 |

## Installation

```bash
composer require jeffersongoncalves/filament-admin
```

## Usage

### Model

```php
namespace App\Models;

use JeffersonGoncalves\Filament\Admin\Models\Admin as BaseAdmin;

class Admin extends BaseAdmin
{
    // add traits, relations or overrides here
}
```

Point `auth.providers.admins.model` to `App\Models\Admin::class` in `config/auth.php`. The model implements `FilamentUser` (any panel), `HasAvatar`, and `canImpersonate()` returns `true`.

### Panel

```php
use JeffersonGoncalves\Filament\Admin\AdminPlugin;
use JeffersonGoncalves\Filament\Admin\Pages\Auth\Login;

$panel
    ->id('admin')
    ->authGuard('admin')
    ->login(Login::class) // only active admins (status = true) can log in
    ->plugins([
        AdminPlugin::make(),
    ]);
```

Pair it with [filament-user](https://github.com/jeffersongoncalves/filament-user)'s `UserPlugin::make()` on the same panel to manage users too.

### Extending

```php
use JeffersonGoncalves\Filament\Admin\Resources\Admins\AdminResource;
use JeffersonGoncalves\Filament\Admin\Resources\Admins\Tables\AdminsTable;

class MyAdminsTable extends AdminsTable
{
    public static function columns(): array
    {
        return [
            ...parent::columns(),
            TextColumn::make('locale'),
        ];
    }
}

class MyAdminResource extends AdminResource
{
    public static function table(Table $table): Table
    {
        return MyAdminsTable::configure($table);
    }
}

AdminPlugin::make()->resource(MyAdminResource::class);
```

The resource pages follow the plugin, so there is nothing else to copy. `AdminForm::components()` and `AdminInfolist::components()` can be extended the same way.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Jefferson Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
