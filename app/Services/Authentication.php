<?php

namespace App\Services;

use App\Interfaces\AuthenticationInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Authentication implements AuthenticationInterface
{
    public static int $ttl = (60*60)*(24);

    public function apiLogin(string $email, string $password): array|null
    {
        $token = auth()->setTTL(self::$ttl)->attempt(['email' => $email, 'password' => $password]);
        return is_null($token) ? $token : ['token' => $token, 'expire' => self::$ttl, 'type' => 'jwt'];
    }

    public function apiLogout(User $user): void
    {
        Auth::logout();
    }
}
