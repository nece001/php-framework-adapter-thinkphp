<?php

namespace Nece\Framework\Adapter\Database;

use Nece\Framework\Adapter\Contract\DataBase\IRepository;
use think\facade\Db;

abstract class Repository implements IRepository
{
    /**
     * @inheritDoc
     */
    public static function transaction(callable $callback)
    {
        return Db::transaction($callback);
    }

    /**
     * @inheritDoc
     */
    public static function startTrans()
    {
        return Db::startTrans();
    }

    /**
     * @inheritDoc
     */
    public static function commit()
    {
        return Db::commit();
    }

    /**
     * @inheritDoc
     */
    public static function rollback()
    {
        return Db::rollback();
    }
}
