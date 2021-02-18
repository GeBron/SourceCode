<?php
class LinkTest extends UnitTestCase {
    function getEchoed($search,$form,$blank_target=FALSE) {            
        ob_start();                                                   
        print_link($search,$form,'hello',$blank_target);              
        $html = ob_get_contents();                                    
        ob_end_clean();                                               
        return $html;                                                 
    }

    function testFirstIf() {                                          
        $html = $this->getEchoed(FALSE,FALSE);                        
        $this->assertEqual(                                           
            '<a href="index.php">hello</a>'."\n",                     
            $html);                                                   
    }                                                                 

    function testSecondIf() {                                         
        $html = $this->getEchoed(FALSE,TRUE);                         
        $this->assertEqual(                                           
        '<a href="form.php">hello</a>'."\n",                          
        $html);                                                       
    }                                                                 
                                                                      
    function testElse() {                                             
        $html = $this->getEchoed(TRUE,FALSE);                         
        $this->assertEqual(                                           
            '<a href="index.php?action=search">hello</a>'."\n",       
            $html);                                                   
    }                                                                 
                                                                      
    function testBlankTarget() {                                      
        $html = $this->getEchoed(FALSE,FALSE,TRUE);                   
        $this->assertEqual(                                           
            '<a href="index.php" target="_blank">hello</a>'."\n",     
            $html);                                                   
    }                                                                 
}
