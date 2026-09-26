<?php

namespace JeffersonGoncalves\Filament\Admin\Resources\Admins\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use JeffersonGoncalves\Filament\Admin\Resources\Admins\AdminResource;
use JeffersonGoncalves\Filament\Admin\Resources\Admins\Pages\Concerns\ResolvesResource;

class EditAdmin extends EditRecord
{
    use ResolvesResource;

    protected static string $resource = AdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
