<?php

namespace JeffersonGoncalves\Filament\Admin\Tests\Fixtures;

use JeffersonGoncalves\Filament\Admin\Resources\Admins\AdminResource;

class CustomAdminResource extends AdminResource
{
    protected static ?string $slug = 'staff';
}
