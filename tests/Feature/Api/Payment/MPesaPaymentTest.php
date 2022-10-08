<?php

namespace Tests\Feature\Api\Payment;

use App\Enums\PaymentStatus;
use App\Models\User;
use Bluteki\MPesa\MPesa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class MPesaPaymentTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Auth::login($this->user);
    }

    public function testMPesaPayment(): void
    {
//        MPesa::fake();

        $data = [
            'method' => 'MPesa',
            'msisdn' => '258843242160',
            'amount' => '1'
        ];

        $this->payment($data)
            ->assertOk()
            ->assertJson(['method' => 'mpesa', 'user_id' => Auth::id(), 'amount' => $data['amount']]);

        $this->assertDatabaseHas('transactions', [
            'method' => strtolower($data['method']),
            'amount' => $data['amount'],
            'status' => PaymentStatus::Completed,
        ]);

        $this->assertDatabaseHas('mpesas', [
            'amount' => $data['amount'],
            'msisdn' => $data['msisdn'],
        ]);
    }

    private function payment(array $data): TestResponse
    {
        return $this->json('POST', 'api/payment/mobile', $data);
    }
}
