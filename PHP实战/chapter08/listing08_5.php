<?php
class StandardField extends TimeField {
    private $integerID;
    private $strftimeFormat;

    public function __construct($integerID,$strftimeFormat) {
        $this->integerID = $integerID;                                
        $this->strftimeFormat = $strftimeFormat;                      
    }
    public function get(Instant $time) {                              
        return strftime(                                              
            $this->strftimeFormat,                                    
            $time->getTimestamp());                                   
    }                                                                 

    public function setCopy(Instant $time,$value) {                   
        $array = $this->instantToArray($time);                        
        $array[$this->integerID] = $value;                            
        return $this->arrayToInstant($array);                         
    }                                                                 

    public function addToCopy(Instant $time,$value) {                 
        $array = $this->instantToArray($time);                        
        $array[$this->integerID] += $value;                           
        return $this->arrayToInstant($array);                         
    }                                                                 

    private function instantToArray(Instant $instant) {               
        return explode('-',                                           
            strftime(                                                 
                '%H-%M-%S-%m-%e-%Y',                                  
                $instant->getTimestamp())                             
            );                                                        
    }                                                                 

    private function arrayToInstant($array) {                         
        return new DateAndTime(                                          
            call_user_func_array('mktime',$array));                   
    }
}
