<?php

namespace Nece\Framework\Adapter\Database\Model;

use think\model\concern\SoftDelete as ConcernSoftDelete;

/**
 * 统一命名空间
 *
 * @author nece001@163.com
 * @create 2025-11-09 17:53:37
 */
trait SoftDelete
{
    use ConcernSoftDelete;
}