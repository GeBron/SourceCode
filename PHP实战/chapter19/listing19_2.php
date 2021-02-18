<?php
try {                                                         
    $conn = new PDO(                                          
        'mysql:dbname=newsdb;host=localhost',                 
        'user',                                               
        'password');                                          
}
catch (Exception $e) {                                        
    throw new Exception($e->getMessage());                    
}                                                             
$conn->setAttribute(                                          
    PDO::ATTR_ERRMODE,                                        
    PDO::ERRMODE_EXCEPTION);                                  
$stmt = $conn->prepare(                                       
    "SELECT name from Products where id = :id");              
$stmt->bindParam(':id',$id);                                  
$stmt->execute();                                             
$row = $stmt->fetch();                                        
