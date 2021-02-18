<?php
function insert($type,$data) {
    switch ($type) {
        case 'News':
            $sql = "INSERT INTO News (headline,body) VALUES('".
                $data['headline']."','".$data['body']."')";
            break;
        case 'Topics':
            $sql = "INSERT INTO Topics (name) VALUES('".
                $data['name']."')";
            break;
    }
    // Insert into the database
}
