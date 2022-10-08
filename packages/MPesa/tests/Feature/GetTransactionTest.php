<?php

use Bluteki\MPesa\MPesa;
use Bluteki\MPesa\Tests\TestCase;

class GetTransactionTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testGetTransaction(): void
    {
        MPesa::fake();

        $data = [
            'thirdPartyReference' => bin2hex(random_bytes(6)) ,
            'transactionReference' => bin2hex(random_bytes(6)),
        ];

        $transaction = MPesa::transaction($data['thirdPartyReference'], $data['thirdPartyReference']);

        $this->assertEquals(200, $transaction->getResponseCode());
        $this->assertEquals('Completed', $transaction->getTransactionStatus());
        $this->assertArrayHasKey('transactionID', $transaction->toArray());
        $this->assertArrayHasKey('responseDescription', $transaction->toArray());
    }
}