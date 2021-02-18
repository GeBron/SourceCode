<?php
class DateAndTime {
    private $timestamp;
    public function __construct() {
        $args = func_get_args();
        ClassUtil::callMethodForArgs($this,$args);
    }

    public function construct_() {
        $this->timestamp = time();
    }

    public function construct_DateAndTime($DateAndTime) {
        $this->timestamp = $DateAndTime->getTimestamp();
    }

    public function construct_number($timestamp) {
        $this->timestamp = $timestamp;
    }

    public function construct_string($string) {
        $this->timestamp = strtotime($string);
    }

    public function getTimestamp() {
        return $this->timestamp;
    }
}
