<?php

namespace PhpClickHouseLaravel\Exceptions;

use Tinderbox\ClickhouseBuilder\Exceptions\GrammarException as BaseGrammarException;

class GrammarException extends BaseGrammarException
{
    public static function missedUpdateValues()
    {
        return new static("update values can not be exmpty");
    }

    public static function missedWhereForUpdate()
    {
        return new static('Missed where section for update statement.');
    }
}
