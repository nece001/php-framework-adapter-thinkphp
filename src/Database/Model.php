<?php

namespace Nece\Framework\Adapter\Database;

use Nece\Framework\Adapter\Contract\DataBase\IModel;
use Nece\Framework\Adapter\Contract\DataBase\IQuery;
use think\Model as ThinkModel;
use think\db\Query as DbQuery;

/**
 * ThinkPHP模型适配类
 *
 * @author nece001@163.com
 * @create 2025-11-22 17:00:42
 * 
 * @method mixed db()
 */
abstract class Model extends ThinkModel implements IModel
{
    private $repository_global_scopes = [];

    public function newQuery($alias = null): IQuery
    {
        $query = $this->db(); // 创建一个空的查询对象
        if ($alias) {
            $query->alias($alias);
        }
        $this->applyRepositoryGlobalScope($query);
        return new Query($query);
    }

    public function setRepositoryGlobalScope($scopes)
    {
        $this->repository_global_scopes = $scopes;
    }

    public function applyRepositoryGlobalScope($query)
    {
        foreach ($this->repository_global_scopes as $scope) {
            $scope->apply($query);
        }
    }

    /**
     * @inheritDoc
     */
    public function startTrans(): void
    {
        $this->db()->startTrans();
    }

    /**
     * @inheritDoc
     */
    public function commit(): void
    {
        $this->db()->commit();
    }

    /**
     * @inheritDoc
     */
    public function rollback(): void
    {
        $this->db()->rollback();
    }

    /**
     * @inheritDoc
     */
    public function getTable(): string
    {
        return $this->db()->getTable();
    }

    /**
     * 填充字段数据
     *
     * @author nece001@163.com
     * @create 2025-10-08 11:44:13
     *
     * @param array $data
     * @return self
     */
    public function fill(array $data): self
    {
        foreach ($data as $key => $value) {
            $this->setAttr($key, $value);
        }
        return $this;
    }

    /**
     * 包装查询对象
     *
     * @author nece001@163.com
     * @create 2025-11-10 19:23:11
     *
     * @param DbQuery $query
     * @return IQuery
     */
    protected function packQuery(DbQuery $query): IQuery
    {
        return new Query($query);
    }
}
