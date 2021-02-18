<?php
class Document {
    private $_text;

    private function __get($name) {
        $method = 'get'.$name;
        return $this->$method();
    }

    private function __set($name,$value) {
        $method = 'set'.$name;
        return $this->$method($value);
    }

    function getText() { return $this->_text; }
    function setText($text) { $this->_text = $text; }
}
