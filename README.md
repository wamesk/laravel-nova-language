# Laravel Nova Language



## Requirements

- `laravel/nova: ^5.0`


## Installation

```bash
composer require wamesk/laravel-nova-language
```

```bash
php artisan migrate
```

```bash
php artisan db:seed --class=LanguageSeeder
```

## Usage

```php
BelongsTo::make(__('laravel-nova-country::country.field.language'), 'language', Language::class)
    ->help(__('laravel-nova-country::country.field.language.help'))
    ->withoutTrashed()
    ->sortable()
    ->filterable()
    ->required()
    ->showOnPreview(),
```
