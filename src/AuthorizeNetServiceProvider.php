<?php

namespace Markandrewkato\AuthorizeNet;

use Markandrewkato\AuthorizeNet\Commands\AuthorizeNetCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AuthorizeNetServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-authorize-net')
            ->hasConfigFile();
        // ->hasViews()
            // ->hasMigration('create_laravel_authorize_net_table')
            // ->hasCommand(AuthorizeNetCommand::class)
    }
}
