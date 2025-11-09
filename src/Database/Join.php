<?php

namespace Nece\Framework\Adapter\Database;

/**
 * 查询连接条件类
 *
 * @author nece001@163.com
 * @create 2025-11-09 17:52:36
 */
class Join
{
    private $options = [];

    public function on(string $field, string $op, string $value, bool $or = false)
    {
        $this->options[] = array(
            'field' => $field,
            'op' => $op,
            'value' => $value,
            'or' => $or ? 'OR' : 'AND',
        );
        return $this;
    }

    public function orOn(string $field, string $op, string $value)
    {
        return $this->on($field, $op, $value, true);
    }

    public function toString()
    {
        $tmp = array();
        foreach ($this->options as $row) {
            $line = '';
            if ($tmp) {
                $line = $row['or'] . ' ';
            }
            $line .= $row['field'] . ' ' . $row['op'] . ' ' . $row['value'];
            $tmp[] = $line;
        }

        return implode(' ', $tmp);
    }

    public function __toString()
    {
        return $this->toString();
    }
}
