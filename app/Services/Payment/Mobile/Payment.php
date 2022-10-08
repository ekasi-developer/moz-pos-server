<?php

namespace App\Services\Payment\Mobile;


use App\Models\Transaction;
use App\Models\User;

abstract class Payment
{
    /**
     * Change msisdn or cellphone number.
     *
     * @param string $msisdn
     * @param int $amount
     * @param User $user
     * @return mixed
     */
    public abstract function charge(string $msisdn, int $amount, User $user): Transaction;

    /**
     * Reverse transaction to customer.
     *
     * @param Transaction $transaction
     * @param User $user
     * @return mixed
     */
    public abstract function reverse(Transaction $transaction, User $user): Transaction;
}
