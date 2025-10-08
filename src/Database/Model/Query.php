<?php

namespace Nece\Framework\Adapter\Database\Model;

use think\db\Query as DbQuery;

/**
 * 模型查询
 *
 * @author nece001@163.com
 * @create 2025-10-08 21:04:06
 */
class Query extends DbQuery
{
    /**
     * 获取第一条记录
     *
     * @author nece001@163.com
     * @create 2025-10-08 21:04:26
     *
     * @return Model|null
     */
    public function first()
    {
        return $this->find();
    }
}
