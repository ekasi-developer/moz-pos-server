<?php

namespace Tests\Feature\Api\Authentication;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    /**
     * @var User
     */
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Auth::login($this->user);
    }

    public function testLogout(): void
    {
        $this->logout()
            ->assertOk()
            ->assertJson(['loggedOut' => true]);
        $this->assertGuest('api');
    }

    private function logout(): TestResponse
    {
        return $this->json('POST', 'api/authentication/logout');
    }
}
