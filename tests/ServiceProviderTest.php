<?php
namespace Barryvdh\StackMiddleware\Tests;

use Barryvdh\StackMiddleware\ServiceProvider;
use PHPUnit_Framework_TestCase;

class ServiceProviderTest extends TestCase
{

    protected $app;

    /**
     * @var \Barryvdh\StackMiddleware\ServiceProvider
     */
    protected $serviceProvider;

    /**
     * Set up the test.
     */
    public function setUp(): void
    {
        $this->app = $this->getMockBuilder('Illuminate\Contracts\Container\Container')
            ->getMock();
        $this->serviceProvider = new ServiceProvider($this->app);
    }

    /**
     * Test the register method.
     */
    public function testRegister()
    {
        $this->app->expects($this->once())
            ->method('alias')
            ->with($this->equalTo('stack'), 'Barryvdh\StackMiddleware\StackMiddleware');
        $this->app->expects($this->once())
            ->method('bind')
            ->with('stack', $this->callback(function ($cb) {
                $this->assertInstanceOf('Barryvdh\StackMiddleware\StackMiddleware', $cb());
                return true;
            }));

        $this->serviceProvider->register();
    }
}
