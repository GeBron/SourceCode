<?php
class SimpleTemplateAdapter {
    private $template;

    public function __construct($template) {
         $this->template = $template;
    }

    public function assign($var,$value) {
        $this->template->set($var,$value);
    }

    public function fetch() {
        return $this->template->asHtml();
    }
}
