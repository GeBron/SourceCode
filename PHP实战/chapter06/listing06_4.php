<?php
class File {
    public function __construct($name) {
        $this->name = $name;
    }
    function getContents() {
        return file_get_contents($this->name);
    }
}
