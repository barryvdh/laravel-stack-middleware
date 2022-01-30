<?php
namespace Barryvdh\StackMiddleware\Tests;

use Barryvdh\StackMiddleware\ClosureMiddleware;
use PHPUnit_Framework_TestCase;

class ClosureMiddlewareTest extends TestCase
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
    public function setUp():void
    {
        $this->closureKernelMock = $this->getMock('Barryvdh\StackMiddleware\ClosureHttpKernel');
        $this->httpKernelInterface = $this->getMock('Symfony\Component\HttpKernel\HttpKernelInterface');

        $this->middleware = new ClosureMiddleware($this->closureKernelMock, $this->httpKernelInterface);
    }

    /**
     * Test that Laravel's handle method sets the next closure and
     * calls the handle method of the http kernel implementation.
     */
    public function testHandleSetsClosureAndProxiesHandleMethod()
    {
        $requestMock = $this->getMock('Symfony\Component\HttpFoundation\Request');
        $closureStub = function () {};
        $expectedResponse = $this->getMock('Symfony\Component\HttpFoundation\Response');

        $this->closureKernelMock->expects($this->once())
            ->method('setClosure')
            ->with($closureStub);

        $this->httpKernelInterface->expects($this->once())
            ->method('handle')
            ->with($requestMock)
            ->will($this->returnValue($expectedResponse));

        $response = $this->middleware->handle($requestMock, $closureStub);

        $this->assertEquals($expectedResponse, $response);
    }
}