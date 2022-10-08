<?php

namespace Tests\Feature\Api\Transactions;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class GetTransactionTest extends TestCase
{
    /**
     * @var User
     */
    protected User $user;

    /**
     * @var Transaction
     */
    protected Transaction $transaction;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->transaction = Transaction::factory()->create([
            'user_id' => $this->user->getKey()
        ]);
        Auth::login($this->user);
    }

    public function testGetTransaction(): void
    {
        $this->json('GET', "api/transactions/{$this->transaction->getKey()}")
            ->assertOk()
            ->assertJson(['user_id' => Auth::user()->getKey()]);
    }
}
