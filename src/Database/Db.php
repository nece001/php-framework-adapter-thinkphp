<?php

namespace Nece\Framework\Adapter\Database;

use Nece\Framework\Adapter\Contract\Database\IDbManater;
use think\facade\Db as FacadeDb;

/**
 * Db门面适配类
 */
class Db implements IDbManater
{
    /**
     * @inheritDoc
     */
    public static function raw($value)
    {
        return FacadeDb::raw($value);
    }

    /**
     * @inheritDoc
     */
    public static function rawFunc(string $func, string $field, string $alias)
    {
        return self::raw("{$func}({$field}) as {$alias}");
    }

    /**
     * @inheritDoc
     */
    public static function rawCount(string $field, string $alias)
    {
        return self::rawFunc('count', $field, $alias);
    }

    /**
     * @inheritDoc
     */
    public static function rawSum(string $field, string $alias)
    {
        return self::rawFunc('sum', $field, $alias);
    }

    /**
     * @inheritDoc
     */
    public static function rawAvg(string $field, string $alias)
    {
        return self::rawFunc('avg', $field, $alias);
    }

    /**
     * @inheritDoc
     */
    public static function rawMin(string $field, string $alias)
    {
        return self::rawFunc('min', $field, $alias);
    }

    /**
     * @inheritDoc
     */
    public static function rawMax(string $field, string $alias)
    {
        return self::rawFunc('max', $field, $alias);
    }

    /**
     * @inheritDoc
     */
    public static function startTrans()
    {
        FacadeDb::startTrans();
    }

    /**
     * @inheritDoc
     */
    public static function commit()
    {
        FacadeDb::commit();
    }

    /**
     * @inheritDoc
     */
    public static function rollback()
    {
        FacadeDb::rollback();
    }

    /**
     * @inheritDoc
     */
    public static function transaction(callable $callback)
    {
        return FacadeDb::transaction($callback);
    }

    /**
     * @inheritDoc
     */
    public static function execute(string $sql)
    {
        return FacadeDb::execute($sql);
    }
}
