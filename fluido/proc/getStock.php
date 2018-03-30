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
    if(!isset($_POST['year'])){ //
        throw new Exception('Aucune donnée récupérée');
    }
    if(isset($_POST['notEdit'])){
        $notEdit=1;
    }
    $year=$_POST['year'];

    include(CONNECT);
    include('../class/StockGazManager.php');
    $StockGazManager=new StockGazManager($db);
    $stockList=array();
    $stockList=$StockGazManager->getStock($year);


    // on construit tt de meme la table vide
    include('../class/GazManager.php');
    $GazManager=new GazManager($db);
    $gazList=$GazManager->getGaz('');

if($stockList){
    foreach($stockList as $value){
            foreach($gazList as $key=>$value2){
                if($value['name']==$value2['name']){
                    $gazList[$key]['charge']=$value['charge'];
                    $gazList[$key]['recup']=$value['recup'];
                    $gazList[$key]['stockId']=$value['stockId'];
                }
            }

    }

}
    $data=$gazList;

    $tabTitle=array(
        'name'=>'Gaz',
        'charge'=>'Gaz Neuf',
        'recup'=>'Gaz récupéré',
    );
}
catch(Exception $e){
  // $json['reponse']=$e->getMessage();
   // echo json_encode($json,JSON_UNESCAPED_UNICODE);
    echo $e->getMessage();
    exit();
}
$json['data']=$data;
//$json['reponse']='ok';
//$json['html']=

if(!isset($notEdit)){
    $tableParam['delete']=1;
    $tableParam['edit']=1;
}


?><input type="hidden" id="jsonStock" value="<?php echo htmlspecialchars(json_encode($json['data'],JSON_UNESCAPED_UNICODE));?>"><?php
include(DIR_ROOT.'inc/table.php');

//echo json_encode($json,JSON_UNESCAPED_UNICODE);