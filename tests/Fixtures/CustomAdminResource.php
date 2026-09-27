<?php

namespace JeffersonGoncalves\Filament\Admin\Tests\Fixtures;

use JeffersonGoncalves\Filament\Admin\Resources\AdminResource;

class CustomAdminResource extends AdminResource
{
    protected static ?string $slug = 'staff';
}
