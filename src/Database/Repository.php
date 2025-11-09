<?php

namespace Nece\Framework\Adapter\Database;

use Nece\Framework\Adapter\Contract\DataBase\IModel;
use Nece\Framework\Adapter\Contract\DataBase\IQuery;
use Nece\Framework\Adapter\Contract\DataBase\IRepository;
use Nece\Framework\Adapter\Database\Db;

/**
 * 数据库仓储基类
 *
 * @author nece001@163.com
 * @create 2025-11-09 17:09:11
 */
abstract class Repository implements IRepository
{
    /**
     * @inheritDoc
     */
    public function transaction(callable $callback)
    {
        return Db::transaction($callback);
    }

    /**
     * @inheritDoc
     */
    public function startTrans(): void
    {
        Db::startTrans();
    }

    /**
     * @inheritDoc
     */
    public function commit(): void
    {
        Db::commit();
    }

    /**
     * @inheritDoc
     */
    public function rollback(): void
    {
        Db::rollback();
    }

    public function createModel(): IModel
    {
        $class = $this->getModelName();
        return new $class();
    }

    public function find(array $where)
    {
        $model = $this->getModelName()::where($where)->select();
        if (!$model) {
            return null;
        }
        return $this->getEntityName()::buildFromData($model->toArray());
    }

    public function findById($id)
    {
        $model = $this->query()->find($id);
        if (!$model) {
            return null;
        }
        return $this->getEntityName()::buildFromData($model->toArray());
    }

    public function delete($entity)
    {
        $model_name = $this->getModelName();
        $model_name::destroy($entity->getId());
        $entity->emitEvents();
    }

    public function save($entity): void
    {
        $id = $entity->getId();
        $model = null;
        $query = $this->query();
        if ($id) {
            $model = $query->find($id);
        }
        if (!$model) {
            $model = $this->createModel();
        }

        $model->fill($entity->toSaveArray());
        $model->save();
        $entity->setId($model->id);
        $entity->emitEvents();
    }

    /**
     * 新建查询
     *
     * @author nece001@163.com
     * @create 2025-11-09 16:42:19
     *
     * @param string $alias
     * @return IQuery
     */
    public function query(string $alias = ''): IQuery
    {
        $query = $this->getModelName()::field([]); // 创建一个空的查询对象
        if ($alias) {
            $query->alias($alias);
        }

        return new Query($query);
    }
}
