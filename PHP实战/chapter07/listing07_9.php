<?php
abstract class MenuComponent {
    protected $marked = FALSE;
    protected $label;

    public function mark() { $this->marked = TRUE; }                  
    public function isMarked() { return $this->marked; }              

    public function getLabel() { return $this->label; }               
    public function setLabel($label) { $this->label = $label; }       

    abstract public function hasMenuOptionWithId($id);                
                                                                      
    abstract public function markPathToMenuOption($id);               
}
