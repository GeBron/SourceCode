<?php
class NewsFinder {
    public function __construct() {
        $this->connection =
            CreoleConnectionFactory::getConnection();
    }

    public function find($id) {
        $stmt = $this->connection->prepareStatement(
                "SELECT headline,introduction,text, ".
                "concat(Users.firstname,' ',Users.lastname) ".

                "AS author, ".
                "UNIX_TIMESTAMP(created) AS created,id ".

                "FROM Documents, Users ".
                "WHERE Documents.author_id = Users.user_id ".
                "AND id = ?");
        $stmt->setInt(1,$id);

        $rs = $stmt->executeQuery();

        $rs->first();                                                    
        return $rs->getRow();                                            
    }

    public function findWithHeadline($headline) {
        $stmt = $this->connection->prepareStatement(
                "SELECT headline,introduction,text, ".
                "concat(Users.firstname,' ',Users.lastname) ".
                "AS author, ".
                "UNIX_TIMESTAMP(created) AS created,id ".
                "FROM Documents, Users ".
                "WHERE Documents.author_id = Users.user_id ".
                "AND headline = ?");
        $stmt->setString(1,$headline);
        $rs = $stmt->executeQuery();
        $rs->first();
        return $rs->getRow();
    }

    public function findAll() {
        return $this->connection->executeQuery(                          
                "SELECT headline,introduction,text, ".
                "concat(Users.firstname,' ',Users.lastname) ".
                "AS author, ".
                "UNIX_TIMESTAMP(created) AS created,id ".
                "FROM Documents, Users ".
                "WHERE Documents.author_id = Users.user_id ".
                "ORDER BY created DESC");
    }
}
