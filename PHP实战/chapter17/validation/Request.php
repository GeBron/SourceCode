<?php
class CleanRequest {
    private $data = array();

    public function get($var) {
        if (!array_key_exists($var,$this->data)) return '';
        return $this->data[$var];
    }

    public function set($var,$value) {
        $clone = clone $this;
        $clone->data[$var] = $value;
        return $clone;
    }

    public function has($var) {
        return array_key_exists($var,$this->data);
    }

    public function delete($var) {
        unset($this->data[$var]);
    }

    public function toQueryString() {
        if (count($this->data) == 0) return '';
        $vars = array();
        foreach ($this->data as $var => $val) {
            $vars[] = "$var=$val";
        }
        return "?".join('&',$vars);
    }
}

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

    public function create() {
        $class = __CLASS__;
        return new  $class;
    }

}

