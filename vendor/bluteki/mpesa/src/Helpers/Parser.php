<?php

namespace Bluteki\MPesa\Helpers;


use Bluteki\MPesa\Contracts\Token\ParserContract;

class Parser implements ParserContract
{
    /**
     * Parse public and private key into token.
     *
     * @param string $publicKey
     * @param string $privateKey
     * @return string
     */
    public static function parse(string $publicKey, string $privateKey): string
    {
        $key = self::keysToCertificate($publicKey);
        $publicKey = openssl_get_publickey($key);
        openssl_public_encrypt($privateKey, $token, $publicKey, OPENSSL_PKCS1_PADDING);
        return base64_encode($token);
    }

    protected static function keysToCertificate(string $publicKey): string
    {
        $certificate = "-----BEGIN PUBLIC KEY-----\n";
        $certificate .= wordwrap($publicKey, 60, "\n", true);
        $certificate .= "\n-----END PUBLIC KEY-----";
        return $certificate;
    }
}