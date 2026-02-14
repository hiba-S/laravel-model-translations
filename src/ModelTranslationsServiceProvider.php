<?php

namespace HibaSabouh\ModelTranslations;

use Illuminate\Support\ServiceProvider;

class ModelTranslationsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Merge package config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/translatable.php',
            'translatable'
        );
    }

    public function boot(): void
    {
        // Publish config
        $this->publishes([
            __DIR__ . '/../config/translatable.php' => config_path('translatable.php'),
        ], 'translatable-config');
    }
}
