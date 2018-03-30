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
    if(!isset($_POST)){
        throw new Exception('Aucune données récupérer');
    }
    if(empty($_POST['serialFiche']) || empty($_POST['dateOfMove']) || empty($_POST['techId']) || empty($_POST['customerId']) ||
        empty($_POST['equipmentId'])|| empty($_POST['gazId'])){
        throw new Exception('il manque des données');
    }

    include('../class/Move.php');
    include(CONNECT);
    include('../class/MoveManager.php');
    $MoveManager=new MoveManager($db);

    include(DIR_ROOT.'class/DateBuilder.php');
    $DateBuilder=new DateBuilder($_POST['dateOfMove']);
    $dateOfMoveTime=$DateBuilder->getTime();

    // controle incohérence bouteille
    include('../class/BottleManager.php');
    $BottleManager=new BottleManager($db);
    if(!empty($_POST['bottleChargeId'])){
        $bottle['id']=$_POST['bottleChargeId'];
        $bottleCharge=$BottleManager->getBottle($bottle);

        if($dateOfMoveTime<$bottleCharge[0]['dateOfBuy']){
            throw new Exception('La date de mouvement ne peux être inférieur à la date d\'achat de la bouteille. (charge)');
        }

    }
    if(!empty($_POST['bottleRecupId'])) {
        $bottle['id']=$_POST['bottleRecupId'];
        $bottleRecup=$BottleManager->getBottle($bottle);

        if($dateOfMoveTime<$bottleRecup[0]['dateOfBuy']){
            throw new Exception('La date de mouvement ne peux être inférieur à la date d\'achat de la bouteille. (récup)');
        }
    }

    // -----------------

    $data=array(
        'serialFiche' => $_POST['serialFiche'],
        'dateOfMove'=>$_POST['dateOfMove'],
        'techId'=>$_POST['techId'],
        'customerId'=>$_POST['customerId'],
        'equipmentId'=>$_POST['equipmentId'],
        'gazId'=>$_POST['gazId']
        );

    // ----- Si meme bouteille faire qu'en un
    if($_POST['bottleRecupId'] == $_POST['bottleChargeId'] ){
        if(empty($_POST['chargeIn']) || empty($_POST['chargeOut'])){
            throw new Exception('charge et recup non rempli');
        }
        $dataRC=array(
            'chargeIn' => $_POST['chargeIn'],
            'chargeOut' => $_POST['chargeOut'],
            'bottleId' => $_POST['bottleRecupId']
        );
        $dataRC+=$data;
      /*  ?><pre><?php print_r($dataRC);?></pre><?php*/
        $Move=new Move($dataRC);
        $MoveManager->addMove($Move);
    }
    else{
        // --- si récup ----
        if( !empty($_POST['chargeIn'])){
            if(empty($_POST['bottleRecupId'])){
                throw new Exception('bottle recup non choisi');
            }
            $dataR=array(
                'chargeIn' => $_POST['chargeIn'],
                'bottleId' => $_POST['bottleRecupId']
            );
            $dataR+=$data;
          /*  ?><pre><?php print_r($dataR);?></pre><?php*/
            $Move=new Move($dataR);
            $MoveManager->addMove($Move);
        }

        // ---- si charge ----
        if(!empty($_POST['chargeOut'])){
            if(empty($_POST['bottleChargeId'])){
                throw new Exception('bottle charge non choisi');
            }
            $dataC=array(
                'chargeOut' => $_POST['chargeOut'],
                'bottleId' => $_POST['bottleChargeId']
            );
            $dataC+=$data;
           /* ?><pre><?php print_r($dataC);?></pre><?php*/
            $Move=new Move($dataC);
            $MoveManager->addMove($Move);
        }

    }

    // si aucune: pas de mouv
    if(empty($_POST['chargeOut']) && empty($_POST['chargeIn']) ){
        throw new Exception('les quantité ne sont pas renseignées.');
    }

}
catch(Exception $e){
    $json['reponse']=$e->getMessage();
    echo json_encode($json,JSON_UNESCAPED_UNICODE);
    //echo $e->getMessage();
    exit();
}
$json['reponse']='ok';
echo json_encode($json,JSON_UNESCAPED_UNICODE);
