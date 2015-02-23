<?php
namespace Barryvdh\StackMiddleware\Tests\Stubs;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\TerminableInterface;

abstract class FakeTerminableKernel implements HttpKernelInterface, TerminableInterface
{
}