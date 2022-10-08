<?php

namespace App\Services;

use App\Interfaces\AccountsInterface;
use App\Interfaces\EncryptionInterface;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class Accounts implements AccountsInterface
{
    protected EncryptionInterface $encryption;

    public function __construct(Encryption $encryption)
    {
        $this->encryption = $encryption;
    }

    public function accounts(): LengthAwarePaginator
    {
        return User::query()->paginate(20);
    }

    public function create(string $firstName, string $lastName, string $email, string $password): User
    {
        return User::create([
            'firstname' => $firstName,
            'lastname' => $lastName,
            'email' => $email,
            'password' => $this->encryption->encrypt($password)
        ]);
    }
}
