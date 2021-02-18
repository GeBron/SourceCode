<?php
$formName = 'registration-form';
$sxml = simplexml_load_file('regform.html');                   
$elements = $sxml->xpath(                                     
    "//form[@name='".$formName."']".                          
    "//*[name()='input' or name()='textarea'][@onBlur]");     
foreach($elements as $element) {                              
    print $element['name']."\n";                              
    print $element['onBlur']."\n";                            
}                                                             
