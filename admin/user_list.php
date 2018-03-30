<?php include('../config.php');?>
<?php include(HEAD);
// controle d'acces
session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}
include(DIR_ROOT.'admin/inc/admin_acces.php');

include(DIR_ROOT.'admin/inc/header.php');
?>

<h2>liste des utilisateurs</h2>

<?php
try{
    include(CONNECT);
    $AccountManager=new AccountManager($db);
    $userList=$AccountManager->userList();
    }
catch(Exception $e){
   echo $e->getMessage();
    exit();
    }


?><pre><?php print_r($userList);?></pre><?php
?>

<?php include(DIR_ROOT.'admin/inc/footer.php');?>