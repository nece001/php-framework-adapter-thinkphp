<?php

namespace Nece\Framework\Adapter\Database;

use Nece\Framework\Adapter\Contract\DataBase\IQuery;
use Nece\Gears\Dto;
use Nece\Gears\PagingCollection;
use think\db\Query as ThinkQuery;

class Query extends ThinkQuery implements IQuery
{
    /**
     * 分页查询
     *
     * @author nece001@163.com
     * @create 2025-09-14 13:27:17
     *
     * @param int $page
     * @param int $size
     * @return PagingCollection
     */
    public function toPaginate(int $page = 1, int $size = 15): PagingCollection
    {
        $list = new PagingCollection([], 0, $page, $size);
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
}
