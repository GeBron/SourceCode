<?php
class UserFinder {
    private $db;

    public function __construct() {
        $this->db = DB::Connect(
                'mysql://user:password@localhost/webdatabase');
        if (DB::isError($this->db)) {
            throw new Exception($this->db->getMessage());
        }
    }

    public function findAll() {
        $result = $this->db->query(
                "SELECT user_id, email, password, name ".
                "FROM Users");
        if (DB::isError($result)) {
            throw new Exception(
                $result->getMessage()."\n".$query."\n");
        }
        while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
            $users[] = $row;
        }
        return $users;
    }

    public function setConnection($connection) {
        $this->db = $connection;
    }
}
