<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Facade\IRoute;
use think\facade\Route as FacadeRoute;

class Route extends FacadeRoute implements IRoute
{
    /**
     * @inheritDoc
     */
    public static function match($methods, $uri, $action)
    {
        return self::rule($uri, $action, $methods);
    }

    /**
     * @inheritDoc
     */
    public static function fixRule(string $rule): string
    {
        return $rule;
    }
}
