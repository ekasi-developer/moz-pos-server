<?php

namespace Tests\Feature\Api\Transactions;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class GetTransactionsTest extends TestCase
{
    /**
     * @var User
     */
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->user = User::factory()->create();
        Auth::login($this->user);
    }

    public function testGetTransactions(): void
    {
        $this->json('GET', 'api/transactions')
            ->assertOk();
    }
}
