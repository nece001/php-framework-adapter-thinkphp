<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Facade\Env as ContractFacadeEnv;
use think\facade\Env as FacadeEnv;

class Env implements ContractFacadeEnv
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

    /**
     * @inheritDoc
     */
    public static function getAppEnv(): string
    {
        return self::get('app_env', 'dev');
    }

    /**
     * @inheritDoc
     */
    public static function getRootPath(): string
    {
        return rtrim(str_replace('\\', DIRECTORY_SEPARATOR, root_path()), DIRECTORY_SEPARATOR);
    }
}
