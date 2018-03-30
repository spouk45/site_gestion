<?php include('../../config.php');?>
<?php include(HEAD);?>
<?php
session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}
if(!isset($_GET['id'])){
    echo 'Erreur de récupération des données';
    exit();
}
?>
<?php include(HEADER);?>

<?php
try{
    $id=$_GET['id'];
    include(CONNECT);
    include(DIR_ROOT.'module/product/class/EquipmentManager.php');
    $EquipmentManager=new EquipmentManager($db);
    $data=$EquipmentManager->getEquipmentByID($id);
}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}

?><h2>Equipement client</h2>
<div id="add_equipment">
    <label>Recherche de produit:<input type="text" name="seek" id="seek" value=""></label>
    <div id="product_list"></div>
    <form method="POST" action="<?php echo URL_ROOT.'module/client/proc/add_equipment.php';?>" id="new">
        <input type="hidden" name="id" id="id" value="<?php echo $id;?>">
        <input type="hidden" name="productId" id="productId" value="">
        <div>
            Equipement: <div id="equipment"></div>
            <input type="text" name="serial" id="serial" value="">
        </div>
        <input type="submit" value="Valider">
    </form>
</div>

  <div id="equipmentList">
      <?php if($data==null){
          echo '<p>Aucun equipement enregistré pour ce client.</p>';
      }?>
      <pre><?php print_r($data);?></pre>

  </div>


    <div>

        <div id="box_error"></div>
    </div>
    <script>
        $(document).ready(function(){

            $('#seek').keyup(function(){
                var seek=$('#seek').val();
                $.post('<?php echo URL_ROOT."module/client/proc/seek_equipment.php";?>',{ seek: seek },function(data){
                    $('#product_list').html(data);
                });

            });

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
                    $('#gr_contact').css('display','none');
                }
            });

            //$('input:radio[name="civility"]:first-child').prop( "checked", true );

            $('#new').submit(function(e){
                e.preventDefault();
                var $this = $(this);
                var civ= $('input[type=radio][name=civility]:checked').attr('value');
                var status= $('input[type=radio][name=status]:checked').attr('value');
                var client=$('#cl_number').val();
                var name=$('#name').val();
                var adress=$('#adress').val();
                if(civ=='' || status=='' || client=='' || name=='' || adress==''){
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
                            } else {
                                // alert('Erreur : '+ json.reponse);
                                $('#box_error').html('<p>'+ json.reponse+'</p>');
                            }
                        }
                    });
                }

            });
        });

function selectProduct(id,name){
    var equip_list=$('#equipment').html();
    $('#equipment').html(equip_list+'<p><span>'+name+'</span>Numéro de série:<input type="text" name="serial" id="serial" data-id="'+id+'" value=""></p>');
}

    </script>

<?php include(FOOTER);?>