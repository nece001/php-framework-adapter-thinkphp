<?php

namespace Nece\Framework\Adapter\Database;

use Nece\Framework\Adapter\Contract\DataBase\IModel;
use Nece\Framework\Adapter\Contract\DataBase\IQuery;
use Nece\Framework\Adapter\Contract\DataBase\ScopeManager;
use think\Model as ThinkModel;
use think\db\Query as DbQuery;

/**
 * ThinkPHP模型适配类
 *
 * @author nece001@163.com
 * @create 2025-11-09 17:00:42
 * 
 * @method mixed db()
 */
abstract class Model extends ThinkModel implements IModel
{
    /**
     * 兼容ThinkPHP的全局查询范围
     *  - 子类中不要使用这个变量，需要添加的范围方法定义到autoGlobalScope中
     *
     * @var array
     */
    protected $globalScope = [];

    /**
     * 自动应用的全局查询范围的类型
     *
     * @var array
     */
    protected $globalAutoApplyScopeType = [];

    /**
     * 自动应用的全局查询范围
     *
     * @var array
     */
    protected $globalAutoApplyScope = [];

    /**
     * 构造
     *
     * @author nece001@163.com
     * @create 2025-11-10 19:36:26
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);

        // 添加全局范围
        $this->globalScope[] = 'GlobalAutoApply';
        $this->globalScope = array_merge($this->globalScope, $this->globalAutoApplyScope);
    }

    /**
     * 统一执行全局范围
     *
     * @author nece001@163.com
     * @create 2025-11-10 19:39:10
     *
     * @param DbQuery $query
     * @return void
     */
    public function scopeGlobalAutoApply(DbQuery $query)
    {
        foreach ($this->globalAutoApplyScopeType as $type) {
            $scopes = ScopeManager::getScopes($type);
            foreach ($scopes as $scope) {
                $scope($query);
            }
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
