<?php
class SelectMenu extends SelectOne{
    protected $quickFormElement;

    public function addOption($text,$value) {                         
        $this->quickFormElement->addOption($text,$value);             
    }                                                                 

    public function setValue($value) {
        $this->quickFormElement->setValue($value);
    }

    public function getValue() {                                      
        $values = $this->quickFormElement->getValue();                
        return $values[0];                                            
    }                                                                 
}
