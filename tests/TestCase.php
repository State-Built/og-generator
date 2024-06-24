<?php

namespace OgWallyTests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Statamic\Extend\Manifest;
use Statamic\Providers\StatamicServiceProvider;
use Statamic\Statamic;
use State\OgWally\ServiceProvider;
use Intervention\Image\ImageServiceProvider;


class TestCase extends OrchestraTestCase
{

    protected function getPackageProviders($app)
    {
        return [
            StatamicServiceProvider::class,
            ServiceProvider::class,
            ImageServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Statamic' => Statamic::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app->make(Manifest::class)->manifest = [
            'state/og-wally' => [
                'id'        => 'state/og-wally',
                'namespace' => 'State\\OgWally',
            ],
        ];
    }


    protected function defineDatabaseMigrations()
    {
        $this->loadLaravelMigrations();
    }
}

