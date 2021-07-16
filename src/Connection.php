<?php

namespace PhpClickHouseLaravel;

use Tinderbox\ClickhouseBuilder\Integrations\Laravel\Connection as BaseConnection;
use PhpClickHouseLaravel\Query\Builder as QueryBuilder;

class Connection extends BaseConnection
{
    /**
     * undocumented function
     *
     * @return void
     */
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    /**
     * undocumented function
     *
     * @return void
     */
    public function update($query, $bindings = [])
    {
        return $this->statement($query);
    }

    public function query()
    {
        return new QueryBuilder($this);
    }
}
