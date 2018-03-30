<?php include('../config.php');?>
<?php include(HEAD);?>

<?php session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}

include(HEADER);
try{

    $countAlert=0;
    $data=null; // prépa affichage tableau
        include(CONNECT);
        // ----- STATUS ------
        include(DIR_ROOT.'alert/class/AlertStatusManager.php');
        $AlertStatusManager=new AlertStatusManager($db);
        $listStatusAlert=$AlertStatusManager->getAlertList(); // recup de limite d'alerte status

  /* ?><pre><?php print_r($listStatusAlert);?></pre><?php*/
    // calcul du nombre d'alert
    $DateTimeToday=new DateTime('now');
    $dataAlertStatus=array();
    if($listStatusAlert!=null){
        foreach ($listStatusAlert as $value){
            $DateClient=new DateTime();
            $DateClient->setTimestamp($value['dateClient']);

            $Interval = $DateClient->diff($DateTimeToday,true);
            $interval=$Interval->format('%a');

            // echo 'interval:'.$interval;


            if($interval>$value['timeAlert']){
                // nouveau data pour prepa
                $dataAlertStatus[]['customerId']=$value['customerId'];
                $countAlert++;

            }
        }
    }




  /*  ?><pre><?php print_r($dataAlertStatus); ?></pre><?php*/
    if(!empty($dataAlertStatus)) {
        foreach ($dataAlertStatus as $value) {
            $dataClient[] = $AlertStatusManager->getListClientAlert($value['customerId']);
        }
    }
   /* ?><pre><?php print_r($dataClient);?></pre><?php*/


    // affichage de date lisible de dataclient
    if(!empty($dataClient)) {
        foreach ($dataClient as $key => $value) {
            $Date = new DateTime();
            $Date->setTimestamp($value['clientDateStatus']);
            $date = $Date->format('d/m/Y');
            $dataClient[$key]['date'] = $date;
            $DateTimeToday = new DateTime();
            $Interval = $Date->diff($DateTimeToday, true);
            /* ?><pre><?php print_r($Interval); ?></pre><?php*/
            $interval = $Interval->format('%a');
            $dataClient[$key]['interval'] = $interval;
        }
        // prepa affichage
        $data = $dataClient;

    }
    $tabTitle = array(

        'clientName' => 'Nom',
        'clientSerial' => 'n°client',
        'statusName' => 'status',
        'date' => 'date',
        'interval' => 'depuis (jours)'
        //'clientDateStatus'=>'dateF'
    );
}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}
?>
<h2>Alertes en cours</h2>
<div id="wrapper" class="hoverTab">
    <p>Nombre d'alerte: <?php echo $countAlert;?></p>
    <?php
    if($data!=null){
    include(DIR_ROOT.'inc/table.php');
    }
    ?>
</div>

<script>
    $(document).ready(function(){
        $('.row').addClass('hover');
       $('.row').click(function(){
           var id=$(this).attr('data-tr-id');
           $.redirect('../client/client.php',{'id':id});
       });
    });
</script>