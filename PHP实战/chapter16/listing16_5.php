<?php
class Redirect {
    var $url;
    function __construct($url) {
       $this->url = $url;
    }

    function display() {
        header("Location: ".$this->url);
        exit;
    }
}
