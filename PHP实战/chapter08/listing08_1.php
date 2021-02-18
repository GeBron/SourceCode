<?php
class DateAndTime {
    private $timestamp;
    public function __construct($timestamp=FALSE) {                   
        if (!$timestamp) $timestamp = time();                         
        $this->timestamp = $timestamp;                                
    }                                                                 

    public function createFromDateAndTime(DateAndTime $DateAndTime) {
   
        return new DateAndTime($DateAndTime->getTimestamp());

    }                                                                 

    public function createFromString($string) {                       
        return new DateAndTime(strtotime($string));                      
    }                                                                 

    public function getTimestamp() {
        return $this->timestamp;
    }
}
