<?php

use Illuminate\Support\Facades\Artisan;

beforeEach(function () {
    Artisan::call('view:clear');
});

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

it('works if enabled', function () {
    $initialRunValue = $this->renderCacheView();
    $secondRunValue = $this->renderCacheView();

    $this->assertEquals($initialRunValue, $secondRunValue);
});

it('does not work if disabled', function () {
    config(['blade-staticcache-directive.enabled' => false]);

    $initialRunValue = $this->renderCacheView();
    $secondRunValue = $this->renderCacheView();

    $this->assertNotEquals($initialRunValue, $secondRunValue);
});

it('works with default cache key profile', function () {
    app()->setLocale('en');
    $valueForEnglish = $this->renderCacheView();

    app()->setLocale('de');
    $valueForGerman = $this->renderCacheView();

    $this->assertNotEquals($valueForEnglish, $valueForGerman);
});

it('returns stats as headers when stats middleware is used', function () {
    app()->setLocale('en');
    $this->renderCacheView();
    $this->renderCacheView();
    $this->renderCacheView();

    app()->setLocale('de');
    $this->renderCacheView();
    $this->renderCacheView();

    $responseHeaders = $this->get('/middleware-test')->headers;
    $cachedChunks = $responseHeaders->get('X-BladeStaticcache-Cached');
    $uncachedChunks = $responseHeaders->get('X-BladeStaticcache-Uncached');

    $this->assertEquals(2, $uncachedChunks);
    $this->assertEquals(3, $cachedChunks);
});

it('clears the cache when clear cache command is run', function () {
    $initialRunValue = $this->renderCacheView();

    Artisan::call('blade-staticcache:clear');

    $secondRunValue = $this->renderCacheView();

    $this->assertNotEquals($initialRunValue, $secondRunValue);

    $responseHeaders = $this->get('/middleware-test')->headers;
    $cachedChunks = $responseHeaders->get('X-BladeStaticcache-Cached');
    $uncachedChunks = $responseHeaders->get('X-BladeStaticcache-Uncached');

    $this->assertEquals(2, $uncachedChunks);
    $this->assertEquals(0, $cachedChunks);
});
