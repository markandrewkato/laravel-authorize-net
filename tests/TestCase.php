<?php

namespace Markandrewkato\AuthorizeNet\Tests;

use Markandrewkato\AuthorizeNet\AuthorizeNetServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        /*
        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Markandrewkato\\AuthorizeNet\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
        */
    }

    protected function getPackageProviders($app)
    {
        return [
            AuthorizeNetServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        /*
        include_once __DIR__.'/../database/migrations/create_laravel_authorize_net_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }
}
