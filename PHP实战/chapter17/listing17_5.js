function visitAll(form) {
    var lastControl;
    alerter = new DelayedAlerter();                                    
    for (var i = 0; i < form.elements.length; ++i) {                   
       var control = form.elements[i];
       if ( control.type != 'text'                                    
         && control.type != 'textarea'                                
         && control.type != 'password' )                              
           continue;                                                  
       control.focus();                                                
       lastControl = control;
    }
    lastControl.blur();                                               
    alerter.showMessages();                                           
    return alerter.valid;                                              
}
