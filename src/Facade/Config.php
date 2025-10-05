<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Facade\IConfig;
use think\facade\Env;

class Config  implements IConfig
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
