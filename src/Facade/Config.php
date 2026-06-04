<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Facade\Config as FacadeConfig;
use think\facade\Env;

class Config  implements FacadeConfig
{
    /**
     * @inheritDoc
     */
    public function config(string $key, $default = null)
    {
        return config($key, $default);
    }

    /**
     * @inheritDoc
     */
    public function env(string $key, $default = null)
    {
        return Env::get($key, $default);
    }
}
