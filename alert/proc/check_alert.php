<?php
include('../../config.php');
header(CHARSET);

session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}

try{
    $force=0;
    if(isset($_POST['force'])){
        $force=$_POST['force'];
    }


    $countAlert=0;
    // verif si maj faite aujourd'hui
    include(CONNECT);
    include(DIR_ROOT.'alert/class/AlertCheckTodayManager.php');
    $AlertCheckTodayManager=new AlertCheckTodayManager($db);
    $lastDateCheck=$AlertCheckTodayManager->getDateLastCheck();
    $lastDate=$lastDateCheck['dateLastCheck'];
    $data['lastDate']=$lastDate;// test
    include(DIR_ROOT.'alert/class/AlertCheckToday.php');
    if(empty($lastDateCheck)){ // si pas de donnée, on créer la ligne ds la bdd
        // ajout de la date ds la bdd -> le remmettre arpes les verif
       // $AlertCheckTodayManager->addDateLastCheck();

        $dataAlert['countAlert']=$countAlert;
        $AlertCheckToday=new AlertCheckToday($dataAlert);
        $AlertCheckTodayManager->addDateLastCheck($AlertCheckToday);
    }
    $today=time();
    $Date1=new DateTime();
    $Date1->setTimestamp($lastDate);
    $Date2=new DateTime();
    $Date2->setTimestamp($today);

    $interval = $Date1->diff($Date2,true);
    $interval=$interval->format('%a');
    $data['interval']=$interval;
//echo $force;
    if($interval>0 || $force!=0){ // maj a faire des script ds la bdd
        $data['maj']='maj';
       // ----- STATUS ------
        include(DIR_ROOT.'alert/class/AlertStatusManager.php');
        $AlertStatusManager=new AlertStatusManager($db);
        $listStatusAlert=$AlertStatusManager->getAlertList(); // recup de limite d'alerte status
        if($listStatusAlert!=null){
            foreach ($listStatusAlert as $value){
                $DateClient=new DateTime();
                $DateClient->setTimestamp($value['dateClient']);
                $DateTimeToday=new DateTime('now');
                $Interval = $DateClient->diff($DateTimeToday,true);
                $interval=$Interval->format('%a');

                if($interval>$value['timeAlert']){
                    $countAlert++;
                }
            }

        }

    }
    else {
        // on va chercher dans la base le countAlert
        $countAlert=$AlertCheckTodayManager->getCountAlert();
        $data['getCount']='bdd';

    }
    // fin de l'exec: on met a jour le check
   // include(DIR_ROOT.'alert/class/AlertCheckToday.php');
    // on récupère le id
    $lastDateCheck=$AlertCheckTodayManager->getDateLastCheck();

    //$dataCountAlert['countAlert']=$countAlert;
    //$AlertCheckToday=new AlertCheckToday($dataCountAlert);

    $data['id']=$lastDateCheck['id'];
    $data['dateLastCheck']=time();
    $data['countAlert']=$countAlert;
    $Alert=new AlertCheckToday($data);
    $AlertCheckTodayManager->updateDateLastCheck($Alert);
}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}

echo json_encode($data);
