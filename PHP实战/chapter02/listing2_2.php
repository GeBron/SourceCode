<?php
class DateAndTime extends LoggingClass {
    private $timestamp;

    function __construct($timestamp=FALSE) {
        $this->init($timestamp);
    }

    protected function _init($timestamp) {
        $this->timestamp = $timestamp ? $timestamp : time();
    }

    function getTimestamp() { return $this->timestamp; }

    protected function _before(DateAndTime $other) {
        return $this->timestamp < $other->getTimestamp();
    }
}
