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

    /**
     * @inheritdoc
     *
     */
    protected function setKeysForSaveQuery($query)
    {
        if ($this->keyType != 'array') {
            return parent::setKeysForSaveQuery($query);
        }

        return $this->setArrayKeysForSaveQuery($query);
    }

    protected function setArrayKeysForSaveQuery($query)
    {
        foreach ($this->getKeyName() as $keyName) {
            $query->where($keyName, '=', $this->original[$keyName]);
        }

        return $query;
    }
}
