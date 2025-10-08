<?php

namespace Nece\Framework\Adapter\Database;

use Closure;
use Nece\Framework\Adapter\Contract\DataBase\IQuery;
use Nece\Gears\Dto;
use Nece\Gears\PagingCollection;
use Nece\Gears\PagingVar;
use think\db\Query as ThinkQuery;

class Query extends ThinkQuery implements IQuery
{
    public function joinTo(string $table, Closure $on, $type = 'INNER', array $bind = []): self
    {
        $join = new Join();
        $on($join);
        $cond = $join->toString();

        return $this->join($table, $cond, $type, $bind);
    }

    public function leftJoinTo(string $table, Closure $on, array $bind = []): self
    {
        return $this->joinTo($table, $on, 'LEFT', $bind);
    }

    public function rightJoinTo(string $table, Closure $on, array $bind = []): self
    {
        return $this->joinTo($table, $on, 'RIGHT', $bind);
    }

    /**
     * 按分页查询
     *
     * @author nece001@163.com
     * @create 2025-09-14 13:27:17
     *
     * @return PagingCollection
     */
    public function paging(PagingVar $paging): PagingCollection
    {
        $page = $paging->getPage();
        $size = $paging->getPageSize();

        $list = new PagingCollection([], 0, $page, $size, $paging->getPageVarName(), $paging->getPageSizeVarName());
        $items = $this->paginate(array('page' => $page, 'list_rows' => $size));
        if ($items) {
            $list->setTotal($items->total());
            $list->setCurrentPage($items->currentPage());

            foreach ($items as $item) {
                $list->add(new Dto($item->toArray()));
            }
        }

        return $list;
    }

    /**
     * 查询所有
     *
     * @author nece001@163.com
     * @create 2025-10-07 10:24:54
     *
     * @return array
     */
    public function fetch(): array
    {
        $list = array();
        $items = $this->select();
        if ($items) {
            foreach ($items as $item) {
                $list[] = new Dto($item->toArray());
            }
        }
        return $list;
    }
}
