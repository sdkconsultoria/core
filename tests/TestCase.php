<?php

namespace Sdkconsultoria\Core\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Sdkconsultoria\Core\ServiceProvider;

abstract class TestCase extends Orchestra
{
    protected static $migration;
    protected static $customMigration;

    public function setUp(): void
    {
        parent::setUp();

        if (! self::$migration) {
            $this->loadLaravelMigrations(['--database' => 'testbench']);
            self::$customMigration = true;
        }
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');

        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }
}
