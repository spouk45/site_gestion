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
    if(!isset($_POST['name'])){ // name ou serial
        throw new Exception('Aucune donnée récupérée');
    }

    $value=$_POST['name'];
    include(CONNECT);
    include(DIR_ROOT.'client/class/CustomerManager.php');
    $CustomerManager=new CustomerManager($db);
    $data=$CustomerManager->getCustomer($value);
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
