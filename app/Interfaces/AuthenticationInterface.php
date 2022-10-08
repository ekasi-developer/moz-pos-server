<?php

namespace App\Interfaces;

use App\Models\User;

interface AuthenticationInterface
{
    /**
     * Check if email and password exits and results user token.
     *
     * @param string $email
     * @param string $password
     * @return array|null
     */
    public function apiLogin(string $email, string $password): array|null;

    /**
     * Destroy user token in session.
     *
     * @param User $user
     * @return void
     */
    public function apiLogout(User $user): void;
}
