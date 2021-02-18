<?php
interface SmartyTemplateInterface {
    public function fetch($template);
    public function display($template);
    public function assign($name,$value);
    public function get_template_vars();
}

