<?php

namespace Bluteki\MPesa;

use Bluteki\MPesa\Contracts\FakeContract;
use Bluteki\MPesa\Contracts\MPesaContract;
use Bluteki\MPesa\Contracts\MPesaStaticContract;
use Bluteki\MPesa\Exceptions\InvalidEnvironmentException;
use Bluteki\MPesa\Helpers\Parser;

class MPesa implements MPesaStaticContract, FakeContract
{
    /**
     * @var bool $test
     */
    protected static bool $fake = false;

    /**
     * @var string $developmentHost
     */
    protected static string $developmentHost = "https://api.sandbox.vm.co.mz";

    /**
     * @var string $productionHost
     */
    protected static string $productionHost = "https://api.sandbox.vm.co.mz";

    /**
     * @var string
     */
    protected static string $origin = "developer.mpesa.vm.co.mz";

    /**
     * @var string
     */
    protected static string $status = "";

    /**
     * @var int
     */
    protected static int $responseCode = 200;

    /**
     * @param int $responseCode
     * @param string $status
     */
    public static function fake(int $responseCode = 200, string $status = ""): void
    {
        self::$fake = true;
        self::$status = $status;
        self::$responseCode = $responseCode;
    }

    /**
     * @param string $status
     */
    public static function setStatus(string $status): void
    {
        self::$status = $status;
    }

    /**
     * @param int $code
     */
    public static function setResponseCode(int $code): void
    {
        self::$responseCode = $code;
    }
    /**
     * Initiates a customer to business (c2b) transaction on the M-Pesa API.
     *
     * @param float $amount
     * @param string $msisdn
     * @param string $transactionReference
     * @param string $thirdPartyReference
     * @return mixed
     */
    public static function c2b(float $amount, string $msisdn, string $transactionReference, string $thirdPartyReference): Transaction
    {
        return (new static())->mPesa()->c2b($amount, $msisdn, $transactionReference, $thirdPartyReference);
    }

    /**
     * Initiates a customer to business (b2b) transaction on the M-Pesa API.
     *
     * @param float $amount
     * @param string $msisdn
     * @param string $transactionReference
     * @param $thirdPartyReference
     * @return mixed
     */
    public static function b2b(float $amount, string $msisdn, string $transactionReference, $thirdPartyReference): Transaction
    {
        return (new static())->mPesa()->b2b($amount, $msisdn, $transactionReference, $thirdPartyReference);;
    }

    /**
     * Initiates a business to business (b2c) transaction on the M-Pesa API.
     *
     * @param float $amount
     * @param string $msisdn
     * @param string $transactionReference
     * @param $thirdPartyReference
     * @return mixed
     */
    public static function b2c(float $amount, string $msisdn, string $transactionReference, $thirdPartyReference): Transaction
    {
        return (new static())->mPesa()->b2c($amount, $msisdn, $transactionReference, $thirdPartyReference);
    }

    /**
     * Get transaction in M-Pesa API.
     *
     * @param string $transactionReference
     * @param string $thirdPartyReference
     * @return Transaction
     */
    public static function transaction(string $transactionReference, string $thirdPartyReference): Transaction
    {
        return (new static())->mPesa()->transaction($transactionReference, $thirdPartyReference);
    }


    /**
     * Initiates a reversal transaction on the M-Pesa API.
     *
     * @param float $amount
     * @param string $transactionID
     * @param string $thirdPartyReference
     * @return mixed
     */
    public static function reversal(float $amount, string $transactionID, string $thirdPartyReference): Transaction
    {
        return (new static())->mPesa()->reversal($amount, $transactionID, $thirdPartyReference);
    }

    /**
     * @return MPesaContract
     */
    protected function mPesa(): MPesaContract
    {
        $host = config('mpesa.environment') == 'production' ? self::$productionHost : self::$developmentHost;
        $token = Parser::parse(config('mpesa.public_key'), config('mpesa.private_key'));
        $providerCode = config('mpesa.service_provider_code');
        $identifier = config('mpesa.initiator_identifier');
        $credential = config('mpesa.security_credential');
        $mpesaRequest = new Request($host, self::$origin, $token, $providerCode, $identifier, $credential);
        return $mpesaRequest->setFake(self::$fake, self::$responseCode, self::$status);
    }
}
