# Filament Factory Action

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codewithdennis/filament-factory-action.svg?style=flat-square)](https://packagist.org/packages/codewithdennis/filament-factory-action)
[![Total Downloads](https://img.shields.io/packagist/dt/codewithdennis/filament-factory-action.svg?style=flat-square)](https://packagist.org/packages/codewithdennis/filament-factory-action)

![Filament Factory Action](https://github.com/CodeWithDennis/filament-factory-action/assets/23448484/31b5f00f-f10b-42f5-b18d-ca75e8a458f7)

This plugin adds a new feature to the Filament admin panel table, enabling easy generation of test records for your database tables using your Laravel Factory definitions.

_This plugin extends the standard Filament action, ensuring that you can continue to utilize all the actions that are typically available within the action class_

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
            FactoryAction::make()
                ->color('danger')
                // ->slideOver()
                ->icon('heroicon-o-wrench'),
            Actions\CreateAction::make()
        ];
    }
}
```

## Showcase
https://github.com/CodeWithDennis/filament-factory-action/assets/23448484/6d011505-eb39-417a-b8ad-ecad59c67d73

https://github.com/CodeWithDennis/filament-factory-action/assets/23448484/3ac2405a-8681-4d6a-a1df-0f18609f453e



## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [CodeWithDennis](https://github.com/CodeWithDennis)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
