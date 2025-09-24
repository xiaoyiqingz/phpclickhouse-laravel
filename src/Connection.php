<?php

namespace PhpClickHouseLaravel;

use Tinderbox\ClickhouseBuilder\Integrations\Laravel\Connection as BaseConnection;
use PhpClickHouseLaravel\Query\Builder as QueryBuilder;
use PhpClickHouseLaravel\Query\Grammar as QueryGrammar;

class Connection extends BaseConnection
{
    /**
     * undocumented function
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        $this->useDefaultQueryGrammar();
    }

    /**
     * @return bool
     */
    public function update($query, $bindings = [])
    {
        return $this->statement($query);
    }

    public function query()
    {
        return new QueryBuilder($this);
    }

    /**
     * @return \PhpClickHouseLaravel\Query\Grammar
     */
    protected function getDefaultQueryGrammar()
    {
        return new QueryGrammar();
    }
}
