<?php

namespace Nece\Framework\Adapter;

use think\Model;

class BaseModel extends Model
{
    protected function init()
    {
        if (isset($this->casts)) {
            $this->type = $this->casts;
        }
    }
}
