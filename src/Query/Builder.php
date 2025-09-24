<?php

namespace PhpClickHouseLaravel\Query;

use Tinderbox\ClickhouseBuilder\Integrations\Laravel\Builder as BaseBuilder;
use PhpClickHouseLaravel\Connection;
use Illuminate\Support\Arr;

class Builder extends BaseBuilder
{
    public function __construct(
        Connection $connection,
    ) {
        $this->connection = $connection;
        $this->grammar = $connection->getQueryGrammar();
    }

    /**
     * Execute the query as a "select" statement.
     * @todo in collection the data is array not object
     *
     * @param  array|string  $columns
     * @return \Illuminate\Support\Collection
     */
    public function get($cloumns = ['*'])
    {
        return collect(
            $this->onceWithColumns(
                Arr::wrap($cloumns),
                function () {
                    if (!empty($this->async)) {
                        return $this->connection->selectAsync($this->toAsyncQueries());
                    } else {
                        return $this->connection->select($this->toSql(), [], $this->getFiles());
                    }
                }
            )
        );
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

    public function first($columns = ['*'])
    {
        return $this->limit(1)->get($columns)->first();
    }

    public function value($column)
    {
        $result = (array)$this->first([$column]);

        return count($result) > 0 ? reset($result) : null;
    }

    public function pluck(string $column, ?string $key = null)
    {
        $result = $this->get(is_null($key) ? [$column] : [$column, $key]);

        return $result->pluck($column, $key);
    }

    protected function onceWithColumns($columns, $callback)
    {
        $original = $this->columns;

        if (empty($original)) {
            $this->columns = $this->processColumns($columns);
        }

        $result = $callback();

        $this->columns = $original;

        return $result;
    }
}
