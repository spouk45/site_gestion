<?php
include('../../config.php');
header(CHARSET);

session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}
if(!isset($_POST['clientId']) || !isset($_POST['productId'])){
    echo 'Erreur lors de la récupération des données.';
    exit();
}

try{
    $data=$_POST;
    include(DIR_ROOT.'equipment/class/Equipment.php');
    $Equipment=new Equipment($data);

    include(CONNECT);
    include(DIR_ROOT.'equipment/class/EquipmentManager.php');
    $EquipmentManager=new EquipmentManager($db);
    $EquipmentManager->addEquipment($Equipment);

}
catch(Exception $e){
    $json['reponse']=$e->getMessage();
    echo json_encode($json);
    exit();
}
$json['reponse']='ok';
echo json_encode($json);