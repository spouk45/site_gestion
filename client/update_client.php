<?php include('../config.php');?>
<?php include(HEAD);?>
<?php
session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}
if(!isset($_POST['id'])){
    echo 'Erreur de récupération des données';
    exit();
}
?>

<?php include(HEADER);?>

<?php
try{
    $id=$_POST['id'];
    include(CONNECT);
    include(DIR_ROOT.'client/class/CustomerManager.php');
    $CustomerManager=new CustomerManager($db);
    include(DIR_ROOT.'client/class/SubManager.php');
    $SubManager=new SubManager($db);
    $civTab=$CustomerManager->getCivList();
    $subList=$SubManager->getSubList();
    //$data=$CustomerManager->getCustomerByID($id);
    include(DIR_ROOT.'class/Generic.php');
    $Generic=new Generic($db);
    $seek['id']=$id;
    $data=$Generic->getData('customer',$seek,'','','');
    $data=$data[0];
}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}
/*?><pre><?php print_r($data);?></pre><?php*/

?><h2>Edition client</h2>
<div id="container" class="detail">
    <form method="POST" action="<?php echo URL_ROOT.'client/proc/update_client.php';?>" id="formClient">
        <input type="hidden" name="id" id="id" value="<?php echo $id;?>">
        <div id="administratif" class="group">
            <h4><span>Client</span></h4>
                <p>
                    <input type="radio" name="status" value="0" <?php if($data['status']==0){echo 'checked';}?>>Client
                    <input type="radio" name="status" value="1"<?php if($data['status']==1){echo 'checked';}?>>Prospect
                </p>
                <p>
                    <?php
                    foreach($civTab as $value)
                        {
                            ?><input type="radio" name="civility" value="<?php echo $value['id'];?>" data-business="<?php echo $value['business'];?>"
                        <?php if($value['id']==$data['civilityId']){echo 'checked';}?> > <?php echo $value['tag'];?><?php
                        }
                      ?>
                </p>
               <p> Numéro client: <input type="text" name="serial" value="<?php echo $data['serial'];?>" id="serial"></p>
                <p>
                    <?php
                    if($subList!=null)
                    { ?>
                         Sous traitant:
                    <select id="sub_id" name="sub_id">
                        <?php
                        ?><option value="null"></option><?php
                        foreach ($subList as $value){
                         ?><option value="<?php echo $value['id'];?>" <?php if($value['id']==$data['sub_id']){echo 'selected';}?>><?php echo $value['name'];?></option><?php
                        } ?>
                    </select>
                </p>
                    <p id="gr_contact">Contact: <input type="text" name="contact" value="<?php echo $data['contact'];?>" id="contact"></p>

                <?php } ?>

                <p>
                <span>Nom: <input type="text" name="name" value="<?php echo $data['name'];?>" id="name"></span>
                <span>Prénom: <input type="text" name="firstName" value="<?php echo $data['firstName'];?>" id="firstName"></span>
                </p>
            </div>

        <div id="coord" class="group">
            <h4><span>Coordonnées client</span></h4>
            <div class="ib">
                <h5>Adresse:</h5>
                <p class="right">Rue: <input type="text" name="road" id="road" value="<?php echo $data['road'];?>"></p>
                <p class="right">Code postal: <input type="text" name="postal" id="postal" value="<?php echo $data['postal'];?>"></p>
                <p class="right">Ville: <input type="text" name="city" id="city" value="<?php echo $data['city'];?>"></p>
            </div>
            <div class="ib">
                <h5>Contact:</h5>
               <p class="right"> Téléphone: <input type="text" name="tel" id="tel" value="<?php echo $data['tel'];?>" pattern="^[0-9]{0,10}$"></p>
                <p class="right">Portable: <input type="text" name="port" id="port" value="<?php echo $data['port'];?>" pattern="^[0-9]{0,10}$"></p>
               <p class="right"> e-mail: <input type="text" name="mail" id="mail" value="<?php echo $data['mail'];?>" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"></p>
            </div>
        </div>

        <div id="com" class="group">
            <h4><span>Commentaire</span></h4>
            <p><textarea id="com" name="com"><?php echo $data['com'];?></textarea></p>
        </div>
        <input type="submit" value="Valider">
    </form>
    <div id="box_error"></div>
</div>
<script>
    $(document).ready(function(){
        function reloader(){ // redirection de page

            window.location.assign('../');
        }

        //$('#gr_contact').css('display','none');
        var business=$('input[type=radio][name=civility]:checked').attr('data-business');
        if(business==0){
            $('#gr_contact').css('display','none');
        }
        $('input:radio[name="civility"]').change(function(){
            //var civ=$('input[type=radio][name=civility]:checked').attr('value');
            var business=$('input[type=radio][name=civility]:checked').attr('data-business');
            if(business==1){
                $('#gr_contact').css('display','block');
            }
            else {
                $('#contact').val('');
                $('#gr_contact').css('display','none');

            }
        });

        //$('input:radio[name="civility"]:first-child').prop( "checked", true );

        $('#formClient').submit(function(e){
            e.preventDefault();
            var $this = $(this);
            var civ= $('input[type=radio][name=civility]:checked').attr('value');
            var status= $('input[type=radio][name=status]:checked').attr('value');
            var client=$('#serial').val();
            var name=$('#name').val();

            if(civ=='' || status=='' || client=='' || name==''){
                $('#box_error').html('<p>Certaines informations sont manquantes</p>');
            }
            else {
                $('#box_error').html('');
                $.ajax({
                    url: $this.attr('action'),
                    type: $this.attr('method'),
                    data: $this.serialize(),
                    dataType: 'json', // JSON
                    success: function(json) {
                        if(json.reponse === 'ok') {
                           // alert('Tout est bon');
                            $('#container').html('<p>Client modifier avec succès</p>');
                            setTimeout(reloader, 2500);
                        } else {
                           // alert('Erreur : '+ json.reponse);
                            $('#box_error').html('<p>'+ json.reponse+'</p>');
                        }
                    }
                });
            }

        });
    });



</script>

<?php include(FOOTER);?>