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
     * @param  string         $abstract
     * @param  Closure|string $callable
     */
    public function bind($abstract, $callable)
    {
        $this->container->bind($abstract, function() use($callable) {
            return $this->wrap($callable);
        });
    }

    /**
     * Wrap the StackPHP Middleware in a Laravel Middleware
     *
     * @param  Closure|string  $callable
     * @return ClosureMiddleware
     */
    public function wrap($callable)
    {
        $kernel = new ClosureHttpKernel();

        if (is_callable($callable)) {
            $middleware = $callable($kernel);
        } else {
            $middleware = new $callable($kernel)
        }

        return new ClosureMiddleware($kernel, $middleware);
    }
}
