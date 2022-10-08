<?php

namespace Tests\Feature\Api\Transactions;

use App\Enums\PaymentStatus;
use App\Models\Transaction;
use App\Models\User;
use Bluteki\MPesa\MPesa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class MPesaReverseTransaction extends TestCase
{
    protected User $user;

    protected Transaction $transaction;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->transaction = Transaction::factory()->create(['user_id' => $this->user->getKey()]);
        Auth::login($this->user);
    }

    public function testReversMPesaTransaction()
    {
        MPesa::fake();
        $this->reverse($this->transaction)
            ->assertOk()
            ->assertJson(array_merge(
                ['id' => $this->transaction->getKey(), 'user_id' => $this->user->getKey()],
                ['status' => PaymentStatus::Reversed->value]
            ));
        $this->assertDatabaseHas('transactions', array_merge(
            ['id' => $this->transaction->getKey(), 'user_id' => $this->user->getKey()],
            ['status' => PaymentStatus::Reversed->value]
        ));
    }

    /**
     * @param Transaction $transaction
     * @return TestResponse
     */
    private function reverse(Transaction $transaction): TestResponse
    {
        return $this->json("DELETE","api/transactions/{$transaction->getKey()}");
    }
}
