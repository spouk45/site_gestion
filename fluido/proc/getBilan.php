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

    //récupération de l'année précédente
    $Date=new DateTime();
    $Date->setTimestamp($dateStart);
    $year=$Date->format('Y')-1;

    // print_r($date);
    include(DIR_ROOT.'fluido/class/MoveManager.php');
    $MoveManager=new MoveManager($db);
    $data=$MoveManager->getMove('',$dateStart,$dateEnd);

    include (DIR_ROOT.'fluido/class/GazManager.php');
    $GazManager=new GazManager($db);
    $gazList=$GazManager->getGaz('');

    include(DIR_ROOT.'fluido/class/StockGazManager.php');
    $StockManager=new StockGazManager($db);
    $stockBefore=$StockManager->getStock($year);

    include(DIR_ROOT.'fluido/class/BottleManager.php');
    $BottleManager=new BottleManager($db);
    $bottle=$BottleManager->getBottleBilan($dateStart,$dateEnd);

    foreach($gazList as $key=>$value){ // ajout des charge et recup ds la tab principale
        $gazList[$key]['charge']=0;
        $gazList[$key]['recup']=0;
    }

    foreach($data as $key=>$value){ // Résultat des moves charge et recup faite
        if($value['typeId']==1){ // alors c'est une charge
            $gazId=$value['gazId'];
            $chargeOut=$value['chargeOut'];

            foreach($gazList as $k => $valueGaz){
                if($valueGaz['id']==$gazId){
                    $gazList[$k]['charge']-=$chargeOut;
                }
            }

        }
        if($value['typeId']==2 ||$value['typeId']==3 ){ // alors c'est une recup ou charge depuis une recup
            $gazId=$value['gazId'];
            $chargeOut=$value['chargeOut'];
            $chargeIn=$value['chargeIn'];

            foreach($gazList as $k => $valueGaz){
                if($valueGaz['id']==$gazId){
                    $gazList[$k]['recup']-=$chargeOut;
                    $gazList[$k]['recup']+=$chargeIn;
                }
            }
        }

    }

    // on doit récupérér les stock de début d'année pour finir le tableau
    foreach($gazList as $k => $v){
            foreach($stockBefore as $key => $value){
                if($value['gazId']==$v['id']){
                    $gazList[$k]['charge']+=$value['charge'];
                    $gazList[$k]['recup']+=$value['recup'];
                }
            }

    }

    // on doit récupérer les achat de bouteilles acheté et celles rendu


    // on doit calculer la charge totale des bouteilles achetés, et rendu
    // !!! OUBLIE DE SEPARATION DU TYPE GAZ !!!
    $chargeNeuve=array();
    $chargeRecup=array();
        foreach($bottle as $value){
            // bouteille de charge
            if($value['typeId']==1){
                if(!isset($chargeNeuve[$value['gazId']])){
                    $chargeNeuve[$value['gazId']]=$value['charge'];
                }
                else{
                    $chargeNeuve[$value['gazId']]+=$value['charge'];
                }

            }
            else{// bouteille de transfert ou recup
                $MoveBottle=new MoveManager($db);
                $moveListOfBottle=$MoveBottle->getMove($value['id'],'','');
                foreach($moveListOfBottle as $v){
                    if(!isset($chargeRecup[$v['gazId']])){
                        $chargeRecup[$v['gazId']]=$v['chargeIn']-$v['chargeOut'];
                    }
                    else {
                        $chargeRecup[$v['gazId']]+=$v['chargeIn']-$v['chargeOut'];
                    }
                }
            }
        }

    // -----   mise à jour de gazLIst avec retrait des bouteilles rendu (donc plus en stock)

    foreach($chargeNeuve as $key=>$value){ // ajout des bouteille neuve
        foreach($gazList as $k => $v){
            if($key==$v['id']){
                $gazList[$k]['charge']+=$value;
            }
        }
    }

    foreach($chargeRecup as $key=>$value){ // retrai des bouteille recup
        foreach($gazList as $k => $v){
            if($key==$v['id']){
                $gazList[$k]['recup']=$gazList[$k]['recup']-$value;
            }
        }
    }

$data=$gazList;

  /*  ?><pre><?php print_r($gazList);?></pre><?php
      ?><pre><?php print_r($bottle);?></pre><?php
    ?><pre><?php print_r($chargeRecup);?></pre><?php
    ?><pre><?php print_r($chargeNeuve);?></pre><?php*/


    $tabTitle=array(
        'name'=>'Gaz',
        'charge'=>'Charge',
        'recup'=>'Récupération',

    );

   /* $tableParam['delete']=1;
    $tableParam['edit']=0;*/


}
catch(Exception $e){
    //$json['reponse']=$e->getMessage();
//echo json_encode($json,JSON_UNESCAPED_UNICODE);
echo $e->getMessage();
exit();
}
//$json['reponse']='ok';
//echo json_encode($json);


 include(DIR_ROOT.'inc/table.php');
