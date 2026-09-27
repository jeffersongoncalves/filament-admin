<?php

namespace JeffersonGoncalves\Filament\Admin\Resources\AdminResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use JeffersonGoncalves\Filament\Admin\Resources\AdminResource;
use JeffersonGoncalves\Filament\Admin\Resources\AdminResource\Pages\Concerns\ResolvesResource;

class ViewAdmin extends ViewRecord
{
    use ResolvesResource;

    protected static string $resource = AdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
