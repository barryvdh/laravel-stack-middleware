<?php
namespace Barryvdh\StackMiddleware\Tests;

use Barryvdh\StackMiddleware\TerminableClosureMiddleware;
use PHPUnit_Framework_TestCase;

class TerminableClosureMiddlewareTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ClosureMiddleware
     */
    protected $middleware;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $closureKernelMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $httpKernelInterface;

    /**
     * Set up method.
     */
    public function setUp()
    {
        //$reflector = new \ReflectionClass('Symfony\Component\HttpKernel\KernelInterface');
        //$methods = array_map(function (\ReflectionMethod $method) {
        //    return $method->getName();
        //}, $reflector->getMethods());

        $this->closureKernelMock = $this->getMock('Barryvdh\StackMiddleware\ClosureHttpKernel');
        $this->httpKernelInterface = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')
            ->setMethods(['handle', 'terminate'])->getMock();

        $this->middleware = new TerminableClosureMiddleware($this->closureKernelMock, $this->httpKernelInterface);
    }

    /**
     * Test that Laravel's terminate method passes on stuff to the terminate method of the middleware.
     */
    public function testTerminateProxiesToMiddleware()
    {
        $requestStub = $this->getMock('Symfony\Component\HttpFoundation\Request');
        $responseStub = $this->getMock('Symfony\Component\HttpFoundation\Response');

        $this->httpKernelInterface->expects($this->once())
            ->method('terminate')
            ->with($this->equalTo($requestStub), $this->equalTo($responseStub))
            ->will($this->returnValue($responseStub));

        $this->middleware->terminate($requestStub, $responseStub);
    }
}