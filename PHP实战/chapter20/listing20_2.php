<?php
abstract class Finder {
    private $connection;
    public function __construct() {
        $this->connection = ConnectionFactory::getConnection();
    }
    public function findAll() {
        $result = $this->connection->query(sprintf(
                    "SELECT %s FROM %s",
                    constant(get_class($this)."::COLUMN_LIST"),
                    constant(get_class($this)."::TABLE")
                    ));
        return $result->fetchRow();
    }
}
