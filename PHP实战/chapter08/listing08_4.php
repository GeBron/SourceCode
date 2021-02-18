<?php
class ClassRenamer {
    private $oldName;
    private $newName;

    public function __construct($old,$new) {                          
        $this->oldName = $old;                                        
        $this->newName = $new;                                        
    }                                                                 

    public function replaceKeywords($string) {
        $re =
           '/(interface|class|extends|implements|instanceof)\s+'.
           $this->oldName.'\b/';
        return preg_replace($re,'$1 '.$this->newName,$string);
    }

    public function replaceStaticCalls($string) {
        $re = '/\b'.$this->oldName.                                    
           '\s*::\s*'.                                                 
           '(\$)?'.                                                    
           '(\w+)/';                                                   
        return preg_replace($re,$this->newName.'::$1$2',$string);      
    }

    public function process($string) {                                
        return $this->replaceStaticCalls(                             
            $this->replaceKeywords($string)                           
        );                                                            
    }                                                                 
}
