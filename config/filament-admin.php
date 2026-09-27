<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Panel access gate
    |--------------------------------------------------------------------------
    |
    | Invokable class, called as __invoke(Admin $admin, Panel $panel): bool,
    | that decides whether an admin can use a panel. Filament checks it on
    | every request. null keeps the default: only active admins (status = true).
    | FilamentAdmin::canAccessPanelUsing() takes precedence over this value.
    |
    */

    'can_access_panel' => null,

];
