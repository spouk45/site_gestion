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
    $clientId=$_POST['id'];
    include(DIR_ROOT.'class/Generic.php');
    include(CONNECT);
    $Gen=new Generic($db);
    $categoryList=$Gen->getData('prod_category','','','id,name','');
    $markList=$Gen->getData('mark','','','id,name','');

}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}

?>
<h2>Edition équipement client</h2>
<div id="wrapper">
    <div id="filter" class="filter">
        <h3>Recherche</h3>
        <div> <form method="POST" action="proc/seek_product.php" id="formFilter">
                <div>
                    <p>Marque: <label for="markId"></label>
                        <select name="markId" id="markId">
                            <option value=""></option>
                            <?php foreach($markList as $value){ ?>
                                <option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                            <?php } ?>
                        </select>
                    </p>
                    <p>Categorie: <label for="categoryId"></label> <select name="categoryId" id="categoryId">
                            <option value=""></option>
                            <?php foreach($categoryList as $value){ ?>
                                <option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                            <?php } ?>
                        </select>
                    </p>
                </div>
                <div> <p>Nom: <label for="name"></label><input type="text" name="name" id="name" value=""></p></div>
                <input type="hidden" name="add" value="1">
            </form>
        </div>
    </div>

    <!-- affichage tableau -->
    <h3>Liste de produits</h3>
    <div id="product_list" class="cadre hoverTab"></div>
    <div id="boxError"></div>
    <h3>Equipement client</h3>
    <div id="equipmentClient" class="cadre hoverTab"></div>
</div>



<script>
    $('#name').keyup(function(){
        $('#formFilter').trigger('submit');
    });

    $('#markId').change(function(){
        $('#formFilter').trigger('submit');
    });

    $('#categoryId').change(function(){
        $('#formFilter').trigger('submit');
    });

    $('#formFilter').submit(function(e){
        e.preventDefault();
        var $this=$(this);
        $.ajax({
            url: $this.attr('action'),
            type: $this.attr('method'),
            data: $this.serialize(),
            success: function(html) {
                $('#product_list').html(html);

                $('.td-add>img').click(function(){
                    var id=$(this).attr('data-id');
                    var clientId='<?php echo $clientId;?>';
                    $.post('../equipment/proc/addEquipmentClient.php',{'productId':id,'clientId':clientId}).done(function(data){
                     //$('#tr'+id).hide();
                       // $('#boxError').html(data);
                     });
                   equipmentClient(clientId);
                });
            }
        });
    });

  function equipmentClient(clientId){
      $.post('../equipment/load/equipmentClient.php',{'id':clientId}).done(function(data) {
          $('#equipmentClient').html(data);

          $('.td-edit>img').click(function(){
              var id=$(this).attr('data-id');

              var tdNumber=4;
              var serial=$('#tr'+id+' td:nth-child('+tdNumber+')').text();
              serial=serial.trim();
              $('#tr'+id+'>td:nth-child('+tdNumber+')').html('<input type="text" class="inputSerial" name="serial" value="'+serial+'" >');

              $('.inputSerial').change(function(){
                  // var newName=$(this).text();
                  var newSerial=$(this).val();
                  // lancer un ajax pour la modification ds la bdd
                  $.post('../equipment/proc/editEquipmentClient.php',{'productId':id,'serial':newSerial}).done(function(data){
                      //alert(data);
                      $('#tr'+id+'>td:nth-child('+tdNumber+')').html(newSerial);
                     // $('#boxError').html(data);
                  });

              });

          });

      });
  }

    equipmentClient('<?php echo $clientId;?>');




</script>

