<?php
$mysqli = new Mysqli(                                         
    'localhost','user','password','newsdb');                  
$stmt = $mysqli->prepare(                                     
    "SELECT name from Products where id = ?");                
$stmt->bind_param("i",$id);                                   
$stmt->execute();                                             
$stmt->bind_result($name);                                    
$stmt->fetch();                                               
$stmt->close();
