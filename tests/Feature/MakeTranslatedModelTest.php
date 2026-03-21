<?php

afterEach(function () {
    @unlink(app_path('Models/Product.php'));
    @unlink(app_path('Models/Translations/ProductTranslation.php'));

    foreach (glob(database_path('migrations/*product*')) as $file) {
        @unlink($file);
    }
});

it('creates the main model file', function () {
    $this->artisan('translations:make-model', ['name' => 'Product'])
        ->assertSuccessful();

    expect(app_path('Models/Product.php'))->toBeFile();
});

it('adds HasTranslations trait to main model', function () {
    $this->artisan('translations:make-model', ['name' => 'Product']);

    expect(file_get_contents(app_path('Models/Product.php')))
        ->toContain('use HasTranslations')
        ->toContain('protected $translatable = []');
});

it('creates the translation model file', function () {
    $this->artisan('translations:make-model', ['name' => 'Product']);

    expect(app_path('Models/Translations/ProductTranslation.php'))->toBeFile();
});

it('adds fillable to translation model', function () {
    $this->artisan('translations:make-model', ['name' => 'Product']);

    expect(file_get_contents(app_path('Models/Translations/ProductTranslation.php')))
        ->toContain("'product_id'")
        ->toContain("'lang'");
});

it('creates migrations when --m is passed', function () {
    $before = glob(database_path('migrations/*.php'));

    $this->artisan('translations:make-model', ['name' => 'Product', '--m' => true]);

    $after = glob(database_path('migrations/*.php'));
    expect(count($after))->toBe(count($before) + 2); // main + translation
});

it('prefills the translation migration with the correct schema', function () {
    $this->artisan('translations:make-model', ['name' => 'Product', '--m' => true]);

    $migration = collect(glob(database_path('migrations/*.php')))
        ->first(fn ($f) => str_contains($f, 'product_translation'));

    expect(file_get_contents($migration))
        ->toContain('product_id')
        ->toContain("cascadeOnDelete")
        ->toContain("'lang'");
});