<?php

namespace SwissDevjoy\BladeStaticcacheDirective\Tests;

use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as Orchestra;
use SwissDevjoy\BladeStaticcacheDirective\BladeStaticcacheDirectiveServiceProvider;
use SwissDevjoy\BladeStaticcacheDirective\BladeStaticcacheStatsMiddleware;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            BladeStaticcacheDirectiveServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('view.paths', [__DIR__.'/resources/views']);

        Route::any('/middleware-test', ['middleware' => BladeStaticcacheStatsMiddleware::class, fn () => '']);
    }

    protected function renderCacheView()
    {
        return trim((string) view('cache'));
    }
}
