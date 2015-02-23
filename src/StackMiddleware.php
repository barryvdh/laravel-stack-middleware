<?php namespace Barryvdh\StackMiddleware;

use Closure;
use Illuminate\Contracts\Container\Container;
use Symfony\Component\HttpKernel\TerminableInterface;

class StackMiddleware
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
     * @param  array          $params
     */
    public function bind($abstract, $callable, $params = [])
    {
        $this->container->bind($abstract, function () use ($callable, $params) {
            return $this->wrap($callable, $params);
        });
    }

    /**
     * Wrap the StackPHP Middleware in a Laravel Middleware
     *
     * @param  Closure|string  $callable
     * @param  array           $params
     * @return ClosureMiddleware
     */
    public function wrap($callable, $params = [])
    {
        $kernel = new ClosureHttpKernel();

        if (is_callable($callable)) {
            $middleware = $callable($kernel);
        } else {
            // Add kernel as first parameter
            array_unshift($params, $kernel);
            $middleware = $this->container->make($callable, $params);
        }

        if ($middleware instanceof TerminableInterface) {
            return new TerminableClosureMiddleware($kernel, $middleware);
        }

        return new ClosureMiddleware($kernel, $middleware);
    }
}
