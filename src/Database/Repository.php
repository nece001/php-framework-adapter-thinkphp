<?php

namespace Nece\Framework\Adapter\Database;

use Nece\Framework\Adapter\Contract\DataBase\IModel;
use Nece\Framework\Adapter\Contract\DataBase\IRepository;
use Nece\Framework\Adapter\Contract\DataBase\DbRepository;
use Nece\Framework\Adapter\Contract\DataBase\IQuery;
use Nece\Framework\Adapter\Database\Db;

/**
 * 数据库仓储基类
 *
 * @author nece001@163.com
 * @create 2025-11-09 17:09:11
 */
abstract class Repository extends DbRepository implements IRepository
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

    protected function createModel(): IModel
    {
        $modelName = $this->getModelName();
        $model = new $modelName();

        // 提取模型可用的全局作用域
        $available_scopes = [];
        foreach (self::$model_global_scopes as $name => $scopes) {
            if ($model instanceof $name) {
                $available_scopes = array_merge($available_scopes, $scopes);
            }
        }

        $model->setRepositoryGlobalScope($available_scopes);
        return $model;
    }

    public function query(string $alias = ''): IQuery
    {
        $model = $this->createModel();
        return $model->newQuery($alias);
    }
}
