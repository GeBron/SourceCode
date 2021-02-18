<?php
abstract class PearDecorator {
    protected $connection;

    public function __construct($connection) {
        $this->connection =  $connection;
    }

    public function query($sql) {
        return $this->connection->query($sql);
    }

    public function nextID($name) {
        return $this->connection->nextID($name);
    }
}
