<?php
include('../../config.php');
header(CHARSET);

//print_r($_POST);
try{
    // --------- Verification droit ---------
    session_start();
    if(!isset($_SESSION['user'])){
        echo 'Accès refusé';
        throw new Exception('erreur de connection');
        //exit();
    }
    // ------------------------------------

    // **** R�cup�ration des donn�es ****
    //print_r($_POST);
    if(!isset($_POST)){
        throw new Exception('Aucune données récupérer');
    }
    if(empty($_POST['id'])){
        throw new Exception('il manque des données');
    }

    $id=$_POST['id'];

    include(CONNECT);
    include('../class/HistoryManager.php');

    $HistoryManager=new HistoryManager($db);
    $HistoryManager->deleteHistory($id);

}
catch(Exception $e){
    $json['reponse']=$e->getMessage();
    echo json_encode($json,JSON_UNESCAPED_UNICODE);
    //echo $e->getMessage();
    exit();
}
$json['reponse']='ok';
echo json_encode($json,JSON_UNESCAPED_UNICODE);
