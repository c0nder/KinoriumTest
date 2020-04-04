<?php

include_once(__DIR__ . '/QueryBuilder/IQueryBuilder.php');

class DB {
    private $connection;

    public function __construct($user, $pass, $host, $dbName, $port = 3306, $dbType = 'mysql')
    {
        $this->connect([
            'user' => $user,
            'pass' => $pass,
            'host' => $host,
            'port' => $port,
            'dbName' => $dbName,
            'dbType' => $dbType
        ]);
    }

    private function connect($config) {
        try {
            $dsn = $config['dbType'] . ':host=' . $config['host'] . ';port=' . $config['port'] . ';dbname=' . $config['dbName'];
            $this->connection = new PDO($dsn, $config['user'], $config['pass']);
        } catch (PDOException $e) {
            exit("Can't connect to database: " . $e->getMessage());
        }
    }

    public function query(IQueryBuilder $query) {
        try {
            $query = $this->connection->prepare($query->getSQL());
            $query->execute();
            return $query;
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }
}