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
    if(!isset($_POST['id'])){
        throw new Exception('Aucune données récupérer');
    }
//$json['print']=$_POST;
    include('../class/Bottle.php');
    $id=$_POST['id'];
//var_dump($Bottle);
    include(CONNECT);
    include('../class/BottleManager.php');
    $BottleManager=new BottleManager($db);
    $BottleManager->deleteBottle($id);
}
catch(Exception $e){
    $json['reponse']=$e->getMessage();
    echo json_encode($json,JSON_UNESCAPED_UNICODE);
    //echo $e->getMessage();
    exit();
}
$json['reponse']='ok';
echo json_encode($json);
