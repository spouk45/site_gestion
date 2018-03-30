<?php
include('../config.php');

 include(HEAD);?>
<?php
session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}

?>
<?php include(HEADER);?>

<?php
try{
    include(CONNECT);
    include(DIR_ROOT.'client/class/CustomerManager.php');
    $CustomerManager=new CustomerManager($db);
    $civTab=$CustomerManager->getCivList();
    include(DIR_ROOT.'client/class/SubManager.php');
    $SubManager=new SubManager($db);
    $subList=$SubManager->getSubList();
    $last_cl_number=$CustomerManager->getNextClNumber();//CL002545
    $pref=substr($last_cl_number,0,2);
    $cl=substr($last_cl_number,2)+1;
    $next_cl_number=$pref.$cl;

    //echo $next_cl_number;
}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}

?><h2>Nouveau client</h2>
<div id="formClient" class="detail">
    <form method="POST" action="<?php echo URL_ROOT.'client/proc/new_client.php';?>" id="new">
        <div id="administratif" class="group">
            <h4><span>Client</span></h4>
            <p>
                <span><input type="radio" name="status" value="0" checked>Client</span>
                <span><input type="radio" name="status" value="1">Prospect</span>
            </p>
            <p>
                <?php
                foreach($civTab as $value)
                    {
                        ?><input type="radio" name="civility" value="<?php echo $value['id'];?>" data-business="<?php echo $value['business'];?>"> <?php echo $value['tag'];?><?php
                    }
                  ?>
            </p>
           <p> Numéro client: <input type="text" name="serial" value="<?php echo $next_cl_number;?>" id="serial"></p>
            <p>
                <?php
                if($subList!=null)
                { ?>
                     Sous traitant:
                <select id="sub_id" name="sub_id">
                    <?php
                    ?><option value="null"></option><?php
                    foreach ($subList as $value){
                     ?><option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option><?php
                    } ?>
                </select>
            </p>

            <?php } ?>

            <p>
                <span> Nom: <input type="text" name="name" value="" id="name"></span>
                <span> Prénom: <input type="text" name="firstName" value="" id="firstName"></span>
            </p>
            <p id="gr_contact">Contact: <input type="text" name="contact" value="" id="contact"></p>
        </div>
        <div id="coord" class="group">
            <h4><span>Coordonnées client</span></h4>
            <div class="ib">
                <h5>Adresse:</h5>
                 <p class="right"> Code postal: <input type="text" name="postal" id="postal" value="" pattern="^[0-9]{5,5}$"></p>
                 <p class="right"> Ville: <input type="text" name="city" id="city" value=""></p>
                 <p class="right">Numéro et rue: <input type="text" name="road" id="road" value=""></p>
            </div>
            <div class="ib">
                <h5>Contact:</h5>
                <p class="right"> Téléphone: <input type="text" name="tel" id="tel" value="" pattern="^[0-9]{0,10}$"></p>
                <p class="right">Portable: <input type="text" name="port" id="port" value="" pattern="^[0-9]{0,10}$"></p>
                <p class="right"> e-mail: <input type="text" name="mail" id="mail" value="" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"></p>
            </div>
        </div>
        <div id="com" class="group">
                <h4><span>Commentaire</span></h4>
            <p>
             <textarea id="com" name="com"></textarea>
            </p>
        </div>
        <input type="submit" value="Valider">
    </form>
    <div id="box_error"></div>
</div>
<script>
    $(document).ready(function(){
        $('#gr_contact').css('display','none');

        $('input:radio[name="civility"]').change(function(){
            var civ=$('input[type=radio][name=civility]:checked').attr('value');
            var business=$('input[type=radio][name=civility]:checked').attr('data-business');
            if(business==1){
                $('#gr_contact').css('display','block');
            }
            else {
                $('#gr_contact').css('display','none');
            }
        });

        $('input:radio[name="civility"]:first-child').prop( "checked", true );


        function reloader(){
            window.location.reload();
        }
        $('#new').submit(function(e){
            e.preventDefault();
            var $this = $(this);
            var civ= $('input[type=radio][name=civility]:checked').attr('value');
            var status= $('input[type=radio][name=status]:checked').attr('value');
            var client=$('#cl_number').val();
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
                           $('#formClient').html('<p>Client ajouté avec succès.</p>');
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