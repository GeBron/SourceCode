<?php
class RawRequest {
    private $data = array();

    public function __construct($data=FALSE) {                        
        $this->data = $data                                           
                    ? $data                                           
                    : $this->initFromHttp();                          
        unset($_REQUEST);                                             
        unset($_POST);                                                
        unset($_GET);                                                 
    }

    private function initFromHttp() {                                 
        if (!empty($_POST)) return  $_POST;                           
        if (!empty($_GET)) return  $_GET;                             
        return array();                                               
    }                                                                 

    public  function getForValidation($var) {                         
        return $this->data[$var];                                     
    }                                                                 
}
