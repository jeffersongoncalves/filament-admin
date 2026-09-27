<?php

namespace JeffersonGoncalves\Filament\Admin;

use Closure;
use Filament\Panel;
use JeffersonGoncalves\Filament\Admin\Models\Admin;

class FilamentAdmin
{
    /** @var (Closure(Admin, Panel): bool)|null */
    protected ?Closure $canAccessPanelUsing = null;

    /**
     * Override the panel gate, usually from AppServiceProvider::boot().
     * Takes precedence over the `filament-admin.can_access_panel` config.
     *
     * @param  (Closure(Admin, Panel): bool)|null  $callback
     */
    public function canAccessPanelUsing(?Closure $callback): static
    {
        $this->canAccessPanelUsing = $callback;

        return $this;
    }

    /**
     * Filament runs this on every panel request, so deactivating an admin
     * also ends an open session or remember-me login. Default: status = true.
     */
    public function canAccessPanel(Admin $admin, Panel $panel): bool
    {
        if ($this->canAccessPanelUsing) {
            return (bool) ($this->canAccessPanelUsing)($admin, $panel);
        }

        /** @var class-string|null $gate */
        $gate = config('filament-admin.can_access_panel');

        if ($gate) {
            return (bool) app($gate)($admin, $panel);
        }

        return $admin->status === true;
    }
}
