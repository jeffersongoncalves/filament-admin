<?php

namespace JeffersonGoncalves\Filament\Admin\Resources\AdminResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use JeffersonGoncalves\Filament\Admin\Resources\AdminResource;
use JeffersonGoncalves\Filament\Admin\Resources\AdminResource\Pages\Concerns\ResolvesResource;

class CreateAdmin extends CreateRecord
{
    use ResolvesResource;

    protected static string $resource = AdminResource::class;
}
