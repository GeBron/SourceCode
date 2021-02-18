<?php
class TemplateData {
    private $vars;
    public function set($var,$value) {
        $this->vars[$var] = $value;
    }
    public function getArray() {
        return $this->vars;
    }
}
