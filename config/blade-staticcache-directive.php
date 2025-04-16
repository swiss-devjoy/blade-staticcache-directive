<?php

return [
    'enabled' => env('BLADE_STATICCACHE_DIRECTIVE_ENABLED', true),

    // Cache profile which generates the unique key for the cache entry
    'cache_profile' => \SwissDevjoy\BladeStaticcacheDirective\CacheProfile::class,
];
