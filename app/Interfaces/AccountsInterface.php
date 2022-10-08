<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface AccountsInterface
{
    /**
     * Get users accounts in database.
     *
     * @return LengthAwarePaginator
     */
    public function accounts(): LengthAwarePaginator;

    /**
     * Create account in database.
     *
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @return User
     */
    public function create(string $firstName, string $lastName, string $email, string $password): User;
}
