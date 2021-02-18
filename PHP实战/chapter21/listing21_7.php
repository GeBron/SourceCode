<?php
class CreoleStatement {
    private $statement;
    public function __construct($statement) {                         
        $this->statement = $statement;                                
    }                                                                 

    public function executeQuery() {                                  
        return $this->statement->executeQuery();                      
    }                                                                 
                                                                      
    public function executeUpdate() {                                 
        return $this->statement->executeUpdate();                     
    }                                                                 

    public function fetchFirstObject(Loader $loader) {                
        $rs = $this->executeQuery();                                  
        $rs->first();                                                 
        return $loader->load($rs->getRow());                          
    }                                                                 
                                                                      
    public function fetchAllObjects(Loader $loader) {                 
        $rs = $this->executeQuery();                                  
        $result = array();                                            
        while($rs->next()) {                                          
            $result[] = $loader->load($rs->getRow());                 
        }                                                             
        return $result;                                               
    }                                                                 

}
