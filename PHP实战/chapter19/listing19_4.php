<?php
class MysqlResultIterator implements Iterator {                        
    private $mysqliResult;
    private $current;
    private $rowNum = 0;

    public function __construct($mysqliResult) {
         $this->mysqliResult = $mysqliResult;                         
         $this->rewind();                                             
    }

    public function rewind() {
        $this->mysqliResult->data_seek(0);                            
        $this->next();                                                
        $this->rowNum = 0;                                             
    }

    public function valid() {                                         
        return $this->rowNum < $this->mysqliResult->num_rows;         
    }                                                                 

    public function next() {
        $this->current = $this->mysqliResult->fetch_object();         
        ++$this->rowNum;                                              
    }

    public function current() {                                       
        return $this->current;                                        
    }                                                                 

    public function key() {                                           
        return $this->rowNum;                                         
    }                                                                 
}
