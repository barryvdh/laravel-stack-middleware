<?php
namespace Barryvdh\StackMiddleware\Tests\Stubs;

use Barryvdh\StackMiddleware\Facade;

class FakeFacade extends Facade
{
    public static function publicFacadeAccessor()
    {
        return self::getFacadeAccessor();
    }
}