<?php

namespace JeffersonGoncalves\Filament\Admin\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;

/**
 * Only active (status = true) admins can sign in.
 */
class Login extends BaseLogin
{
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'email' => $data['email'],
            'password' => $data['password'],
            'status' => true,
        ];
    }
}
