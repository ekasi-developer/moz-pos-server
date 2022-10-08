<?php

use Bluteki\MPesa\MPesa;
use Bluteki\MPesa\Tests\TestCase;
use Bluteki\MPesa\Transaction;

class Client2BusinessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @throws Exception
     */
    public function testCustomer2BusinessReturnsInstanceOfTransaction(): void
    {
        MPesa::fake();

        $transaction = MPesa::c2b(1, '258843240160' , bin2hex(random_bytes(6)), bin2hex(random_bytes(6)));

        $this->assertInstanceOf(Transaction::class, $transaction);
    }

    /**
     * @throws Exception
     */
    public function testCustomer2BusinessChargeTenBucks(): void
    {
//        MPesa::fake();

        $data = [
            'amount' => '1',
            'msisdn' => '258843242160',
            'transactionReference' => bin2hex(random_bytes(6)),
            'thirdPartyReference' => bin2hex(random_bytes(6))
        ];

        $transaction = MPesa::c2b(1, $data['msisdn'], $data['transactionReference'], $data['thirdPartyReference']);

        $this->assertEquals(200, $transaction->toArray()['responseCode']);
        $this->assertArrayHasKey('transactionID', $transaction->toArray());
        $this->assertArrayHasKey('responseDescription', $transaction->toArray());
    }
}