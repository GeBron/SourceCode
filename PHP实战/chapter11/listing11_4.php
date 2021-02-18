<?php
function testOutputVars() {
    $reporter = new TemplateBasedReporter;                         
    ob_start();                                                   
    $test = new SomeTest();                                       
    $test->run($reporter);                                        
    ob_end_clean();                                               
    extract($reporter->templateVars());                           
    $this->assertEqual('SomeTest',$testname);                     
    $this->assertEqual(1,$run);                                   
    $this->assertEqual(1,$cases);                                 
    $this->assertEqual(0,$passes);                                
    $this->assertEqual(2,$failures);                              
    $this->assertEqual(0,$exceptions);                            
    $this->assertEqual(FALSE,$ok);                                
    $this->assertEqual(array(                                     
        array(                                                    
            'message'=>"Equal expectation fails because ".        
                "[Integer: 1] differs from [Integer: 2] ".        
                "by 1 at line [8]",                               
            'breadcrumb'=>'testSomething'                         
        ),                                                        
        array(                                                    
            'message'=>"Equal expectation fails because ".        
                "[Integer: 2] differs from [Integer: 3] ".        
                "by 1 at line [9]",                               
            'breadcrumb'=>'testSomething'                         
        ),                                                        
    ),$failreports);                                              
}
