<?php
class NewsFinder {
    public function find($id) {
        $stmt = $this->prepare("AND id = ?");
        $stmt->setInt(1,$id);
        return $stmt->executeQuery();
    }

    public function findWithHeadline($headline) {
        $stmt = $this->prepare("AND headline = ?");
        $stmt->setString(1,$headline);
        return $stmt->executeQuery();
    }

    public function findAll() {
        $stmt = $this->prepare ("ORDER BY created DESC");
        return $stmt->executeQuery();
        return $result;
    }

    private function prepare($criteria) {
        return $this->connection->prepareStatement(
                sprintf("SELECT headline,introduction,text, ".
                "concat(Users.firstname,' ',Users.lastname) ".
                "AS author, ".
                "UNIX_TIMESTAMP(created) AS created,id ".
                "FROM Documents, Users ".
                "WHERE Documents.author_id = Users.user_id %s",
                $criteria));
    }
}
