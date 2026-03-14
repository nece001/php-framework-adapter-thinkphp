<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Facade\IEnv;
use think\facade\Env as FacadeEnv;

class Env implements IEnv
{
    /**
     * @inheritDoc
     */
    public static function get($key, $default = null)
    {
        return FacadeEnv::get($key, $default);
    }

    /**
     * @inheritDoc
     */
    public static function has($key): bool
    {
        return FacadeEnv::has($key);
    }

    /**
     * @inheritDoc
     */
    public static function set($key, $value)
    {
        FacadeEnv::set($key, $value);
    }
}
