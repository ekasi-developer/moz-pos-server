<?php

namespace Bluteki\MPesa\Tests;

use Bluteki\MPesa\Providers\MPesaServiceProvider;

trait CreatePackage
{
    protected function getPackageProviders($app)
    {
        return [
            MPesaServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}