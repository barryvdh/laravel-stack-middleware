<?php namespace Barryvdh\StackMiddleware;

use Closure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ClosureHttpKernel implements HttpKernelInterface
{
    /** @var Closure $closure */
    protected $closure;

    /**
     * @param Closure $closure
     */
    public function setClosure(Closure $closure)
    {
        $this->closure = $closure;
    }

    /**
     * @param Request $request A Request instance
     * @param int     $type
     * @param bool    $catch
     *
     * @return Response A Response instance
     */
    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        $closure = $this->closure;
        return $closure($request);
    }
}
