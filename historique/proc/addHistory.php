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
    if(empty($_POST['equipmentId']) || empty($_POST['text']) || empty($_POST['date'])){
        throw new Exception('il manque des données');
    }

    $data['text']=$_POST['text'];
    $data['equipmentId']=$_POST['equipmentId'];

    include(CONNECT);
    include(DIR_ROOT.'class/DateBuilder.php');
    include('../class/History.php');
    include('../class/HistoryManager.php');

    $DateBuilder=new DateBuilder($_POST['date']);
    $data['date']=$DateBuilder->getTime();

    $History=new History($data);
    //var_dump($History);
    $HistoryManager=new HistoryManager($db);
    $HistoryManager->addHistory($History);

}
catch(Exception $e){
    $json['reponse']=$e->getMessage();
    echo json_encode($json,JSON_UNESCAPED_UNICODE);
    //echo $e->getMessage();
    exit();
}
$json['reponse']='ok';
echo json_encode($json,JSON_UNESCAPED_UNICODE);
