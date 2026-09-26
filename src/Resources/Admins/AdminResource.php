<?php

namespace JeffersonGoncalves\Filament\Admin\Resources\Admins;

use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use JeffersonGoncalves\Admin\Observers\AdminObserver;
use JeffersonGoncalves\Filament\Admin\Models\Admin;
use JeffersonGoncalves\Filament\Admin\Resources\Admins\Pages\CreateAdmin;
use JeffersonGoncalves\Filament\Admin\Resources\Admins\Pages\EditAdmin;
use JeffersonGoncalves\Filament\Admin\Resources\Admins\Pages\ListAdmins;
use JeffersonGoncalves\Filament\Admin\Resources\Admins\Pages\ViewAdmin;
use JeffersonGoncalves\Filament\Admin\Resources\Admins\Schemas\AdminForm;
use JeffersonGoncalves\Filament\Admin\Resources\Admins\Schemas\AdminInfolist;
use JeffersonGoncalves\Filament\Admin\Resources\Admins\Tables\AdminsTable;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    // Filament 3 derives the slug from the namespace ("admins/admins") otherwise.
    protected static ?string $slug = 'admins';

    protected static bool $isGloballySearchable = true;

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * The app's admin model (config auth.providers.admins.model), so App\Models\Admin is used.
     */
    public static function getModel(): string
    {
        return config('auth.providers.admins.model') ?: static::$model;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }

    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return static::getUrl('view', ['record' => $record]);
    }

    public static function getModelLabel(): string
    {
        return __('Admin');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Admins');
    }

    public static function getNavigationLabel(): string
    {
        return __('Admins');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Management');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) Cache::rememberForever(AdminObserver::CACHE_KEY, fn () => static::getModel()::query()->count());
    }

    public static function form(Form $form): Form
    {
        return AdminForm::configure($form);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return AdminInfolist::configure($infolist);
    }

    public static function table(Table $table): Table
    {
        return AdminsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAdmins::route('/'),
            'create' => CreateAdmin::route('/create'),
            'view' => ViewAdmin::route('/{record}'),
            'edit' => EditAdmin::route('/{record}/edit'),
        ];
    }
}
