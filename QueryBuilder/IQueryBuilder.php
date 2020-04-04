<?php

interface IQueryBuilder {
    public function select($table, $fields);

    public function insert($table, $data);

    public function getSQL();
}