<?php

namespace Nece\Framework\Adapter\Database;

use Nece\Framework\Adapter\Contract\DataBase\IModel;
use Nece\Framework\Adapter\Database\Model\Query;
use think\Model as ThinkModel;

class Model extends ThinkModel implements IModel
{
    // 指定使用的查询类
    protected $query = Query::class;

    /**
     * 开始事务
     *
     * @author nece001@163.com
     * @create 2025-10-05 11:13:16
     *
     * @return void
     */
    public function startTrans(): void
    {
        $this->db()->startTrans();
    }

    /**
     * 提交事务
     *
     * @author nece001@163.com
     * @create 2025-10-05 11:13:16
     *
     * @return void
     */
    public function commit(): void
    {
        $this->db()->commit();
    }

    /**
     * 回滚事务
     *
     * @author nece001@163.com
     * @create 2025-10-05 11:13:16
     *
     * @return void
     */
    public function rollback(): void
    {
        $this->db()->rollback();
    }

    /**
     * 获取表名
     *
     * @author nece001@163.com
     * @create 2025-10-05 11:13:16
     *
     * @return string
     */
    public function getTableName(): string
    {
        return $this->table;
    }

    /**
     * 查询表
     *
     * @author nece001@163.com
     * @create 2025-10-08 11:34:30
     *
     * @param string $table
     * @param string $alias
     * @return self
     */
    public function from(string $table, string $alias = '')
    {
        return $this->table($table)->alias($alias);
    }

    /**
     * 获取表别名
     *
     * @author nece001@163.com
     * @create 2025-10-08 11:34:30
     *
     * @return string
     */
    public function getAlias()
    {
        return parent::getAlias($this->getTable());
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
    public function fillData(array $data): self
    {
        foreach ($data as $key => $value) {
            $this->setAttr($key, $value);
        }
        return $this;
    }
}
