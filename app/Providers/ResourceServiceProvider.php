<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ResourceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $path         = base_path() . '/app/Services';
        $dir_iterator = new RecursiveDirectoryIterator($path);
        $iterator     = new RecursiveIteratorIterator($dir_iterator);
        $offset       = strlen(base_path() . '/app/');

        foreach ($iterator as $file) {
            if ($file->isDir()) {
                continue;
            }
            $namespace = 'App/' . substr($file->getPathname(), $offset, -4);
            $name      = last(explode('/', $namespace));
            $this->app->singleton($name, str_replace('/', '\\', $namespace));
        }
    }
}
