<?php
for ($i=0; $i<count($vars); $i += 1) {                                
    $var = $vars[$i];                                                 
    if (!isset($$var)) {                                               
        if (empty($_POST[$var])) {                                     
            if (empty($_GET[$var]) && empty($query[$var])) {          
                $$var = '';                                           
            } elseif (!empty($_GET[$var])) {                          
                $$var = $_GET[$var];                                  
            } else {                                                  
                $$var = $query[$var];                                 
            }                                                         
        } else {
            $$var = $_POST[$var];
        }
    }
}
