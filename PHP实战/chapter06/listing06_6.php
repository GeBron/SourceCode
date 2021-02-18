<?php
class Template {
    private $data;
    private $file;

    public function __construct($file) {
         $this->file = new File($file);                               
         $this->data = new TemplateData;                              
    }

    public function set($var,$value) {
        $this->data->set($var,$value);
    }

    private function processTemplate() {                               
        extract($this->data->getArray());                              
        $string = $this->file->getContents();                         
        eval('?>'.$string);                                           
    }

    public function asHtml() {                                        
        ob_start();                                                   
        $this->processTemplate();                                     
        $string = ob_get_contents();                                  
        ob_end_clean();                                               
        return $string;                                               
    }                                                                 
}
