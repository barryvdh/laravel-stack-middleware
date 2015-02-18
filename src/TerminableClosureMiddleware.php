<?php namespace Barryvdh\StackMiddleware;

use Illuminate\Contracts\Routing\TerminableMiddleware;

class TerminableClosureMiddleware extends ClosureMiddleware implements TerminableMiddleware
{
    /**
	 * Perform any final actions for the request lifecycle.
	 *
	 * @param  \Symfony\Component\HttpFoundation\Request  $request
	 * @param  \Symfony\Component\HttpFoundation\Response  $response
	 * @return void
	 */
    public function terminate($request, $response)
    {
         $this->middleware->terminate($request, $response);
    }
}
