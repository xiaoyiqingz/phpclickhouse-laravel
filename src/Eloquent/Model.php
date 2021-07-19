<?php

namespace PhpClickHouseLaravel\Eloquent;

use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel
{
    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * @inheritdoc
     *
     * @return Builder
     */
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}
