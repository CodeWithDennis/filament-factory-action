<?php

namespace CodeWithDennis\FactoryAction;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FactoryActionServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-factory-action';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToStarRepoOnGitHub('codewithdennis/filament-factory-action');
            });
    }
}
