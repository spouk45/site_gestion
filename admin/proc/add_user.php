<?php
include('../../config.php');
header(CHARSET);

session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}
include(DIR_ROOT.'admin/inc/admin_acces.php');

$data['name']=$_POST['user_name'];
$data['pass']=$_POST['user_password'];
//$data['connect']='connect';



try{
    $Account=new Account($data);
    include(CONNECT);
    $AccountManager=new AccountManager($db);
    $addUser=$AccountManager->addUser($Account);

    //$userId=$AccountManager->checkConnect($data);
    // on récupère les droits
    //$level=$AccountManager->getLevel($userId);
//$Account->setUserId($userId);
}
catch(Exception $e){
    $json['reponse']=$e->getMessage();
    $json['bool']=false;
    echo json_encode($json);
    exit();
}

$json['reponse']='Utilisateur ajouté avec succès.';
$json['bool']=true;
echo json_encode($json);

