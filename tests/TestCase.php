<?php

namespace OgGeneratorTests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Statamic\Extend\Manifest;
use Statamic\Providers\StatamicServiceProvider;
use Statamic\Statamic;
use State\OgGenerator\ServiceProvider;
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
            'state/og-generator' => [
                'id'        => 'state/og-generator',
                'namespace' => 'State\\og-generator',
            ],
        ];
    }


    protected function defineDatabaseMigrations()
    {
        $this->loadLaravelMigrations();
    }
}

