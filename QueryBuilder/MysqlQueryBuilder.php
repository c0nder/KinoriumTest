<?php

include_once(__DIR__ . '/IQueryBuilder.php');
include_once(__DIR__ . '/../Query/SelectQuery.php');
include_once(__DIR__ . '/../Query/InsertQuery.php');

class MysqlQueryBuilder implements IQueryBuilder
{
    private $query;

    public function select($table, $fields)
    {
        $this->query = new SelectQuery($table, $fields);

        return $this;
    }

    public function insert($table, $data)
    {
        $this->query = new InsertQuery($table, $data);

        return $this;
    }

    public function getSQL() {
        return $this->query->getSQL();
    }

    public function __call($name, $arguments)
    {
        if (empty($this->query)) {
            throw new Exception('At first you must declare query type.');
        }

        if (!method_exists($this->query, $name)) {
            throw new Exception('You cannot use method ' . $name . ' with this query type.');
        }

        call_user_func_array(array($this->query, $name), $arguments);

        return $this;
    }
}