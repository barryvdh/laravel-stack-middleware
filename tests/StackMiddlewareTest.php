<?php
namespace Barryvdh\StackMiddleware\Tests;

use Barryvdh\StackMiddleware\ClosureHttpKernel;
use Barryvdh\StackMiddleware\StackMiddleware;
use PHPUnit_Framework_TestCase;

class StackMiddlewareTest extends TestCase
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
    public function setUp():void
    {
        $this->container = $this->getMockBuilder('Illuminate\Contracts\Container\Container')
            ->getMock();
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
                $this->equalTo(['app' => new ClosureHttpKernel(), 'env' => $arg1, 'envVar' => $arg2])
            )->will($this->returnValue($kernelStub));

        $result = $this->stackMiddleware->wrap($middlewareName, ['env' => $arg1, 'envVar' => $arg2]);

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
