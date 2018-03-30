
<?php
include('../../config.php');
header(CHARSET);

session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}
//print_r($_POST);
if(!isset($_POST['customerId']) && !isset($_POST['statusId']) && !isset($_POST['date'])) {
    echo 'Erreur lors de la récupération des données id client.';
    exit();
}

try{ // en cours
    // chercher si un status_client exist
    $customerId=$_POST['customerId'];
    include(DIR_ROOT.'/class/Generic.php');
    include(CONNECT);
    $Gen=new Generic($db);
    $table='status_client';
    $param='';
    $list='id';
    $order='';
    $seek=array('customerId'=>$customerId);
    $countStat=$Gen->getData($table,$seek,$param,$list,$order);

    $statusId=$_POST['statusId'];
    $customerId=$_POST['customerId'];
    $date=$_POST['date'];
    $id=$_POST['id'];

    $data=array();
    if($id!=null){
        $data['id']=$id;
    }
    $data['customerId']=$customerId;
    $data['statusId']=$statusId;
    $data['date']=$date;

    include(DIR_ROOT.'status/class/StatusClient.php');
    $Status=new StatusClient($data);
    include(DIR_ROOT.'status/class/StatusManager.php');
    $StatusManager=new StatusManager($db);

    if($countStat==null){
        // alors on doit ajouter ds la bdd
        $StatusManager->addStatusClient($Status);
    }
    else {
        // on doit editer ds la bdd
        $StatusManager->updateStatusClient($Status);

    }

}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}