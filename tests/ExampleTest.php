<?php

namespace Sdkconsultoria\Core\Tests;

use Orchestra\Testbench\TestCase;

class ExampleTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');

        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    public function test_the_application_returns_a_successful_response()
    {
        $this->loadLaravelMigrations(['--database' => 'testbench']);
    }
}
