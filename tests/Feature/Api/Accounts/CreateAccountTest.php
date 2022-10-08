<?php

namespace Tests\Feature\Api\Accounts;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class CreateAccountTest extends TestCase
{
    /**
     * @var User
     */
    protected User $user;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Auth::login($this->user);
    }

    /**
     * @return void
     */
    public function testCreateAccount(): void
    {
        $account = [
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->safeEmail(),
            'password' => $password = $this->faker->password(8),
            'password_confirmation' => $password];
        $this->createAccount($account)
            ->assertOk()
            ->assertJsonStructure(['id', 'firstname', 'lastname', 'email']);
        $this->assertDatabaseHas('users', collect($account)->only(['firstname', 'lastname', 'email'])->toArray());
    }

    /**
     * @param array $data
     * @return TestResponse
     */
    private function createAccount(array $data): TestResponse
    {
        return $this->json('POST', 'api/accounts', $data);
    }
}
