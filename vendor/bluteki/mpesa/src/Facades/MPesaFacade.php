<?php

namespace Bluteki\MPesa;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Bluteki\MPesa\Skeleton\SkeletonClass
 */
class MPesaFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mpesa';
    }
}
