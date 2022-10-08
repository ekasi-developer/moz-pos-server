<?php

namespace Database\Factories;

use App\Enums\PaymentStatus;
use App\Models\Mpesa;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
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
            'amount' => $this->faker->randomFloat(2, 5, 1000),
            'method' => 'mpesa',
            'status' => PaymentStatus::Completed->value,
            'user_id' => fn() => User::factory()->create()->getKey()
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Transaction $transaction) {
            $transaction->mpesa = Mpesa::factory()->create([
                'transaction_id' => $transaction->getKey(),
                'amount' => $transaction->amount,
            ]);
        });
    }
}
