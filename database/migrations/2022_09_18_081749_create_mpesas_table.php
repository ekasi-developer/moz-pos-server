<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        'amount' => $amount,
//            'msisdn' => $msisdn,
//            'transactionID' => $payment->getTransactionID(),
//            'transaction_status' => $paymentTransaction->getTransactionStatus(),
//            'third_party_reference' => $thirdPartyReference,
//            'service_provider_code' => config('mpesa.service_provider_code'),
//            'description'
        Schema::create('mpesas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('transaction_id');
            $table->float('amount');
            $table->float('msisdn');
            $table->string('transactionID');
            $table->string('transactionStatus')->nullable();
            $table->string('thirdPartyReference');
            $table->string('serviceProviderCode');
            $table->string('transactionDescription');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mpesas');
    }
};
