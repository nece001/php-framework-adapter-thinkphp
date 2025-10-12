<?php

namespace Nece\Framework\Adapter\Database;

use Closure;
use Nece\Framework\Adapter\Contract\Database\IDbManater;
use Nece\Framework\Adapter\Contract\DataBase\IQuery;
use think\facade\Db as FacadeDb;

/**
 * @see \think\DbManager
 * @mixin \think\DbManager
 */
class Db implements IDbManater
{
    /**
     * 获取查询构建器
     *
     * @author nece001@163.com
     * @create 2025-10-05 11:28:24
     *
     * @param string $table 表名
     * @param string $as 别名
     * @return IQuery
     */
    public static function table($table, $alias = ''): IQuery
    {
        return new Query($table, $alias);
    }

    /**
     * 原始表达式
     *
     * @param  mixed  $value
     * @return Expression
     */
    public static function raw($value)
    {
        return FacadeDb::raw($value);
    }

    /**
     * 原始函数表达式
     *
     * @author nece001@163.com
     * @create 2025-10-07 23:04:25
     *
     * @param string $func 函数名
     * @param string $field 字段名
     * @param string $alias 别名
     * @return Expression
     */
    public static function rawFunc(string $func, string $field, string $alias)
    {
        return self::raw("{$func}({$field}) as {$alias}");
    }

    /**
     * 计数函数表达式
     *
     * @author nece001@163.com
     * @create 2025-10-07 23:04:43
     *
     * @param string $field 字段名
     * @param string $alias 别名
     * @return Expression
     */
    public static function rawCount(string $field, string $alias)
    {
        return self::rawFunc('count', $field, $alias);
    }

    /**
     * 求和函数表达式
     *
     * @author nece001@163.com
     * @create 2025-10-07 23:04:52
     *
     * @param string $field 字段名
     * @param string $alias 别名
     * @return Expression
     */
    public static function rawSum(string $field, string $alias)
    {
        return self::rawFunc('sum', $field, $alias);
    }

    /**
     * 平均值函数表达式
     *
     * @author nece001@163.com
     * @create 2025-10-07 23:05:01
     *
     * @param string $field 字段名
     * @param string $alias 别名
     * @return Expression
     */
    public static function rawAvg(string $field, string $alias)
    {
        return self::rawFunc('avg', $field, $alias);
    }

    /**
     * 最小值函数表达式
     *
     * @author nece001@163.com
     * @create 2025-10-07 23:05:10
     *
     * @param string $field 字段名
     * @param string $alias 别名
     * @return Expression
     */
    public static function rawMin(string $field, string $alias)
    {
        return self::rawFunc('min', $field, $alias);
    }

    /**
     * 最大值函数表达式
     *
     * @author nece001@163.com
     * @create 2025-10-07 23:05:19
     *
     * @param string $field 字段名
     * @param string $alias 别名
     * @return Expression
     */
    public static function rawMax(string $field, string $alias)
    {
        return self::rawFunc('max', $field, $alias);
    }

    /**
     * 开启事务
     *
     * @author nece001@163.com
     * @create 2025-10-12 14:56:48
     *
     * @return void
     */
    public static function startTrans()
    {
        FacadeDb::startTrans();
    }

    /**
     * 提交事务
     *
     * @author nece001@163.com
     * @create 2025-10-08 10:26:24
     *
     * @return void
     */
    public static function commit()
    {
        FacadeDb::commit();
    }

    /**
     * 回滚事务
     *
     * @author nece001@163.com
     * @create 2025-10-08 10:26:42
     *
     * @return void
     */
    public static function rollback()
    {
        FacadeDb::rollback();
    }
}
