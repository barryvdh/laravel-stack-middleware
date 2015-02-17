## Stack Middleware for Laravel 5

> Note: This package is still very alpha!

Laravel 4 used [HttpKernelInterface Middlewares](http://stackphp.com/middlewares/) for its Middleware, but Laravel 5 uses a new way.
This package provides a way to wrap StackPHP Middleware so it can be used with Laravel 5

First, require this package in composer.json and run `composer update`

    "barryvdh/laravel-stack-middleware": "0.1.x@dev"

After updating, add the ServiceProvider to the array of providers in config/app.php

    'Barryvdh\StackMiddleware\ServiceProvider',

### Usage

A Stack Middleware usually needs a Kernel. We can't use the real Kernel, so this package provides a one.
When you use the `wrap` or `bind` method on the `Barryvdh\StackMiddleware\Wrapper`, you can provide a closure.
The kernel will be the first argument.

You can access the Wrapper under the `stack` key in the Container, or with the Facade (`Barryvdh\StackMiddleware\Facade`). It can also be typehinted directly.

```php
// Wrap and bind
$stack = App::make('stack');
$middleware = $stack->wrap(function ($kernel) {
    return new \League\StackRobots\Robots($kernel, 'production', 'APP_ENV');
});
App::instance('AddRobotsHeaders', $middleware);

// Or directly bind it
app('stack')->bind('AddRobotsHeaders', function ($kernel) {
    return new \League\StackRobots\Robots($kernel, 'production', 'APP_ENV');
});
```

You can also use a string to let the Laravel Container resolve the class, including extra parameters.
The Kernel is prepended by the wrapper automatically.

```php
app('stack')->bind('AddRobotsHeaders', 'League\StackRobots\Robots', ['production', 'APP_ENV']);
```

This will bind the new Laravel compatible middleware as `AddRobotsHeaders` so you can use it in your Kernel.

### Examples & Implementations

 - [StackRobots](https://github.com/thephpleague/stack-robots): Just require and use examples from above.
 - [HttpCache](http://symfony.com/doc/current/book/http_cache.html): https://github.com/barryvdh/laravel-httpcache

### More information
For more information, read the [StackPHP website](http://stackphp.com/).
