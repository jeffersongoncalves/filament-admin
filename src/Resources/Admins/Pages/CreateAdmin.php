<?php

namespace JeffersonGoncalves\Filament\Admin\Resources\Admins\Pages;

use Filament\Resources\Pages\CreateRecord;
use JeffersonGoncalves\Filament\Admin\Resources\Admins\AdminResource;
use JeffersonGoncalves\Filament\Admin\Resources\Admins\Pages\Concerns\ResolvesResource;

class CreateAdmin extends CreateRecord
{
    use ResolvesResource;

    protected static string $resource = AdminResource::class;
}
