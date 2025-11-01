<?php

namespace Nece\Framework\Adapter\Database;

use Nece\Framework\Adapter\Contract\DataBase\IQuery;
use Nece\Framework\Adapter\Contract\DataBase\IRepository;
use Nece\Framework\Adapter\Database\Db;
use Nece\Gears\AggregateRoot;
use Nece\Gears\PagingVar;

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
        $model = $this->getModelName()::find($id);
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
        $model_name = $this->getModelName();
        if ($id) {
            $model = $model_name::find($id);
        }
        if (!$model) {
            $model = new $model_name();
        }

        $model->save($entity->toArray());
        $entity->setId($model->id);
        $entity->emitEvents();
    }

    public function fetchAll(IQuery $query)
    {
        $items = array();
        $list = $query->fetchAll();
        foreach ($list as $item) {
            $items[] = $this->buildDto($item->toArray());
        }
        return $items;
    }

    public function paginate(IQuery $query, PagingVar $paging)
    {
        $items = array();
        $list = $query->paginate($paging);
        foreach ($list as $item) {
            $items[] = $this->buildDto($item->toArray());
        }
        return $items;
    }

    public function query(string $alias = ''): IQuery
    {
        $model = $this->createModel();
        return new Query($model->getTable(), $alias);
    }

    protected function createModel()
    {
        return new ($this->getModelName());
    }

    protected function buildDto(array $data)
    {
        return new ($this->getDtoName())($data);
    }
}
