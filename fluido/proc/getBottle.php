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
    if(!isset($_POST['type']) || !isset($_POST['serial'])){ //
        throw new Exception('Aucune donnée récupérée');
    }

    $type=$_POST['type'];
    $serial=$_POST['serial'];

    if($type!=1 && $type!=2){throw new Exception('Erreur sur le type de bouteille.');}


    include(CONNECT);
    include('../class/BottleManager.php');
    $BottleManager=new BottleManager($db);
    $data=$BottleManager->getBottleByType($type,$serial);
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
