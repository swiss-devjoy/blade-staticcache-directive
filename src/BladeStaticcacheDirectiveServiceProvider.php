<?php

namespace SwissDevjoy\BladeStaticcacheDirective;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BladeStaticcacheDirectiveServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('blade-staticcache-directive')
            ->hasConfigFile()
            ->hasCommand(BladeStaticcacheClearCommand::class);
    }

    public function packageBooted(): void
    {
        $this->app->singleton('blade-staticcache', BladeStaticcacheDirective::class);
        $this->app->singleton('blade-staticcache-cache-profile', config('blade-staticcache-directive.cache_profile'));

        Blade::directive('staticcache', fn ($expression) => app('blade-staticcache')->staticcache($expression));
        Blade::directive('endstaticcache', fn () => app('blade-staticcache')->endstaticcache());
    }
}
