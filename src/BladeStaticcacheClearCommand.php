<?php

namespace SwissDevjoy\BladeStaticcacheDirective;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class BladeStaticcacheClearCommand extends Command
{
    public $signature = 'blade-staticcache:clear';

    public $description = 'Clears all cache files for the Blade Staticcache directive';

    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    public function handle(): int
    {
        $path = config('view.compiled');

        foreach ($this->files->glob("{$path}/blade-staticcache-*") as $view) {
            $this->files->delete($view);
        }

        $this->info('Compiled views cleared successfully.');

        return self::SUCCESS;
    }
}
