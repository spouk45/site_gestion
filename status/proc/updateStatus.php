<?php
include('../../config.php');//
header(CHARSET);

session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}
if(!isset($_POST)){
    echo 'Erreur lors de la récupération des données.';
    exit();
}


try{
    $data['id']=$_POST['id'];
    $data['name']=$_POST['name'];
    include(DIR_ROOT.'status/class/Status.php');
    $Status=new Status($data);


    include(CONNECT);
    include(DIR_ROOT.'status/class/StatusManager.php');
    $StatusManager=new StatusManager($db);
    $StatusManager->updateStatus($Status);

}
catch(Exception $e){
    $json['reponse']=$e->getMessage();
    echo json_encode($json);
    exit();
}
$json['reponse']='ok';
echo json_encode($json);