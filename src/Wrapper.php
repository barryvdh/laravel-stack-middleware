<?php namespace Barryvdh\StackMiddleware;

use Closure;
use Illuminate\Contracts\Container\Container;

class Wrapper
{
    /** @var Container $container */
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Wrap and register the middleware in the Container
     *
     * @param  $abstract
     * @param  Closure $callable
     */
    public function bind($abstract, Closure $callable)
    {
        $this->container->bind($abstract, function() use($callable) {
            return $this->wrap($callable);
        });
    }

    /**
     * Wrap the StackPHP Middleware in a Laravel Middleware
     *
     * @param  Closure $callable
     * @return ClosureMiddleware
     */
    public function wrap(Closure $callable)
    {
        $kernel = new ClosureHttpKernel();
        $middleware = $callable($kernel);

        return new ClosureMiddleware($kernel, $middleware);
    }
}
