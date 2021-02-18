<?php
class TopicFinder {
        const SELECT_STMT =

            "SELECT id,name from Topics WHERE %s";                       

        function __construct() {
            $this->connection =
                CreoleConnectionFactory::getConnection();
        }

        function findWithName($name) {
            $stmt = $this->connection->prepareStatement(

                    sprintf(self::SELECT_STMT,"name = ?"));              
            $stmt->setString(1,$name);                                   
            $rs = $stmt->executeQuery();

            $rs->first();                                                
            return $rs->getRow();                                        
        }

        function findWithIdLargerThan($id) {
            $stmt = $this->connection->prepareStatement(

                    sprintf(self::SELECT_STMT,"id > ?"));                
            $stmt->set(1,$id);                                           
            $rs = $stmt->executeQuery();

            $rs->first();                                                
            return $rs->getRow();                                        
        }
}
