# Filament Factory Action

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codewithdennis/filament-factory-action.svg?style=flat-square)](https://packagist.org/packages/codewithdennis/filament-factory-action)
[![Total Downloads](https://img.shields.io/packagist/dt/codewithdennis/filament-factory-action.svg?style=flat-square)](https://packagist.org/packages/codewithdennis/filament-factory-action)


This plugin introduces a new action to the Filament admin panel table, allowing you to effortlessly generate records for your database tables based on your Laravel Factory definitions.

## Installation
You can install the package via composer:

```bash
composer require codewithdennis/filament-factory-action
```

## Usage Example

Prior to utilizing this action, it is essential to ensure that you have set up a [factory](https://laravel.com/docs/10.x/eloquent-factories) for your model.

```php
class ProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'is_public' => rand(0, 1),
        ];
    }
}
````

Suppose you already possess a `ProfileResource` within the Filament framework. You can integrate the action into the ListProfiles class, as demonstrated in the following example.

```php
use App\Filament\Resources\ProfileResource;
use CodeWithDennis\FactoryAction\FactoryAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfiles extends ListRecords
{
    protected static string $resource = ProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            FactoryAction::make(),
            Actions\CreateAction::make()
        ];
    }
}
```

## Showcase
https://github.com/CodeWithDennis/filament-factory-action/assets/23448484/6d011505-eb39-417a-b8ad-ecad59c67d73


## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [CodeWithDennis](https://github.com/CodeWithDennis)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
