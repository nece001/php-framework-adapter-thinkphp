<?php

namespace Nece\Framework\Adapter\Database;

use Nece\Framework\Adapter\Contract\DataBase\IModel;
use think\Model as ThinkModel;

/**
 * ThinkPHP模型适配类
 *
 * @author nece001@163.com
 * @create 2025-11-09 17:00:42
 */
abstract class Model extends ThinkModel implements IModel
{
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
}
