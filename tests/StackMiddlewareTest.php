<?php
namespace Barryvdh\StackMiddleware\Tests;

use Barryvdh\StackMiddleware\ClosureHttpKernel;
use Barryvdh\StackMiddleware\StackMiddleware;
use PHPUnit_Framework_TestCase;

class StackMiddlewareTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $container;

    /**
     * @var \Barryvdh\StackMiddleware\StackMiddleware
     */
    protected $stackMiddleware;

    /**
     *
     */
    public function setUp()
    {
        $this->container = $this->getMock('Illuminate\Contracts\Container\Container');
        $this->stackMiddleware = new StackMiddleware($this->container);
    }

    public function testSimpleWrap()
    {
        $middlewareName = 'League\StackRobots\Robots';
        $kernelStub = $this->getMock('Symfony\Component\HttpKernel\HttpKernelInterface');
        $arg1 = 'arg1';
        $arg2 = 'arg2';

        $this->container->expects($this->once())
            ->method('make')
            ->with(
                $this->equalTo($middlewareName),
                $this->equalTo([new ClosureHttpKernel(), $arg1, $arg2])
            )->will($this->returnValue($kernelStub));

        $result = $this->stackMiddleware->wrap($middlewareName, [$arg1, $arg2]);

        $this->assertNotInstanceOf('Barryvdh\StackMiddleware\TerminableClosureMiddleware', $result);
        $this->assertInstanceOf('Barryvdh\StackMiddleware\ClosureMiddleware', $result);
    }

    public function testAdvancedWrapWithTerminableInterface()
    {
        $kernelStub = $this->getMock('Barryvdh\StackMiddleware\Tests\Stubs\FakeTerminableKernel');

        $result = $this->stackMiddleware->wrap(function ($kernel) use ($kernelStub) {
            $this->assertInstanceOf('Barryvdh\StackMiddleware\ClosureHttpKernel', $kernel);
            return $kernelStub;
        });

        $this->assertInstanceOf('Barryvdh\StackMiddleware\TerminableClosureMiddleware', $result);
    }
}