<?php
namespace Barryvdh\StackMiddleware\Tests;

use Barryvdh\StackMiddleware\ClosureHttpKernel;
use Barryvdh\StackMiddleware\Tests\Stubs\FakeClosure;
use PHPUnit_Framework_TestCase;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ClosureHttpKernelTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ClosureHttpKernel
     */
    protected $kernel;

    /**
     * Set up method
     */
    public function setUp()
    {
        $this->kernel = new ClosureHttpKernel();
    }

    /**
     * `ClosureHttpKernel` can be injected with a Closure via a setter.
     */
    public function testSetClosure()
    {
        $closure = new FakeClosure();

        $this->kernel->setClosure($closure);
    }

    /**
     * The `handle` method calls the closure.
     */
    public function testHandleCallsInjectedClosure()
    {
        $closure = new FakeClosure();
        $request = $this->getMock('Symfony\Component\HttpFoundation\Request');

        $this->kernel->setClosure($closure);
        $returned = $this->kernel->handle($request);

        $this->assertEquals([$request], $closure->args);
        $this->assertEquals($closure->returned, $returned);
    }
}