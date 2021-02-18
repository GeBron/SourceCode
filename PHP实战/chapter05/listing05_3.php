<?php
class DatabaseClient {
    protected $db;

    public function __construct() {
        $this->db = DB::Connect(
                'mysql://user:password@localhost/webdatabase');
        if (DB::isError($this->db)) {
            throw new Exception($this->db->getMessage());
        }
    }

    public function query($sql) {
        $result = $this->db->query($sql);
        if (DB::isError($result)) {
            throw new Exception(
                $result->getMessage()."\n".$query."\n");
        }
        return $result;
    }
}
