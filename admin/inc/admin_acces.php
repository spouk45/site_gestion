<?php include(CONNECT);
include(DIR_ROOT.'module/register/class/Account.php');
$AccountManager=new AccountManager($db);
$level=$AccountManager->getLevel($_SESSION['user']['id']);

if($level['admin']!=1){
echo 'Accès refusé. Vous n\'avez pas les droits d\'administration.';
exit();
}


