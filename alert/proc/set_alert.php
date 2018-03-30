
<?php
include('../../config.php');
header(CHARSET);

session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}
//print_r($_POST);
if(!isset($_POST['id']) && !isset($_POST['temp'])) {
    echo 'Erreur lors de la récupération des données id client.';
    exit();
}

try{ // en cours
    // chercher si un status_client exist
    $data['statusId']=$_POST['id'];
    $data['countDay']=$_POST['temp'];


    include(DIR_ROOT.'alert/class/AlertStatus.php');
    $AlertStatus=new AlertStatus($data);

    include(CONNECT);
    include(DIR_ROOT.'alert/class/AlertStatusManager.php');
    $AlertStatusManager=new AlertStatusManager($db);
    $AlertStatusManager->updateAlertStatus($AlertStatus);

}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}