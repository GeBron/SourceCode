<?php
class NewsSaver {
    private $connection;
    public function __construct() {
        $this->connection
            = CreoleConnectionFactory::getConnection();
    }

    public function insert($article) {
        $sql = "INSERT INTO News ".
        "(headline,author_id,introduction,text,created) ".
        "VALUES (?,?,?,?,?)";
        $stmt = $this->connection->prepareStatement($sql);
        $this->setVars($stmt,$article);
        $stmt->setTimestamp(5,time());
        $stmt->executeUpdate();
        $rs = $this->connection->executeQuery(
                "SELECT LAST_INSERT_ID() AS id");
        $rs->first();
        return $rs->getInt('id');
    }

    public function update($article) {
        $sql = "UPDATE News SET ".
            "headline = ?, ".
            "author_id = ?, ".
            "introduction = ?, ".
            "text = ? ".
            "WHERE id = ?";
        $stmt = $this->connection->prepareStatement($sql);
        $this->setVars($stmt,$article);
        $stmt->setInt(5,$article->getId());
        $stmt->executeUpdate();
    }

    private function setVars($stmt,$article) {
        $stmt->setString(1,$article->getHeadline());
        $stmt->setInt(2,$article->getAuthorId());
        $stmt->setString(3,$article->getIntroduction());
        $stmt->setString(4,$article->getText());
    }

    public function delete($article) {
        $sql = "DELETE FROM News where id = ".$article->getId();
        $this->connection->executeQuery($sql);
    }
}
