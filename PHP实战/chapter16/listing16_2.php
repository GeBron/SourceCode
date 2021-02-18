<?php
$filtering = new Filtering;                                            
$filtering->addAlphanumericFilter(                                    
    'username',                                                       
    'The user name must be filled in'                                 
);                                                                    
$filtering->addEmailFilter(                                           
    'email',                                                          
    'The email address is not valid'                                  
);                                                                    
if ($filtering->filter(new RawRequest)) {                             
   $clean = $filtering->getCleanRequest();                            
   $email = $clean->get('email');                                      
   // etc. Process -- redirect
}
else {
   $messages = $filtering->getErrors();                                
}
