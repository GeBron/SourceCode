<?php
class MysqlTransaction {
    private $connection;

    function __construct($host, $user, $password, $db) {
        $this->connection = mysql_connect(
                $host, $user, $password, $db, true);
    }

    function select($sql) {
        $result = @mysql_query($sql, $this->connection);
        return new MysqlResult($result);
    }
}

class MysqlResult {
    private $result;

    function __construct($result) {
        $this->result = $result;
    }

    function next() {
        return mysql_fetch_assoc($this->result);
    }
}
