<?php

use Bluteki\MPesa\MPesa;
use Bluteki\MPesa\Tests\TestCase;

class ReverseAmountTest extends TestCase
{
    public function testReverseTenBucks(): void
    {
        MPesa::fake();

        $data = [
            'amount' => '10',
            'transactionID' => 'bh1xse1b4aow',
            'thirdPartyReference' => '21a79f4bcb4f',
        ];

        $transaction = MPesa::reversal($data['amount'], $data['transactionID'], $data['thirdPartyReference']);

        $this->assertEquals(200, $transaction->toArray()['responseCode']);
        $this->assertArrayHasKey('transactionID', $transaction->toArray());
        $this->assertArrayHasKey('responseDescription', $transaction->toArray());
    }
}