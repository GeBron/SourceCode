<?php
session_start();
session_register('current_user');

mysql_connect('localhost','dbuser','secret');
mysql_select_db('ourapp');
if ($username || $current_user) {
    if ($username) {
        $sql = "SELECT id,username,password FROM Users ".                
            "WHERE password = '".md5($password)."' ".                    
            "AND username = '".$username."'";                            
        $r = mysql_query($sql);                                          
        $current_user = mysql_fetch_assoc($r);                           
    }
    if ($current_user) {
        if ($headline) {

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
            mysql_query($sql);

            header("Location: http://localhost/newslist.php");

            exit;                                                         
        } else {
            if ($id) {

                $sql = 'SELECT text, headline '.                          
                    'FROM News WHERE id = '.$id;                          
                $r = mysql_query($sql);                                   
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
    }
} else {
    echo '<html>';

    echo '<body>';                                                       
    echo '<h1>Log in</h1>';                                              
    echo '<form method="POST">';                                         
    echo 'User name: <input type="text" name="username">';               
    echo '<br>';                                                         
    echo 'Password : <input type="password" name="password">';           
    echo '<br>';                                                         
    echo '<input type="submit" value="Log in">';                         
    echo '</form>';                                                      
    echo '</body>';                                                      
    echo '</html>';                                                      
} ?>
