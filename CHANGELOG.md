# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-02-15

### Added
- `HasTranslations` trait for database-driven model translations
- Auto-resolve translation model by convention (`{Model}Translation` in `Translations` sub-namespace)
- Override translation model via `$translationModel` property
- `translations()` HasMany relationship
- `auto_load` global scope to automatically eager load translations
- Locale-aware magic accessor via `__get()` with configurable fallback strategy (`null`, `app`, `first`)
- `{attribute}_translations` accessor to retrieve all translations keyed by locale
- `createWithTranslations()` static method
- `updateWithTranslations()` instance method
- `firstOrCreateWithTranslations()` static method
- `updateOrCreateWithTranslations()` static method
- `whereTranslation()` query scope (locale-specific, supports operators)
- `whereAnyTranslation()` query scope (all locales, supports operators)
- `orWhereTranslation()` query scope
- `orWhereAnyTranslation()` query scope
- Publishable config file (`config/translatable.php`)
- Support for Laravel 10, 11, and 12