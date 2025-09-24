<?php

namespace PhpClickHouseLaravel\Query;

use Tinderbox\ClickhouseBuilder\Query\Grammar as BaseGrammar;
use Tinderbox\ClickhouseBuilder\Query\Traits\FromComponentCompiler;
use PhpClickHouseLaravel\Exceptions\GrammarException;

class Grammar extends BaseGrammar
{
    use FromComponentCompiler;

    public function compileUpdate(Builder $query, array $values)
    {
        $this->verifyFrom($query->getFrom());

        $sql = "ALTER TABLE {$this->wrap($query->getFrom()->getTable())}";

        if (!is_null($query->getOnCluster())) {
            $sql .= " ON CLUSTER {$query->getOnCluster()}";
        }

        $sql .= $this->compileUpdateValues($values);

        if (!is_null($query->getWheres()) && !empty($query->getWheres())) {
            $sql .= " {$this->compileWheresComponent($query,$query->getWheres())}";
        } else {
            throw GrammarException::missedWhereForUpdate();
        }

        return $sql;
    }

    /**
     * compile array values to (UPDATE ...) string
     *
     * @return string
     */
    public function compileUpdateValues(array $values)
    {
        if (empty($values)) {
            throw GrammarException::missedUpdateValues();
        }

        $arrToStr = implode(
            ' , ',
            array_map(
                function ($v, $k) {
                    return $k . ' = ' . $this->wrap($v);
                },
                $values,
                array_keys($values)
            )
        );

        $sql = ' UPDATE ' . $arrToStr;
        return $sql;
    }

    /**
     *  Get the format for database stored dates.
     *
     * @return string
     */
    public function getDateFormat()
    {
        return 'Y-m-d H:i:s';
    }
}
