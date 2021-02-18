<?php
require_once 'UserFinder.php';
require_once 'HTTPPlus.php';

$finder = new UserFinder;
$users = $finder->findAll();

include 'userlist_template.php';
?>
