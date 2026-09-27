<?php

namespace JeffersonGoncalves\Filament\Admin\Resources\Admins\Schemas;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;

use function filled;

class AdminForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Section::make()
                    ->columns()
                    ->schema(static::components()),
            ]);
    }

    /**
     * Override (or merge with parent::components()) to add fields.
     *
     * @return array<int, Component>
     */
    public static function components(): array
    {
        return [
            Toggle::make('status')
                ->label(__('filament-admin::admin.fields.status'))
                ->required()
                ->default(true)
                ->autofocus(),
            TextInput::make('name')
                ->label(__('filament-admin::admin.fields.name'))
                ->required()
                ->string()
                ->autofocus(),
            TextInput::make('email')
                ->label(__('filament-admin::admin.fields.email'))
                ->required()
                ->string()
                ->unique(ignoreRecord: true)
                ->email(),
            TextInput::make('password')
                ->label(__('filament-admin::admin.fields.password'))
                ->password()
                ->required(fn (string $context): bool => $context === 'create')
                ->dehydrated(fn ($state) => filled($state))
                ->minLength(6),
        ];
    }
}
