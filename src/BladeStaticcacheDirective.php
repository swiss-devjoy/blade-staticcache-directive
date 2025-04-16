<?php

namespace SwissDevjoy\BladeStaticcacheDirective;

class BladeStaticcacheDirective
{
    public int $cachedChunks = 0;

    public int $uncachedChunks = 0;

    public function staticcache($expression): string
    {
        return "<?php
                \$__cache_directive_key = md5(app('blade-staticcache-cache-profile')->getCacheKey($expression));
                \$__cache_directive_file = config('view.compiled') . '/blade-staticcache-' . \$__cache_directive_key . '.php';

                if (config('blade-staticcache-directive.enabled') && \File::exists(\$__cache_directive_file)) {
                    app('blade-staticcache')->cachedChunks++;
                    include(\$__cache_directive_file);
                } else {
                    app('blade-staticcache')->uncachedChunks++;

                    ob_start();
            ?>";
    }

    public function endstaticcache(): string
    {
        return '<?php
                    $__cache_directive_buffer = ob_get_clean();

                    File::put($__cache_directive_file, $__cache_directive_buffer);

                    echo $__cache_directive_buffer;

                    unset($__cache_directive_key, $__cache_directive_file, $__cache_directive_buffer);
                }
            ?>';
    }
}
