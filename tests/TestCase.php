<?php

namespace Barryvdh\StackMiddleware\Tests;

use Barryvdh\StackMiddleware\ServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @param \Illuminate\Foundation\Application $app
     * @return string[]
     */
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    public function getMock($className)
    {
        return $this->getMockBuilder($className)->getMock();
    }
}
