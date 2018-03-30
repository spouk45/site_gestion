<?php
include('../../config.php');
header(CHARSET);

session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}
if(!isset($_POST['id']) && !isset($_POST['val']) && !isset($_POST['type'])){
    echo 'Erreur lors de la récupération des données.';
    exit();
}

try{
    $data['gazId']=$_POST['id'];
    if($_POST['type']=='charge'){
        $data['charge']=$_POST['val'];
    }
    if($_POST['type']=='recup'){
        $data['recup']=$_POST['val'];
    }
    $data['year']=$_POST['year'];

    include('../class/StockGaz.php');
    include('../class/StockGazManager.php');

    include(CONNECT);

    // on doit chercher si une entrée existe déja
    $StockManager=new StockGazManager($db);
    $stock=$StockManager->getStockByGaz($data['year'],$data['gazId']);
    //print_r($stock);
    if($stock==null){ // si non, on doit créer
        $Stock=new StockGaz($data);
        $StockManager->addStock($Stock);
    }
    else{   // si oui update
        $data['id']=$stock['id'];
        if(!isset($data['charge'])){
            $data['charge']=$stock['charge'];
        }
        if(!isset($data['recup'])){
            $data['recup']=$stock['recup'];
        }
        $Stock=new StockGaz($data);
        $StockManager->updateStock($Stock);
    }
}
catch(Exception $e){
    $json['reponse']=$e->getMessage();
    echo json_encode($json);
    exit();
}
$json['reponse']='ok';
echo json_encode($json,JSON_UNESCAPED_UNICODE);
