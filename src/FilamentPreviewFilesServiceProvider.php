<?php

namespace Matteomascellani\FilamentPreviewFiles;

use Illuminate\Support\ServiceProvider;

class FilamentPreviewFilesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/filament-preview-files.php',
            'filament-preview-files'
        );
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-preview-files');

        $this->publishes([
            __DIR__ . '/../config/filament-preview-files.php' => config_path('filament-preview-files.php'),
        ], 'filament-preview-files-config');
    }
}
