<?php
class TextInput extends AbstractInputControl
{
    protected $quickFormElement;                                       
    private $validation;                                              
    private $message;                                                 

    public function __construct(                                      
        $quickFormElement,$validation,$message) {                     
        $this->validation = $validation;                              
        $this->message = $message;                                    
        $this->quickFormElement = $quickFormElement;                  
    }                                                                 

    public function setValue($value) {                                
        $this->quickFormElement->setValue($value);                    
    }                                                                 
                                                                      
    public function getValue() {                                      
        return $this->quickFormElement->getValue();                   
    }                                                                 
                                                                      
    public function getLabel() {                                      
        return $this->quickFormElement->getLabel();                   
    }                                                                 

}
