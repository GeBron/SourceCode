<?php
class Template {
    private $vars;
    private $file;

    public function __construct($file) {                              
         $this->file = $file;                                         
    }                                                                 

    public function set($var,$value) {                                
        $this->vars[$var] = $value;                                   
    }                                                                 

    public function asHtml() {
        extract($this->vars);                                          
        ob_start();                                                   
        include $this->file;                                          
        $string = ob_get_contents();                                  
        ob_end_clean();                                               
        return $string;                                                
    }
}
