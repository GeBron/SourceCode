<?php
require_once 'PhptalTemplateInterface.php';

class PhptalSkin implements PhptalTemplateInterface {
    private $smarty;
    private $path;
    private $context;
    public function __construct($path) {
        $this->smarty = new Smarty;                                  
        $this->path = str_replace('.html','.tpl',$path);             
        $this->context = new PhptalSkinContext;                      
    }

    public function execute() {
        return $this->smarty->fetch($this->path);                     
    }


    public function set($name,$value) {
        $escaped = htmlentities($value,ENT_QUOTES,'UTF-8');           
        $this->smarty->assign($name,$escaped);                        
        $this->context->set($name,$escaped);                          
    }

    public function getContext() {
        return $this->context;                                        
    }
}
