<?php

namespace JeffersonGoncalves\Filament\Admin\Resources\AdminResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use JeffersonGoncalves\Filament\Admin\Resources\AdminResource;
use JeffersonGoncalves\Filament\Admin\Resources\AdminResource\Pages\Concerns\ResolvesResource;

class ListAdmins extends ListRecords
{
    use ResolvesResource;

    protected static string $resource = AdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
