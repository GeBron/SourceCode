<?php
mysql_connect('localhost','kane','hok4h7');
mysql_select_db('ourapp');
if (!empty($headline)) {                                               
    if ($id) {                                                        
        $sql = "UPDATE News SET ".                                    
            "headline = '".$headline."',".                            
            "text = '".$text."' ".                                    
            "WHERE id = ".$id;                                        
    } else {                                                          
        $sql = "INSERT INTO News ".                    
            "(headline,text) ".                        
            "VALUES ('".$headline."','"                               
            .$text."') ";                                             
    }
    mysql_query(mysql_real_escape_string($sql));
    header("Location: newslist.php");                                 
    exit;                                                             
} else {                                                               
    if ($id) {
        $sql = 'SELECT text, headline '.
            'FROM News WHERE id = '.$id;
        $r = mysql_query(mysql_real_escape_string($sql));
        list($text,$headline) = mysql_fetch_row($r);
    }
    echo '<html>';                                                      
    echo '<body>';                                                      
    echo '<h1>Submit news</h1>';                                        
    echo '<form method="POST">';                                        
    echo '<input type="hidden" name="id"';                              
    echo 'value="'.$id.'">';                                            
    echo 'Headline:';                                                   
    echo '<input type="text" name="headline" ';                         
    echo 'value="'.$headline.'"><br>';                                  
    echo 'text:';                                                       
    echo '<textarea name="text" cols="50" rows="20">';                  
    echo ''.$text.'</textarea><br>';                                    
    echo '<input type="submit" value="Submit news">';                   
    echo '</form>';                                                     
    echo '</body>';                                                     
    echo '</html>';                                                     
}
