<?php
include('../../config.php');
header(CHARSET);

session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}
if(!isset($_POST['id'])){
    echo 'Erreur lors de la récupération des données.';
    exit();
}

try{
    $id=$_POST['id'];
    include(CONNECT);
    include(DIR_ROOT.'equipment/class/MarkManager.php');
    $MarkManager=new MarkManager($db);
    $MarkManager->deleteMark($id);

}
catch(Exception $e){
    $json['reponse']=$e->getMessage();
    echo json_encode($json);
    exit();
}
$json['reponse']='ok';
echo json_encode($json);