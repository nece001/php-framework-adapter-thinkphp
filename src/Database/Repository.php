<?php

namespace Nece\Framework\Adapter\Database;

use Nece\Framework\Adapter\Contract\DataBase\IQuery;
use Nece\Framework\Adapter\Contract\DataBase\IRepository;
use Nece\Framework\Adapter\Database\Db;

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

    protected function findWithModel($model, $value)
    {
        if (is_array($value)) {
            return $model->where($value)->find();
        }
        return $model::find($value);
    }

    protected function updateWithModel($model, array $where, array $data, $comment = '')
    {
        $query = $model->where($where);
        if ($comment) {
            $query->comment($comment);
        }
        $query->update($data);
    }

    protected function saveWithModel($model, array $data)
    {
        $model->save($data);
    }

    protected function deleteWithModel($model, array $where)
    {
        $class = get_class($model);
        $class::destroy(function ($query) use ($where) {
            $query->where($where);
        });
    }

    protected function queryWithModel($model, $alias = '')
    {
        return Db::table($model->getTable(), $alias);
    }
}
