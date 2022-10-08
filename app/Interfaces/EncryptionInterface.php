<?php

namespace App\Interfaces;

interface EncryptionInterface
{
    /**
     * Encrypt value.
     *
     * @param string $value
     * @return string
     */
    public function encrypt(string $value): string;
}
