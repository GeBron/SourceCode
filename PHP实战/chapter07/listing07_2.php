<?php
require_once 'SmartyTemplateInterface.php';

class SmartySkin implements SmartyTemplateInterface {
    private $vars = array();

    public function assign($name,$value) {
        $this->vars[$name] = $value;

    }

    public function fetch($template) {
        $phptal = new PHPTAL_Template(

                str_replace('.tpl','.html',$template));                  
        $phptal->setAll($this->vars);                                    
        return $phptal->execute();                                       
    }

    public function get_template_vars($name=FALSE) {

       if ($name) return $this->vars[$name];                             
       return $this->vars;                                               
    }                                                                    

    public function display($template) {

        echo $this->fetch($template);                                    
    }                                                                    
}
