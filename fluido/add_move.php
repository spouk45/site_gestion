<?php include('../config.php');?>
<?php include(HEAD);?>
<?php
session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}

include(HEADER);

?>

<!-- affichage des filtres -->
<?php
// list des move

try{
    include (CONNECT);
    include(DIR_ROOT.'class/Generic.php');
    include(DIR_ROOT.'tech/class/TechManager.php');

    $Gen=new Generic($db);
    $TechManager=new TechManager($db);

    $gazTypeList=array();
    $gazTypeList=$Gen->getData('flu_gaz','','','','');

    $techList=array();
    $techList=$TechManager->getTech('');


}
catch(Exception $e){
    $json['reponse']=$e->getMessage();
//echo json_encode($json,JSON_UNESCAPED_UNICODE);
//echo $e->getMessage();
//exit();
}
//$json['reponse']='ok';
//echo json_encode($json);


?>
<h2>Nouveau mouvement de fluide</h2>
<pre><?php //print_r($data);
    ?>
</pre>

<div id="wrapper">

    <div id="boxError"><?php if(isset($json)){echo $json['reponse'];}?></div>


        <form method="POST" action="proc/addMove.php" id="form" autocomplete="off">
            <p>N° de fiche: <input type="text" id="serialFiche" name="serialFiche"></p>
            <p>Date: <input type="text" class="datePicker" id="dateOfMove" name="dateOfMove" value="<?php echo date('d m Y');?>"></p>
            <p>Technicien: <select id="techId" name="techId" >
                    <?php foreach($techList as $value){
                        ?> <option value="<?php echo $value['id'];?>"><?php echo $value['name'].' '.$value['firstname'];?></option><?php
                    } ?>
                </select></p>

            <p> Client:</p>
            <input type="hidden" id="customerId" name="customerId" value="">
            <div>
              <div class="inline inputNav">
                  <label for="customer"></label><input type="text" id="customer" name="customer" >
                  <div id="clientNav" class="subNav"></div>
              </div>
            </div>


            <p>Equipement concerné:</p><!-- select -->
              <select id="equipmentId" name="equipmentId" >

                </select>



            <p>Gaz: <select id="gazId" name="gazId" >
                        <?php foreach($gazTypeList as $value){
                            ?> <option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option><?php
                        } ?>
                </select></p>




            <!-- Sortie de gaz du stock -->
            <div class="inline">
                <p>Charge en gaz dans l'équipement: <input type="text"  id="chargeOut" name="chargeOut" ></p>
                <p>N° de bouteille de charge: </p>
                <input type="hidden" id="bottleChargeId" name="bottleChargeId">
                <div>
                    <div class="inline inputNav">
                        <input type="text" id="bottleSerialC" name="bottleSerialC" >
                        <div id="chargeNav" class="subNav"></div>
                    </div>
                </div>
            </div>

            <div class="inline">
            <!-- Entrée de gaz dans le stock -->
                <p>Gaz Récupéré: </p>
                <input type="text" id="chargeIn" name="chargeIn" ></p>

                <p>N° de bouteille de récupération/transfert: </p>
                <input type="hidden" id="bottleRecupId" name="bottleRecupId">
                <div>
                    <div class="inline inputNav">
                        <input type="text" id="bottleSerialR" name="bottleSerialR" >
                        <div id="recupNav" class="subNav"></div>
                    </div>
                </div>
            </div>

            <p><input type="submit" value="OK"></p>
        </form>

</div>

<script>
    $(document).ready(function(){

        // ------------  prepa au chargement

        // hide des liste
        $('.subNav').hide();

        // blocage de la saisi des input avant remplissage
        $('#equipment').prop('disabled',true);

        // ** client **
        var customer=$('#customer');
        var clientList= $('#clientNav');
        customer.focus(function(){
            clientList.show();
        });
        customer.focusout(function(){
            setTimeout(function(){
                clientList.hide();
            }, 200);
        });

        // ** bottle charge/transfert
        var bottleCharge=$('#bottleSerialC');
        var chargeList=$('#chargeNav');
        bottleCharge.keyup(function(){
            getBottleCharge();
        });

        bottleCharge.focus(function(){
            chargeList.show();
        });

        bottleCharge.focusout(function(){
            setTimeout(function(){
                chargeList.hide();
            }, 200);
        });

        // ** bottle recup
        var bottleRecup=$('#bottleSerialR');
        var recupList=$('#recupNav');
        bottleRecup.keyup(function(){
            getBottleRecup();
        });

        bottleRecup.focus(function(){
            recupList.show();
        });

        bottleRecup.focusout(function(){
            setTimeout(function(){
                recupList.hide();
            }, 200);
        });

        //  ---- CUSTOMER ------
        customer.keyup(function(){
           var $this=$(this);
           var name=$this.val();

           // vidage des hidden
           $('#customerId').val('');
           $('#equipmentId').val('');

           $.post('../client/proc/getClient.php',{'name':name},function(json){
               if(json.reponse!='ok'){
                  $('#boxError').html(json.reponse);
               }
               else{
                   var box=$('#clientNav');
                   if(json.data!=null){ // si résultat

                       var html='';
                       $.each(json.data,function(index,value){
                           html=html+'<p data-id="'+value.id+'" data-name="'+value.name+'">'+'('+value.serial+') - '+value.name+'</p>';
                           box.html(html);
                       });

                       $('#clientNav p').click(function(){ // sur selection
                           var id=$(this).attr('data-id');
                           var name=$(this).attr('data-name');
                           $('#customerId').val(id);
                           $('#customer').val(name);

                           box.hide();

                           $('#equipment').prop('disabled',false);
                          getEquipment();

                       });
                   }
                   else{
                       // si pas de résultat
                       $('#clientId').val('');
                       $('#equipment').html('');
                       $('#equipment').prop('disabled',true);
                       box.html('');
                   }

               }

              //alert(json);
           },'json');
       });

        // ----------- ENVOIE DU FORMULAIRE -------------
        $('#form').submit( function(e){

            e.preventDefault();
            $('#boxError').html('');
            var $this=$(this);
            var data=$this.serialize();

            $.ajax({
                method: "POST",
                url: "proc/addMove.php",
                dataType: 'json',
                data: data
        }).done(function( json ) {
                if(json.reponse=='ok'){
                    $('#wrapper').html('<p>Mouvement de fluide ajouté avec succès</p><p><a href="move.php">Retour</a></p>');
                }
                else{
                    $('#boxError').html('<p>'+json.reponse+'<p>');
                }
            });


    });




    });


    function getEquipment() {
        var clientId = $('#customerId').val();

        $.post('../equipment/proc/getEquipment.php', {'clientId': clientId}, function (json) {
            if (json.reponse != 'ok') {
                $('#boxError').html(json.reponse);
            }
            else {
                if (json.data != null) { // si résultat

                    var html = '';
                    $.each(json.data, function (index, value) {
                        html = html + '<option value="' + value.id + '">' + value.productName + ' - ' + value.serial + '</option>';
                        $('#equipmentId').html(html);
                    });
                }
                else {
                    // si pas de résultat
                    $('#equipmentId').html('');
                }

            }

            //alert(json);
        }, 'json');
    }

    function getBottleCharge(){
        var boxCharge=$('#bottleSerialC');
        var listCharge=$('#chargeNav');
        var chargeId=$('#bottleChargeId');
        var serial=boxCharge.val();

        $.post('proc/getBottle.php',{'type':1,'serial':serial},function(json){
            if (json.reponse != 'ok') {
                $('#boxError').html(json.reponse);
            }
            else{
                if (json.data != null) { // si résultat
                    listCharge.show();// affichage de la liste

                    var html = '';
                    $.each(json.data, function (index, value) {
                        html = html + '<p data-id="' + value.id + '" data-serial="'+value.serial+'">' + value.type + ' - ' + value.serial + '</p>';
                        listCharge.html(html);
                    });

                    listCharge.children('p').click(function(){
                        var id=$(this).attr('data-id');
                        var serial=$(this).attr('data-serial');
                        chargeId.val(id);
                        boxCharge.val(serial);

                    });
                }
                else {
                    // si pas de résultat
                    listCharge.html('');
                }
            }
        },'json');
    }

    function getBottleRecup(){
        var boxCharge=$('#bottleSerialR');
        var listCharge=$('#recupNav');
        var chargeId=$('#bottleRecupId');
        var serial=boxCharge.val();

        $.post('proc/getBottle.php',{'type':2,'serial':serial},function(json){
            if (json.reponse != 'ok') {
                $('#boxError').html(json.reponse);
            }
            else{
                if (json.data != null) { // si résultat
                    listCharge.show();// affichage de la liste

                    var html = '';
                    $.each(json.data, function (index, value) {
                        html = html + '<p data-id="' + value.id + '" data-serial="'+value.serial+'">' + value.type + ' - ' + value.serial + '</p>';
                        listCharge.html(html);
                    });

                    listCharge.children('p').click(function(){
                        var id=$(this).attr('data-id');
                        var serial=$(this).attr('data-serial');
                        chargeId.val(id);
                        boxCharge.val(serial);

                    });
                }
                else {
                    // si pas de résultat
                    listCharge.html('');
                }
            }
        },'json');
    }


</script>