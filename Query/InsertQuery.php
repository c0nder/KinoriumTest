<?php

include_once(__DIR__ . '/Query.php');

class InsertQuery extends Query
{
    public $type;

    private $base;
    private $sql;

    public function __construct($table, $values = [])
    {
        $this->type = 'insert';
        $this->base = "INSERT INTO " . $table;
        $this->addValues($values);
    }

    private function addValues($data) {
        if (empty($data)) {
            throw new Exception('You must specify the data to be added.');
        }

        $this->sql = $this->base;

        $columns = array_keys($data);
        $values = array_values($data);

        array_walk($values, function (&$element, $key) {
            $element = "'" . $element . "'";
        });

        $this->sql .= "(" . implode(',', $columns) . ")";
        $this->sql .= " VALUES(" . implode(',', $values) . ")";
    }

    public function getSQL()
    {
        $this->sql .= ';';
        return $this->sql;
    }
}