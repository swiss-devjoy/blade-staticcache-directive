<?php

namespace SwissDevjoy\BladeStaticcacheDirective;

class CacheProfile
{
    public function getCacheKey($expression): string
    {
        return app()->getLocale().$expression;
    }
}
