<?php

namespace PhpClickHouseLaravel\Eloquent;

use Illuminate\Database\Eloquent\Builder as BaseBuilder;

class Builder extends BaseBuilder
{
    /**
     * @param $query
     */
    public function __construct($query)
    {
        $this->query = $query;
    }
}
