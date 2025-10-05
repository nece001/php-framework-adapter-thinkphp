<?php

namespace Nece\Framework\Adapter\Facade;

use Nece\Framework\Adapter\Contract\Facade\IContainer;
use think\Container as TpContainer;
use think\App;

/**
 * 容器
 * 作用：解决依赖注入的兼容问题
 *
 * @author nece001@163.com
 * @create 2025-09-13 14:35:02
 */
class Container implements IContainer
{
    /**
     * 初始化应用
     *
     * @author nece001@163.com
     * @create 2025-09-13 14:34:15
     *
     * @return void
     */
    public static function initApp(): void
    {
        $app = new App();
        $app->initialize();
    }

    /**
     * 获取应用实例
     *
     * @author nece001@163.com
     * @create 2025-09-13 14:35:08
     *
     * @return Object
     */
    public static function getApp()
    {
        return TpContainer::getInstance()->make(App::class);
    }

    /**
     * 依赖注入创建实例
     *
     * @author nece001@163.com
     * @create 2025-09-13 14:35:20
     *
     * @param string $abstract
     * @param array $vars
     * @param boolean $newInstance
     * @return Object
     */
    public static function make(string $abstract, array $vars = [], bool $newInstance = false)
    {
        return TpContainer::getInstance()->make($abstract, $vars, $newInstance);
    }
}
