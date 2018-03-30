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
$update_sub=1;

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
    $table='sub';
    $data['id']=$_POST['id'];
    $param='';
    $list='';
    $order='';
    $data=$Gen->getData($table,$data,$param,$list,$order);
    $data=$data[0];


}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}



?><div id="viewClient" class="detail">
    <div>
        <div id="administratif" class="group">
            <h4><span>Sous-traitant</span></h4>
            <p> Nom:<span id="name"><?php echo $data['name'];?></span></p>
               <p> Contact: <span id="contact"><?php echo $data['contact'];?></span> </p>
        </div>
        <div id="coord" class="group">
            <h4><span>Coordonnées</span></h4>

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
                <p id="mail">e-mail: <?php echo $data['mail'];?></p>
            </div>
        </div>

        <div id="com" class="group">
            <h4><span>Commentaire</span></h4>
            <p id="textarea"><?php echo nl2br(html_entity_decode($data['com']));?></p>
        </div>
    </div>
</div>

<pre>