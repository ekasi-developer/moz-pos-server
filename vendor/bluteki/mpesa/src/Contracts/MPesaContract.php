<?php

namespace Bluteki\MPesa\Contracts;

use Bluteki\MPesa\Transaction;

interface MPesaContract
{
    /**
     * @param string $host
     * @param string $origin
     * @param string $token
     * @param string $serviceProviderCode
     * @param string $initiatorIdentifier
     * @param string $securityCredential
     */
    public function __construct(
        string $host,
        string $origin,
        string $token,
        string $serviceProviderCode,
        string $initiatorIdentifier,
        string $securityCredential);

    /**
     * @param bool $fake
     * @param int $code
     * @param string $status
     * @return MPesaContract
     */
    public function setFake(bool $fake, int $code, string $status): MPesaContract;

    /**
     * Initiates a customer to business (c2b) transaction on the M-Pesa API.
     *
     * @param float $amount
     * @param string $msisdn
     * @param string $transactionReference
     * @param string $thirdPartyReference
     * @return mixed
     */
    public function c2b(
        float $amount,
        string $msisdn,
        string $transactionReference,
        string $thirdPartyReference): Transaction;

    /**
     * Initiates a customer to business (b2b) transaction on the M-Pesa API.
     *
     * @param float $amount
     * @param string $msisdn
     * @param string $transactionReference
     * @param string $thirdPartyReference
     * @return mixed
     */
    public function b2b(
        float $amount,
        string $msisdn,
        string $transactionReference,
        string $thirdPartyReference): Transaction;

    /**
     * Initiates a business to business (b2c) transaction on the M-Pesa API.
     *
     * @param float $amount
     * @param string $msisdn
     * @param string $transactionReference
     * @param string $thirdPartyReference
     * @return Transaction
     */
    public function b2c(
        float $amount,
        string $msisdn,
        string $transactionReference,
        string $thirdPartyReference): Transaction;

    /**
     * Initiates a reversal transaction on the M-Pesa API.
     *
     * @param float $amount
     * @param string $transactionID
     * @param string $thirdPartyReference
     * @return Transaction
     */
    public function reversal(
        float $amount,
        string $transactionID,
        string $thirdPartyReference): Transaction;


    /**
     * Get transaction in M-Pesa API.
     *
     * @param string $transactionReference
     * @param string $thirdPartyReference
     * @return Transaction
     */
    public function transaction(
        string $transactionReference,
        string $thirdPartyReference): Transaction;
}