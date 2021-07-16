<?php

namespace PhpClickHouseLaravel\Query;

use Tinderbox\ClickhouseBuilder\Integrations\Laravel\Builder as BaseBuilder;
use PhpClickHouseLaravel\Connection;

class Builder extends BaseBuilder
{
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;

        $this->grammar = new Grammar();
    }

    /**
     * update a record in database
     *
     * @param array $values
     * @return int
     */
    public function update(array $values)
    {
        return $this->connection->update($this->grammar->compileUpdate($this, $values));
    }
}
