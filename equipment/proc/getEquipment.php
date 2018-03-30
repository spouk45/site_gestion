<?php
include('../../config.php');
header(CHARSET);

// --------- Verification droit ---------

// ------------------------------------


try{
    session_start();
    if(!isset($_SESSION['user'])){
        echo 'Accès refusé';
        throw new Exception('erreur de connection');
        //exit();
    }
    // **** R�cup�ration des donn�es ****
    if(!isset($_POST['clientId'])){ //
        throw new Exception('Aucune donnée récupérée');
    }

    $clientId=$_POST['clientId'];
    include(CONNECT);
    include(DIR_ROOT.'equipment/class/EquipmentManager.php');
    $EquipmentManager=new EquipmentManager($db);
    $data=$EquipmentManager->getEquipment($clientId);
}
catch(Exception $e){
    $json['reponse']=$e->getMessage();
    echo json_encode($json,JSON_UNESCAPED_UNICODE);
    //echo $e->getMessage();
    exit();
}
$json['data']=$data;
$json['reponse']='ok';
echo json_encode($json,JSON_UNESCAPED_UNICODE);
