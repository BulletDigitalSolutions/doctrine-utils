<?php

namespace Bullet\DoctrineUtils;

use Bullet\DoctrineUtils\Commands\DoctrineUtilsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class DoctrineUtilsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('doctrine-utils')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_doctrine_utils_table')
            ->hasCommand(DoctrineUtilsCommand::class);
    }
}
