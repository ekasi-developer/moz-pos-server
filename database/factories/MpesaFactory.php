<?php

namespace Database\Factories;

use App\Models\Transaction;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mpesa>
 */
class MpesaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws Exception
     */
    public function definition()
    {
        return [
            'transaction_id' => fn() => Transaction::factory()->create()->getKey(),
            'amount' => $this->faker->randomFloat(2, 5, 1000),
            'msisdn' => $this->faker->e164PhoneNumber(),
            'transactionStatus' => 'Completed',
            'transactionID' => bin2hex(random_bytes(6)),
            'thirdPartyReference' => bin2hex(random_bytes(6)),
            'serviceProviderCode' => config('mpesa.service_provider_code'),
            'transactionDescription' => 'Request was successful'
        ];
    }
}
