<?php
require_once 'DB.php';
class NewsFinder {
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
                "SELECT headline,introduction,text,".                   
                "author,unix_timestamp(created) as created,".           
                "news_id ".                                             
                "FROM News");                                           
        if (DB::isError($result)) {
            throw new Exception(
                $result->getMessage()."\n".$query."\n");
        }
        while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {          
            $news[] = $row;                                             
        }                                                               
        return $news;                                                   
    }

    public function setConnection($connection) {
        $this->db = $connection;
    }
}
