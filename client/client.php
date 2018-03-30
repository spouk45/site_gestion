<?php include('../config.php');?>
<?php include(HEAD);?>
<?php
session_start();
    if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
    }
if(!isset($_POST['id'])){
    echo '<p>erreur de récupération des données.</p>';
    exit();
}
$update_client=1;
$edit_equipment=1;

 include(HEADER);?>
<h2>Client</h2>
<!--
<div id="seek_customer">
    Recherche: <input type="text" name="seek" id="seek" />
</div>
-->

<?php
try{

    if(!is_numeric($_POST['id'])){
        echo '<p>id doit etre numéric.</p>';
    }

    include(DIR_ROOT.'/class/Generic.php');
    include(CONNECT);
    $Gen=new Generic($db);
    $table='customer';
    $data['id']=$_POST['id'];
    $param='';
    $list='';
    $order='';
    $data=$Gen->getData($table,$data,$param,$list,$order);
    $data=$data[0];

    $civilityId['id']=$data['civilityId'];
    $data['civility']=$Gen->getData('civility',$civilityId,'','tag','');
    $data['civility']= $data['civility'][0]['tag'];
    if($data['status']==0){
        $data['statusName']='Prospect';
    }
    else {
        $data['statusName']='client';
    }
    $subId['id']=$data['sub_id'];
    $data['sub']=$Gen->getData('sub',$subId,'','name','');
    $data['sub']= $data['sub'][0]['name'];
    if($data['contact']==null){

    }
}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}



?><div id="viewClient" class="detail">
    <div>
        <div id="administratif" class="group">
            <h4><span>Client</span></h4>
            <p>
                <span id="serial">N°client: <?php echo $data['serial'];?></span>
                <span id="statusName"><?php echo $data['statusName'];?></span>
            <p>
                <span id="civility"><?php  echo $data['civility'];?></span>
                <span id="name"><?php echo $data['name'];?></span>
                <span id="firstName"><?php echo $data['firstName'];?></span>
            </p>
        </div>
        <div  id="status" class="group">
            <h4><span>Status</span></h4>
            <?php include (DIR_ROOT.'status/inc/show_status.php');?>
        </div>

        <div id="coord" class="group">
            <h4><span>Coordonnées client</span></h4>

            <div class="ib">
                <h5>Adresse:</h5>
                <p>
                    <span id="road"><?php echo $data['road'];?></span>
                </p>
                  <p>
                      <span id="postal"><?php echo $data['postal'];?></span>
                      <span id="city"><?php echo $data['city'];?></span>
                  </p>

            </div>
            <div class="ib">
                <h5>Contact:</h5>
                <p id="tel">Téléphone: <?php echo $data['tel'];?></p>
                <p id="port">Portable: <?php echo  $data['port'];?></p>
                <p id="mail">e-mail: <?php echo $data['mail'];?></p>

                <?php if($data['contact']!=null){ ?>
                     <p id="contact">contact: <?php echo  $data['contact'];?></p>
              <?php  } ?>

            </div>
        </div>

        <div id="com" class="group">
            <h4><span>Commentaire</span></h4>
            <p id="textarea"><?php echo nl2br(html_entity_decode($data['com']));?></p>
        </div>
        <div id="equipment" class="group">
            <h4><span>Equipement</span></h4>
            <div id="contentEquipment"></div>
        </div>
    </div>
</div>

 <script>
     $(document).ready(function(){
         var id=$('#customerId').val(); // récupérer via hidden status
         $.post('../equipment/load/equipmentClient.php',{'id':id,'edit':0}).done(function(data){
             //data=JSON.parse(data);
                 $('#contentEquipment').html(data);

             });

     });

 </script>