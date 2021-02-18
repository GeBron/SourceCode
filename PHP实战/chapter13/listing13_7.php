<?php
$finder = new UserFinder;
$users = $finder->findAll();
ob_start();                                                         
?>
<?php echo '<?xml version="1.0" ?>'."\n"; ?>                        
<userlist>                                                          
  <?php foreach ($users as $u) : ?>                                 
    <user>                                                          
    <username>                                                      
      <?php echo htmlentities($u->getUserName()) ?>                 
    </username>                                                     
    <firstname>                                                     
      <?php echo htmlentities($u->getFirstName()) ?>                
    </firstname>                                                    
    <lastname>                                                      
      <?php echo htmlentities($u->getLastName()) ?>                 
    </lastname>                                                     
    <email><?php echo htmlentities($u->getEmail()) ?></email>       
    <role><?php echo htmlentities($u->getRole()) ?></role>          
    <id><?php echo htmlentities($u->getID()) ?></id>                
    </user>                                                         
  <?php endforeach; ?>                                              
</userlist>                                                         

<?php
$xml = ob_get_contents();                                           
ob_end_clean();                                                     
print processXslt($xml,'userlist.xsl');                             

function processXslt($xml,$xslfile) {
    $dom = new DomDocument;                                          
    $dom->loadXML($xml);                                             
    $xsldom = new domDocument();                                     
    $xsldom->load($xslfile);                                         
    $proc = new xsltprocessor;                                       
    $proc->importStylesheet($xsldom);
    return $proc->transformToXml($dom);
}
