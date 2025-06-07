# Put chunks of your Blade template into immutable static cache files

[![Latest Version on Packagist](https://img.shields.io/packagist/v/swiss-devjoy/blade-staticcache-directive.svg?style=flat-square)](https://packagist.org/packages/swiss-devjoy/blade-staticcache-directive)
[![Total Downloads](https://img.shields.io/packagist/dt/swiss-devjoy/blade-staticcache-directive.svg?style=flat-square)](https://packagist.org/packages/swiss-devjoy/blade-staticcache-directive)

Increase performance by putting chunks of your Blade template into immutable static cache files. This package provides a directive for Blade templates that allows you to easily create static cache files for specific sections of your views. With OPCache enabled, this can significantly reduce the time it takes to render your views, especially for large and complex templates.

## Installation

You can install the package via composer:

```bash
composer require swiss-devjoy/blade-staticcache-directive
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="blade-staticcache-directive-config"
```

This is the contents of the published config file:

```php
return [
    'enabled' => env('BLADE_STATICCACHE_DIRECTIVE_ENABLED', true),
    'strip_whitespace_between_tags' => env('BLADE_STATICCACHE_DIRECTIVE_STRIP_WHITESPACE_BETWEEN_TAGS', true),

    // Cache profile which generates the unique key for the cache entry
    'cache_profile' => \SwissDevjoy\BladeStaticcacheDirective\CacheProfile::class,
];
```

## Usage

```blade
This is a blade template.

@staticcache('my-cache-key')
    {{ $this->aVeryExpensiveMethod() }}
@endstaticcache
```

To clear the cache you can run the following command:

```bash
$ php artisan blade-staticcache:clear
```

To include some additional stats in your response about cached/uncached blade chunks, you can use the provided middleware:

**For laravel 11.x and newer:**

Add the middleware definition to the bootstrap app.

```php
// bootstrap/app.php


->withMiddleware(function (Middleware $middleware) {
    ...
    $middleware->web(append: [
        ...
        \SwissDevjoy\BladeStaticcacheDirective\BladeStaticcacheStatsMiddleware::class,
    ]);
})

```

**For laravel 10.x and earlier:**

Add the middleware definition to the http kernel.


```php
// app/Http/Kernel.php

...

protected $middlewareGroups = [
   'web' => [
       ...
       \SwissDevjoy\BladeStaticcacheDirective\BladeStaticcacheStatsMiddleware::class,
   ],

```

## Cache Profile

The cache profile is responsible for generating the unique key for the cache entry. By default, it uses the `\SwissDevjoy\BladeStaticcacheDirective\CacheProfile` class, which generates a key based on the cache key parameter passed to the `@staticcache` directive AND the current locale.

## Inspiration

The main idea came from a tweet (https://x.com/dgurock/status/1577314908982706176) and the following package: https://github.com/ryangjchandler/blade-cache-directive

I did some basic benchmarks with a huge template and a lot of data.

Using Ryan's package and `redis` as a cache driver, I got 85 req/s.
Using Ryan's package and `file` as a cache driver, I got 99 req/s.
Using my package, I got 110 req/s.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Dimitri König](https://github.com/dimitri-koenig)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
