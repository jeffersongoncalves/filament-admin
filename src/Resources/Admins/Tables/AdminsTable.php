<?php

namespace JeffersonGoncalves\Filament\Admin\Resources\Admins\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdminsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns(static::columns())
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ]);
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
                ->boolean()
                ->trueIcon('heroicon-o-check-badge')
                ->falseIcon('heroicon-o-x-mark')
                ->sortable(),
            TextColumn::make('name')
                ->searchable()
                ->sortable(),
            TextColumn::make('email')
                ->searchable()
                ->sortable()
                ->toggleable(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
