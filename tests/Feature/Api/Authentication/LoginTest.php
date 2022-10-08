<?php

namespace Tests\Feature\Api\Authentication;

use App\Models\User;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * @var User
     */
    private User $user;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**
     * @return void
     */
    public function testLogin()
    {
        $this->login(['email' => $this->user->email, 'password' => 'password'])
            ->assertOk()
            ->assertJsonStructure(['token', 'expire', 'type']);
        $this->assertAuthenticated('api');
    }

    /**
     * @param array $data
     * @return TestResponse
     */
    private function login(array $data): TestResponse
    {
        return $this->json('POST', 'api/authentication/login', $data);
    }
}
