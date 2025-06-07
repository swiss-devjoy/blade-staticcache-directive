<?php

return [
    'enabled' => env('BLADE_STATICCACHE_DIRECTIVE_ENABLED', true),
    'strip_whitespace_between_tags' => env('BLADE_STATICCACHE_DIRECTIVE_STRIP_WHITESPACE_BETWEEN_TAGS', true),

    // Cache profile which generates the unique key for the cache entry
    'cache_profile' => \SwissDevjoy\BladeStaticcacheDirective\CacheProfile::class,
];
