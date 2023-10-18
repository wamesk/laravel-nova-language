# Laravel Nova 4 Language



## Requirements

- `laravel/nova: ^4.0`


## Installation

```bash
composer require wamesk/laravel-nova-language
```

```bash
php artisan vendor:publish --provider="Wame\LaravelNovaLanguage\PackageServiceProvider"
```

```bash
php artisan migrate
```

```bash
php artisan db:seed --class=LanguageSeeder
```

Add Policy to `./app/Providers/AuthServiceProvider.php`
```php
protected $policies = [
    'App\Models\Language' => 'App\Policies\LanguagePolicy',
];
```

## Usage

```php
Select::make(__('customer.field.language'), 'language_code')
    ->help(__('customer.field.language.help'))
    ->options(fn () => LanguageController::getListForSelect())
    ->searchable()
    ->required()
    ->rules('required')
    ->onlyOnForms(),

BelongsTo::make(__('customer.field.language'), 'language', Language::class)
    ->displayUsing(fn () => LanguageController::displayUsing($request, $this))
    ->sortable()
    ->filterable()
    ->showOnPreview()
    ->exceptOnForms()
    ->hideFromIndex(),
```
