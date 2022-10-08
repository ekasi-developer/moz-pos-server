<?php

namespace App\Services\Payment\Mobile;

use App\Enums\PaymentStatus;
use App\Models\Transaction;
use App\Models\User;
use Bluteki\MPesa\MPesa;
use Exception;

class MPesaPayment extends Payment
{
    /**
     * @throws Exception
     */
    public function charge(string $msisdn, int $amount, User $user): Transaction
    {
        $transactionReference = bin2hex(random_bytes(6));
        $thirdPartyReference = bin2hex(random_bytes(6));
        $payment = MPesa::c2b($amount, $msisdn, $transactionReference, $thirdPartyReference);
        $mpesaTransaction = MPesa::transaction($transactionReference, $thirdPartyReference);
        $transaction = new Transaction([
            'amount' => $amount,
            'user_id' => $user->getKey(),
            'method' => 'mpesa',
            'status' => PaymentStatus::status($mpesaTransaction->getTransactionStatus())->value
        ]);
        $transaction->save();
        $transaction->mpesa = $transaction->mpesa()->create([
            'amount' => $amount,
            'msisdn' => $msisdn,
            'transactionID' => $payment->getTransactionID(),
            'transactionStatus' => $mpesaTransaction->getTransactionStatus(),
            'thirdPartyReference' => $thirdPartyReference,
            'serviceProviderCode' => config('mpesa.service_provider_code'),
            'transactionDescription' => $mpesaTransaction->getDescription()
        ]);
        return $transaction;
    }

    public function reverse(Transaction $transaction, User $user): Transaction
    {
        MPesa::reversal(
            $transaction->amount,
            $transaction->mpesa->transactionID,
            $transaction->mpesa->thirdPartyReference
        );
        $transaction->update(['status' => PaymentStatus::Reversed->value]);
        return $transaction;
    }
}
