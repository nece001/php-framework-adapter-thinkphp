<?php

namespace Nece\Framework\Adapter\Database\Model;

use think\model\concern\SoftDelete as ConcernSoftDelete;

trait SoftDelete
{
    use ConcernSoftDelete;
}