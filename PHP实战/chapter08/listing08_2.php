<?php
class ClassUtil {
    public static function typeof($var) {                             
        if (is_object($var)) return get_class($var);                  
        if (is_array($var)) return 'array';                           
        if (is_numeric($var)) return 'number';                        
        return 'string';                                              
    }                                                                 

    public static function typelist($args) {                          
        return array_map(array('self','typeof'),$args);               
    }                                                                 

    public static function callMethodForArgs(                         
        $object,$args,$name='construct')                              
    {
        $method = $name.'_'.implode('_',self::typelist($args));        
        if (!is_callable(array($object,$method)))                      
            throw new Exception(                                      
                sprintf(                                              
                    "Class %s has no method '$name' that takes ".     
                    "arguments (%s)",                                 
                        get_class($object),                           
                        implode(',',self::typelist($args))            
                    )                                                 
                );                                                    
        call_user_func_array(array($object,$method),$args);            
    }
}
