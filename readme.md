## Stack Middleware for Laravel 5

> Note: This package is still very alpha! Read [this blogpost](http://barryvdh.nl/laravel/2015/02/18/using-stackphp-middleware-in-laravel-5/) for more information

Laravel 4 used [HttpKernelInterface Middlewares](http://stackphp.com/middlewares/) for its Middleware, but Laravel 5 uses a new way.
This package provides a way to wrap StackPHP Middleware so it can be used with Laravel 5

First, require this package in composer.json and run `composer update`

    "barryvdh/laravel-stack-middleware": "0.2.x@dev"

After updating, add the ServiceProvider to the array of providers in config/app.php

    'Barryvdh\StackMiddleware\ServiceProvider',

### Usage

A Stack Middleware usually needs a Kernel. We can't use the real Kernel, so this package provides a one. 
You can use the `bind` method to wrap a Stack (HttpKernelInterface) middleware and register it in the App container.
You can access the StackMiddleware class under the `stack` key in the Container, or with the Facade (`Barryvdh\StackMiddleware\Facade`). It can also be typehinted directly, eg. on the `boot()` method of a ServiceProvider.

The first argument is the new Middleware name. The second is either:
 - A closure, which gets the new Kernel as first parameter.
 - The name of the class to resolve with the App container. Parameters can be provided as an array as the third argument. The Kernel is prepended to that array, so it's always injected as first argument.

```php
app('stack')->bind('AddRobotsHeaders', 'League\StackRobots\Robots', ['production', 'APP_ENV']);
```

```php
use League\StackRobots\Robots;
use Barryvdh\StackMiddleware\StackMiddleware;

public function boot(StackMiddleware $stack) {
    $stack->bind('AddRobotsHeaders', function($kernel) {
        return new Robots($kernel, 'production', 'APP_ENV');
    });
}
```  

Both examples have the same result, you can now add `AddRobotsHeaders` to the $middleware list in Kernel.php

If you want to use the Facade, you can add that to your config/app.php. You can then use `Stack::bind(...)` instead.

```php
    'Stack' => 'Barryvdh\StackMiddleware\Facade',
``` 

### Examples & Implementations

 - [StackRobots](https://github.com/thephpleague/stack-robots): Just require and use examples from above.
 - [HttpCache](http://symfony.com/doc/current/book/http_cache.html): https://github.com/barryvdh/laravel-httpcache

### More information
For more information, read the [StackPHP website](http://stackphp.com/).

### License
[MIT](LICENSE)
