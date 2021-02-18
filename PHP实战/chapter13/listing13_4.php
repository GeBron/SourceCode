<?php
require_once 'UserFinder.php';
require_once 'HTTPPlus.php';
define('SMARTY_DIR','/usr/local/lib/php/Smarty/');
require(SMARTY_DIR.'Smarty.class.php');

$finder = new UserFinder;
$users = $finder->findAll();

$smarty = new Smarty;
$smarty->assign('users',$users);
$smarty->display('userlist.tpl');
?>
