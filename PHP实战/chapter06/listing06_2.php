<?php
abstract class Inserter {
    abstract public function insert($data);
}

class TopicInserter extends Inserter {
    public function insert($data) {
        $sql = "INSERT INTO Topics (name) VALUES('".
            $data['name']."')";
        // Insert into database
    }
}

class NewsInserter extends Inserter {
    public function insert($data) {
        $sql = "INSERT INTO News (headline,body) VALUES('".
            $data['headline']."','".$data['body']."')";
        // Insert into database
    }
}
