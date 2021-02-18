<?php
class BasicValidator {
    private $specification;
    private $message;

    public function __construct($specification,$message) {            
        $this->specification = $specification;                        
        $this->message = $message;                                    
    }
    public function validate($request) {
        if ($this->specification->isSatisfiedBy($coordinator)) {
            $coordinator->setClean(                                   
                 $this->specification->getValidatedField());          
            return TRUE;                                              
        }
        else {
            $coordinator->addError($this->message);                   
            return FALSE;                                             
        }
    }
}
