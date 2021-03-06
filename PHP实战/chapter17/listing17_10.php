<?php
class AlphanumericFieldValidator {
    private $fieldname;
    private $message;

    public function __construct($fieldname,$message) {                
        $this->fieldname = $fieldname;                                
        $this->message = $message;                                    
    }                                                                 

    public function validate($coordinator) {
        if (ctype_alnum(                                     
            $coordinator->get($this->fieldname)))                     
        {
            $coordinator->setClean($this->fieldname);                 
            return TRUE;                                              
        } else {
            $coordinator->addError($this->message);                   
            return FALSE;                                             
        }
    }
}
