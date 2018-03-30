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
    if(empty($_POST['id']) || empty($_POST['text'])){
        throw new Exception('il manque des données');
    }

    $data['text']=$_POST['text'];
    $data['id']=$_POST['id'];

    include(CONNECT);
    include('../class/History.php');
    include('../class/HistoryManager.php');


    $History=new History($data);
    //var_dump($History);
    $HistoryManager=new HistoryManager($db);
    $HistoryManager->editHistory($History);

}
catch(Exception $e){
    $json['reponse']=$e->getMessage();
    echo json_encode($json,JSON_UNESCAPED_UNICODE);
    //echo $e->getMessage();
    exit();
}
$json['reponse']='ok';
echo json_encode($json,JSON_UNESCAPED_UNICODE);
