<?php

namespace JeffersonGoncalves\Filament\Admin\Resources\Admins\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use JeffersonGoncalves\Filament\Admin\AdminPlugin;

class AdminsTable
{
    public static function configure(Table $table): Table
    {
        $plugin = filament()->getCurrentPanel()?->hasPlugin('filament-admin') ? AdminPlugin::get() : null;

        $actions = [
            ViewAction::make(),
            EditAction::make(),
            DeleteAction::make(),
        ];

        return $table
            ->columns(static::columns())
            ->filters([
                //
            ])
            ->recordActions(
                $plugin?->shouldGroupRecordActions() ? ActionGroup::make($actions) : $actions,
                position: $plugin?->getRecordActionsPosition(),
            );
    }

    /**
     * Override (or merge with parent::columns()) to add columns.
     *
     * @return array<int, Column>
     */
    public static function columns(): array
    {
        return [
            IconColumn::make('status')
                ->label(__('filament-admin::resources/admin.fields.status'))
                ->boolean()
                ->trueIcon('heroicon-o-check-badge')
                ->falseIcon('heroicon-o-x-mark')
                ->sortable(),
            TextColumn::make('name')
                ->label(__('filament-admin::resources/admin.fields.name'))
                ->searchable()
                ->sortable(),
            TextColumn::make('email')
                ->label(__('filament-admin::resources/admin.fields.email'))
                ->searchable()
                ->sortable()
                ->toggleable(),
            TextColumn::make('created_at')
                ->label(__('filament-admin::resources/admin.fields.created_at'))
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->label(__('filament-admin::resources/admin.fields.updated_at'))
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
