<?php

namespace App\Services;

use App\Interfaces\EncryptionInterface;
use Illuminate\Support\Facades\Hash;

class Encryption implements EncryptionInterface
{
    public function encrypt(string $value): string
    {
        return Hash::make($value);
    }
}
