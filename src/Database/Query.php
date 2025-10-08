<?php

namespace Nece\Framework\Adapter\Database;

use Closure;
use Nece\Framework\Adapter\Contract\DataBase\IQuery;
use Nece\Gears\Dto;
use Nece\Gears\PagingCollection;
use Nece\Gears\PagingVar;
use think\facade\Db;

class Query implements IQuery
{
    /**
     * 数据库查询对象
     *
     * @var \think\db\Query
     */
    private $query;

    public function __construct(string $table, string $alias = '')
    {
        $this->query = Db::table($table);
        if ($alias) {
            $this->query->alias($alias);
        }
    }

    public function distinct(bool $distinct = true)
    {
        $this->query->distinct($distinct);
        return $this;
    }

    public function field(string|array $field)
    {
        $this->query->field($field);
        return $this;
    }

    public function join(string|array $table, Closure $on, string $type = 'INNER')
    {
        $join = new Join();
        $on($join);

        $this->query->join($table, $join->toString(), $type);
        return $this;
    }

    public function leftJoin(string|array $table, Closure $on)
    {
        $this->join($table, $on, 'LEFT');
        return $this;
    }

    public function rightJoin(string|array $table, Closure $on)
    {
        $this->join($table, $on, 'RIGHT');
        return $this;
    }

    public function fullJoin(string $table, Closure $on)
    {
        $this->join($table, $on, 'FULL');
        return $this;
    }

    public function where($field, $op = null, $condition = null)
    {
        $this->query->where($field, $op, $condition);
        return $this;
    }

    public function order(string $field, string $direction = 'asc')
    {
        $this->query->order($field, $direction);
        return $this;
    }

    public function group(string $field)
    {
        $this->query->group($field);
        return $this;
    }

    public function having(string $field, string $operator, $value)
    {
        $this->query->having($field, $operator, $value);
        return $this;
    }

    public function page(int $page, int $limit)
    {
        $this->query->page($page, $limit);
        return $this;
    }

    public function limit(int $limit)
    {
        $this->query->limit($limit);
        return $this;
    }

    public function lock(bool $lock = true)
    {
        $this->query->lock($lock);
        return $this;
    }

    public function comment(string $comment)
    {
        $this->query->comment($comment);
        return $this;
    }

    public function union(Closure $closure)
    {
        $this->query->union($closure);
        return $this;
    }

    public function partition(string $partition)
    {
        $this->query->partition($partition);
        return $this;
    }

    public function value(string $field, $default = null)
    {
        return $this->query->value($field, $default);
    }

    public function first()
    {
        return $this->query->find();
    }

    public function fetch(): array
    {
        $list = array();
        $items = $this->query->select();
        if ($items) {
            foreach ($items as $row) {
                $list[] = new Dto($row);
            }
        }
        return $list;
    }

    public function paginate(PagingVar $paging)
    {
        $page = $paging->getPage();
        $size = $paging->getPageSize();

        $list = new PagingCollection([], 0, $page, $size, $paging->getPageVarName(), $paging->getPageSizeVarName());
        $items = $this->query->paginate(array('page' => $page, 'list_rows' => $size));
        if ($items) {
            $list->setTotal($items->total());
            $list->setCurrentPage($items->currentPage());

            foreach ($items as $row) {
                $list->add(new Dto($row));
            }
        }

        return $list;
    }

    public function chunk(int $size, callable $callback, ?string $column = null, string $order = 'asc')
    {
        return $this->query->chunk($size, $callback, $column, $order);
    }

    public function toSql()
    {
        return $this->query->buildSql();
    }

    public function whereOr($field, $op = null, $condition = null)
    {
        $this->query->whereOr($field, $op, $condition);
        return $this;
    }

    public function whereXor($field, $op = null, $condition = null)
    {
        $this->query->whereXor($field, $op, $condition);
        return $this;
    }

    public function whereNull(string $field, string $logic = 'AND')
    {
        $this->query->whereNull($field, $logic);
        return $this;
    }

    public function whereNotNull(string $field, string $logic = 'AND')
    {
        $this->query->whereNotNull($field, $logic);
        return $this;
    }

    public function whereExists($condition, string $logic = 'AND')
    {
        $this->query->whereExists($condition, $logic);
        return $this;
    }

    public function whereNotExists($condition, string $logic = 'AND')
    {
        $this->query->whereNotExists($condition, $logic);
        return $this;
    }

    public function whereIn(string $field, $condition, string $logic = 'AND')
    {
        $this->query->whereIn($field, $condition, $logic);
        return $this;
    }

    public function whereNotIn(string $field, $condition, string $logic = 'AND')
    {
        $this->query->whereNotIn($field, $condition, $logic);
        return $this;
    }

    public function whereLike(string $field, $condition, string $logic = 'AND')
    {
        $this->query->whereLike($field, $condition, $logic);
        return $this;
    }

    public function whereNotLike(string $field, $condition, string $logic = 'AND')
    {
        $this->query->whereNotLike($field, $condition, $logic);
        return $this;
    }

    public function whereBetween(string $field, $condition, string $logic = 'AND')
    {
        $this->query->whereBetween($field, $condition, $logic);
        return $this;
    }

    public function whereNotBetween(string $field, $condition, string $logic = 'AND')
    {
        $this->query->whereNotBetween($field, $condition, $logic);
        return $this;
    }

    public function whereFindInSet(string $field, $condition, string $logic = 'AND')
    {
        $this->query->whereFindInSet($field, $condition, $logic);
        return $this;
    }

    public function whereJsonContains(string $field, $condition, string $logic = 'AND')
    {
        $this->query->whereJsonContains($field, $condition, $logic);
        return $this;
    }

    public function whereOrJsonContains(string $field, $condition, string $logic = 'AND')
    {
        $this->query->whereOrJsonContains($field, $condition, $logic);
        return $this;
    }

    public function whereColumn(string $field1, string $operator, ?string $field2 = null, string $logic = 'AND')
    {
        $this->query->whereColumn($field1, $operator, $field2, $logic);
        return $this;
    }

    public function whereRaw(string $where, array $bind = [], string $logic = 'AND')
    {
        $this->query->whereRaw($where, $bind, $logic);
        return $this;
    }

    public function whereOrRaw(string $where, array $bind = [], string $logic = 'AND')
    {
        $this->query->whereOrRaw($where, $bind, $logic);
        return $this;
    }

    public function when($condition, Closure | array $query, Closure | array | null $otherwise = null)
    {
        $this->query->when($condition, $query, $otherwise);
        return $this;
    }
}
