<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Facade\ISession;
use think\facade\Session as FacadeSession;

class Session implements ISession
{
    /**
     * @inheritDoc
     */
    public static function destroy(): void
    {
        FacadeSession::destroy();
    }

    /**
     * @inheritDoc
     */
    public static function set(string $key, $value): void
    {
        FacadeSession::set($key, $value);
    }

    /**
     * @inheritDoc
     */
    public static function get(string $key, $default = null)
    {
        return FacadeSession::get($key, $default);
    }

    /**
     * @inheritDoc
     */
    public static function has(string $key): bool
    {
        return FacadeSession::has($key);
    }

    /**
     * @inheritDoc
     */
    public static function delete(string $key): void
    {
        FacadeSession::delete($key);
    }
}
