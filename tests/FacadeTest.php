<?php
namespace Barryvdh\StackMiddleware\Tests;

use Barryvdh\StackMiddleware\Facade;
use Barryvdh\StackMiddleware\Tests\Stubs\FakeFacade;

class FacadeTest extends Facade
{
    public function testFacadeAccessor()
    {
        $this->assertEquals('stack', FakeFacade::publicFacadeAccessor());
    }
}