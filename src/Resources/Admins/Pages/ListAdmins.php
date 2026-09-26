<?php

namespace JeffersonGoncalves\Filament\Admin\Resources\Admins\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use JeffersonGoncalves\Filament\Admin\Resources\Admins\AdminResource;
use JeffersonGoncalves\Filament\Admin\Resources\Admins\Pages\Concerns\ResolvesResource;

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
