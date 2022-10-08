<?php

use Bluteki\MPesa\Tests\TestCase;

class MPesaConfigurationsTest extends TestCase
{
    public function testDefualtConfigurationAreSet()
    {
        $defualtConfig = require __DIR__ . '/../../config/config.php';
        $appConfig = config('mpesa');
        
        $this->assertEquals($defualtConfig, $appConfig);
    }
}