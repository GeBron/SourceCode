<?php
class Request {
    private $request = array();

    public function __construct() {                                   
        $this->request = $this->initFromHttp();                       
    }                                                                 
                                                                      
    private function initFromHttp() {                                 
        if (!empty($_POST)) return  $_POST;                           
        if (!empty($_GET)) return  $_GET;                             
        return array();                                               
    }                                                                 

    public function get($name) {                                       
        if (!array_key_exists($name,$this->request)) return '';        
        return $this->request[$name];                                  
    }                                                                 
                                                                      
    public function set($name,$value) {                                
        $this->request[$name] = $value;                                
    }                                                                 
}
