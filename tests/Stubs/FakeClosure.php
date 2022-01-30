<?php
namespace Barryvdh\StackMiddleware\Tests\Stubs;

use Symfony\Component\HttpFoundation\Response;

class FakeClosure
{
    public $args;
    public $returned = 'fake closure called';

    public function __invoke()
    {
        $this->args = func_get_args();
        return new Response($this->returned);
    }
}