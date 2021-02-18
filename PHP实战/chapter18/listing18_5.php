<?php
class RadioButtonGroup extends SelectOne
{
    private $value;                                                   
    private $options = array();                                       

    protected $quickFormElement;

    public function addOption($text,$value) {
        $elements = $this->quickFormElement->getElements();           
        $element = new HTML_QuickForm_radio(                          
            NULL,$text,NULL,$value);                                  
        $elements[] = $element;                                       
        $this->quickFormElement->setElements($elements);              
        $this->options[$value] = $element;                            
    }

    public function setValue($value) {
        $this->value = $value;                                        
        if (!array_key_exists($value,$this->options)) return;         
        $this->options[$value]->setChecked(TRUE);                     
    }

    public function getValue() {
        return $this->value;
    }

    public function options() {
        return $this->options;
    }
}
