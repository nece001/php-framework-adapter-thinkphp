<?php

namespace Nece\Framework\Adapter\Facade;

use think\Facade\Route as ThinkRoute;
use Nece\Framework\Adapter\Contract\Facade\Route as RouteContract;

class Route implements RouteContract
{
    public static function addRules(array $rules): void
    {
        foreach ($rules as $rule) {
            $group = $rule['group'];
            $controllers = $rule['controllers'];

            $prefix = rtrim($group['prefix'], '/');

            foreach ($controllers as $controller) {
                $controller_class = $controller['controller'];
                $methods = $controller['methods'];
                foreach ($methods as $method) {
                    $path = $prefix . '/' . ltrim($method['path'], '/');
                    $action = $method['action'];
                    $method = $method['method'] ?? 'get';
                    $name = $method['name'] ?? '';
                    $match = $method['match'] ?? false;

                    $rounte = ThinkRoute::rule($path, [$controller_class, $action], $method);
                    if ($name) {
                        $rounte->name($name);
                    }
                    if ($match) {
                        $rounte->completeMatch();
                    }
                }
            }
        }
    }

    public static function url(string $name, array $params = []): string
    {
        return url($name, $params);
    }
}
