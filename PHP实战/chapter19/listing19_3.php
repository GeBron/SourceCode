<?php
try {
    $conn = Creole::getConnection(
        "mysql://user:password@localhost/newsdb");
}
catch (Exception $e) {
    throw new Exception($e->getMessage());
}
$stmt = $conn->prepareStatement(
    "SELECT name from Products where id = ?");
$stmt->setInt(1,$id);
$resultset = $stmt->executeQuery();
$resultset->first();
$name = $resultset->getString('name');
