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
    if(!isset($_POST['name'])){
        throw new Exception('Aucune donnée récupérée');
    }

    include(DIR_ROOT.'fluido/class/Gaz.php');
    $Gaz=new Gaz($_POST);

    include(CONNECT);
    include(DIR_ROOT.'fluido/class/GazManager.php');
    $GazManager=new GazManager($db);
    $GazManager->addGaz($Gaz);
}
catch(Exception $e){
    $json['reponse']=$e->getMessage();
    echo json_encode($json,JSON_UNESCAPED_UNICODE);
    //echo $e->getMessage();
    exit();
}
$json['reponse']='ok';
echo json_encode($json);
