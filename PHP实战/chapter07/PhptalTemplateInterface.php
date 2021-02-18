<?php
interface PhptalTemplateInterface {
    public function set($name,$value);
    public function execute();
    public function getContext();
}
