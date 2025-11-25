<?php

namespace Nece\Framework\Adapter\Database;

use Closure;
use Nece\Framework\Adapter\Contract\DataBase\IQuery;
use Nece\Gears\PagingCollection;
use Nece\Gears\PagingVar;
use think\db\Query as DbQuery;

/**
 * ThinkPHP查询适配类
 *
 * @author nece001@163.com
 * @create 2025-11-09 16:59:14
 */
class Query implements IQuery
{
    /**
     * 数据库查询对象
     *
     * @var \think\db\Query
     */
    private $query;

    /**
     * 构造函数
     *
     * @author nece001@163.com
     * @create 2025-10-10 20:31:52
     *
     * @param string $table
     * @param string $alias
     */
    public function __construct(DbQuery $query)
    {
        $this->query = $query;
    }

    /**
     * @inheritDoc
     *
     * @return \think\db\Query
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * 调用查询方法
     *
     * @author nece001@163.com
     * @create 2025-10-25 15:24:16
     *
     * @param string $name
     * @param array $arguments
     * @return self
     */
    public function __call($name, $arguments)
    {
        $result = $this->query->$name(...$arguments);
        if ($result instanceof DbQuery) {
            return $this;
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getAlias(): string
    {
        return $this->query->getAlias();
    }

    /**
     * @inheritDoc
     */
    public function field($field): self
    {
        $this->query->field($field);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function join($table, Closure $on, string $type = 'INNER'): self
    {
        $join = new Join();
        $on($join);

        $this->query->join($table, $join->toString(), $type);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function leftJoin($table, Closure $on): self
    {
        $this->join($table, $on, 'LEFT');
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function rightJoin($table, Closure $on): self
    {
        $this->join($table, $on, 'RIGHT');
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function fullJoin(string $table, Closure $on): self
    {
        $this->join($table, $on, 'FULL');
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function crossJoin($table, Closure $on): self
    {
        $this->join($table, $on, 'CROSS');
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function select(): array
    {
        $list = array();
        $items = $this->query->select();
        if ($items) {
            foreach ($items as $row) {
                $list[] = $row;
            }
        }
        return $list;
    }

    /**
     * @inheritDoc
     */
    public function paginate(int $page, int $size): array
    {
        $data = array(
            'page' => $page,
            'size' => $size,
            'total' => 0,
            'items' => []
        );

        $items = $this->query->paginate(array('page' => $page, 'list_rows' => $size));
        if ($items) {
            $data['total'] = $items->total();
            $data['current_page'] = $items->currentPage();

            foreach ($items as $row) {
                $data['items'][] = $row;
            }
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function chunk(int $size, callable $callback, ?string $column = null, string $order = 'asc')
    {
        return $this->query->chunk($size, $callback, $column, $order);
    }

    /**
     * @inheritDoc
     */
    public function toSql(): string
    {
        return $this->query->buildSql();
    }

    /**
     * @inheritDoc
     */
    public function group($field): self
    {
        $this->query->group($field);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function order($field, string $order = 'asc'): self
    {
        $this->query->order($field, $order);
        return $this;
    }
}
