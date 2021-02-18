<?php
class PearExceptionDecorator extends PearDecorator {
    public function __construct($connection) {
        $this->connection =  $connection;
        if (DB::isError($this->connection)) {
            throw new Exception($this->connection->getMessage());
        }
    }

    public function query($sql) {
        $result = $this->connection->query($sql);
        if (DB::isError($result)) {
            throw new Exception($result->getMessage()."\n".$sql);
        }
        return $result;
    }

}
