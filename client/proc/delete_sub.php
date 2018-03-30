<?php
include('../../../config.php');
header(CHARSET);

session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}
if(!isset($_GET['id'])){
    echo 'Erreur lors de la récupération des données.';
    exit();
}

try{
    $id=$_GET['id'];
    include(CONNECT);
    include(DIR_ROOT.'module/client/class/SubManager.php');
    $SubManager=new SubManager($db);
    $SubManager->deleteId($id);

}
catch(Exception $e){
    $json['reponse']=$e->getMessage();
    echo json_encode($json);
    exit();
}
$json['reponse']='ok';
echo json_encode($json);