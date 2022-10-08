<?php

namespace Tests\Feature\Api\Accounts;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class AccountsTest extends TestCase
{
    protected User $user;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        User::factory(30)->create();
        $this->user = User::factory()->create();
        Auth::login($this->user);
    }

    /**
     * @return void
     */
    public function testAccounts(): void
    {
        $this->getAccounts()
            ->assertOk()
            ->assertJsonCount(20, 'data');
    }

    /**
     * @return TestResponse
     */
    private function getAccounts(): TestResponse
    {
        return $this->json('GET', 'api/accounts', []);
    }
}
