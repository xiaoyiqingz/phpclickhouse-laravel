<?php

namespace PhpClickHouseLaravel\Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            'PhpClickHouseLaravel\ClickhouseServiceProvider',
        ];
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set(
            'database.connections.clickhouse',
            [
                "driver" => "clickhouse",
                "host" => "localhost",
                "port" => "8123",
                "database" => "trade",
                "username" => "default",
                "password" => "test",
                "timeout_connect" => "2",
                "timeout_query" => "2",
                "https" => false,
                "retries" => 0,
                "name" => "clickhouse",
            ]
        );
    }
}
