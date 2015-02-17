<?php namespace Barryvdh\StackMiddleware;

use Closure;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Illuminate\Contracts\Routing\Middleware as MiddlewareInterface;

class ClosureMiddleware implements MiddlewareInterface
{
    /** @var ClosureHttpKernel $kernel */
    protected $kernel;

    /** @var HttpKernelInterface $middleware  */
    protected $middleware;

    public function __construct(ClosureHttpKernel $kernel, HttpKernelInterface $middleware){
        $this->kernel = $kernel;
        $this->middleware = $middleware;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->kernel->setClosure($next);

        return $this->middleware->handle($request);
    }
}
