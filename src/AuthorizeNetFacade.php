<?php

namespace Markandrewkato\AuthorizeNet;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Markandrewkato\AuthorizeNet\AuthorizeNet
 */
class AuthorizeNetFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-authorize-net';
    }
}
