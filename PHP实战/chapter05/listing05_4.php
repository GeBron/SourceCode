<?php
class UserFinder extends DatabaseClient {

    public function findAll() {
        $result = $this->query(
                "SELECT user_id, email, password, name ".
                "FROM Users");
        while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
            $users[] = $row;
        }
        return $users;
    }

}
