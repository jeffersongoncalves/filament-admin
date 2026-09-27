<?php

namespace JeffersonGoncalves\Filament\Admin\Tests\Fixtures;

class DenyAllGate
{
    public function __invoke(): bool
    {
        return false;
    }
}
