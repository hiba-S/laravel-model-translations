<?php

namespace Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use HibaSabouh\ModelTranslations\ModelTranslationsServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            ModelTranslationsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app['config']->set('translatable.auto_load', true);
        $app['config']->set('translatable.fallback', 'app');
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    protected function setUp(): void
    {
        parent::setUp();
        app()->setLocale('en');
    }

    protected function tearDown(): void
    {
        app()->setLocale('en');
        parent::tearDown();
    }
}