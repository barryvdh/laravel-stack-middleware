<?php
namespace Barryvdh\StackMiddleware\Tests\Stubs;

class FakeClosure
{
    public $args;
    public $returned = 'fake closure called';

    public function __invoke()
    {
        $this->args = func_get_args();
        return $this->returned;
    }
}