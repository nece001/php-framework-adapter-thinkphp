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
    /**
     * 模型内部定义的作用于本模型的全局查询范围
     *
     * @var array
     */
    protected static $model_global_scopes = [];

    /**
     * 仓储全局查询范围
     *
     * @var array
     */
    private $repository_global_scopes = [];

    /**
     * ThinkPHP框架的全局查询范围（定义模型的范围时，尽量不要再使用这个属性，使用static::$model_global_scopes）
     *
     * @var array
     */
    protected $globalScope = [];

    /**
     * 构造方法
     *
     * @author nece001@163.com
     * @create 2025-11-25 12:50:36
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);

        $this->globalScope[] = 'applyRepositoryGlobal'; // 注册本模型的全局查询范围

        // 注册本模型定义的全局查询范围
        if (static::$model_global_scopes) {
            $this->globalScope = array_merge($this->globalScope, static::$model_global_scopes);
        }
    }

    /**
     * 注册仓储全局查询范围
     * 在仓储层实例化模型时设置仓储全局查询范围
     *
     * @author nece001@163.com
     * @create 2025-11-25 12:43:36
     *
     * @param array $scopes
     * @return void
     */
    public function setRepositoryGlobalScope(array $scopes): void
    {
        $this->repository_global_scopes = $scopes;
    }

    /**
     * applyRepositoryGlobalScope的别名，按thinkPHP的规则定义
     *
     * @author nece001@163.com
     * @create 2025-11-25 12:54:07
     *
     * @param DbQuery $query
     * @return void
     */
    public function scopeApplyRepositoryGlobal(DbQuery $query): void
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
     * 创建一个新查询
     *
     * @author nece001@163.com
     * @create 2025-11-25 12:42:49
     *
     * @param string $alias
     * @return IQuery
     */
    public function newQuery($alias = null): IQuery
    {
        $query = $this->db(); // 创建一个空的查询对象
        if ($alias) {
            $query->alias($alias);
        }
        $this->scopeApplyRepositoryGlobal($query);
        return new Query($query);
    }
}
