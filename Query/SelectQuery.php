<?php

include_once(__DIR__ . '/Query.php');

class SelectQuery extends Query
{
    public $type;

    private $base;
    private $where;
    private $orWhere;
    private $limit;
    private $sql;
    private $leftJoin;

    public function __construct($table, $fields)
    {
        $this->type = 'select';
        $this->base = "SELECT " . implode(',', $fields) . " FROM " . $table;
    }

    public function where($field, $value, $operator = '=')
    {
        if (!in_array($value, ['NULL'])) {
            $value = "'" . $value . "'";
        }

        $this->where[] = $field . " " . $operator . " " . $value;

        return $this;
    }

    public function orWhere($field, $value, $operator = '=')
    {
        if (!in_array($value, ['NULL'])) {
            $value = "'" . $value . "'";
        }

        $this->orWhere[] = $field . " " . $operator . " " . $value;

        return $this;
    }

    public function limit($value) {
        $this->limit = " LIMIT " . $value;

        return $this;
    }

    public function leftJoin($table, $on) {
        $this->leftJoin = " LEFT JOIN " . $table . " ON ";

        $onConstructions = [];
        foreach ($on as $construct) {
            $onConstructions[] = implode(' ', $construct);
        }

        $this->leftJoin .= implode(' AND ', $onConstructions);
    }

    public function getSQL() {
        $this->sql = $this->base;

        if (!empty($this->leftJoin)) {
            $this->sql .= $this->leftJoin;
        }

        if (!empty($this->where) || !empty($this->orWhere)) {
            $this->sql .= " WHERE ";
        }

        if (!empty($this->where)) {
            $this->sql .= implode(' AND ', $this->where);

            if (!empty($this->orWhere)) {
                $this->sql .= " OR ";
            }
        }

        if (!empty($this->orWhere)) {
            $this->sql .= implode(' OR ', $this->orWhere);
        }

        if (!empty($this->limit)) {
            $this->sql .= $this->limit;
        }

        $this->sql .= ';';

        return $this->sql;
    }
}