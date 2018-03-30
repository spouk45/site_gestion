<?php
include('../../config.php');
header(CHARSET);

// --------- Verification droit ---------
session_start();
try{
    if(!isset($_SESSION['user'])){
        echo 'Accès refusé';
        throw new Exception('erreur de connection');
        //exit();
    }
}
catch(Exception $e){
        $json['reponse']=$e->getMessage();
        echo json_encode($json,JSON_UNESCAPED_UNICODE);
        //echo $e->getMessage();
        exit();

}
// ------------------------------------
try{
    $dateStart=$_POST['dateStart'];
    $dateEnd=$_POST['dateEnd'];

    //print_r($_POST);
    include (CONNECT);

    include(DIR_ROOT.'class/DateBuilder.php');
    $DateStart=new DateBuilder($dateStart);
    $date['start']=$DateStart->getTime();
$dateStart=$date['start'];

    //var_dump($DateStart);
    $DateEnd=new DateBuilder($dateEnd);
    $date['end']=$DateEnd->getTime();
    $dateEnd=$date['end'];

   // print_r($date);
    include(DIR_ROOT.'fluido/class/MoveManager.php');
    $MoveManager=new MoveManager($db);
    $data=$MoveManager->getMove('',$dateStart,$dateEnd);

    // formatage des dates
    if(!empty($data)){
    foreach($data as $key=>$value){
    $dateInt=$value['dateOfMove'];
    $Date=new DateTime();
    $Date->setTimestamp($dateInt);
    $newDate=$Date->format('d m Y');
    $data[$key]['dateOfMove']=$newDate;

    }


}

$tabTitle=array(
    'serialFiche'=>'N° fiche',
    'bottleSerial'=>'N° bouteille',
    'typeName'=>'Type de bouteille',
    'dateOfMove'=>'Date',
    'chargeOut'=>'Charge',
    'chargeIn'=>'Récupération',
    'gazName'=>'Gaz',
    'customerName'=>'Client',
    'customerSerial'=>'N° client',
    'techName'=>'Technicien',
    'productName'=>'Equipement',
    'equipmentSerial'=>'N° équipement'
);
$tableParam['delete']=1;
$tableParam['edit']=0;
}
catch(Exception $e){
$json['reponse']=$e->getMessage();
//echo json_encode($json,JSON_UNESCAPED_UNICODE);
//echo $e->getMessage();
//exit();
}
//$json['reponse']='ok';
//echo json_encode($json);


include(DIR_ROOT.'inc/table.php');
