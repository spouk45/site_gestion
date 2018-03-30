<?php include('../config.php');?>
<?php include(HEAD);?>
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
    include(DIR_ROOT.'equipment/class/ProductManager.php');
    $ProductManager=new ProductManager($db);
    $productList=$ProductManager->getCategoryList();

    include(DIR_ROOT.'class/Generic.php');
    $Mark=new Generic($db);
    $MarkList=$Mark->getData('mark','','','','');
    }
catch(Exception $e){
    echo $e->getMessage();
    exit();
    }


?><h2>Nouveau Produit</h2>
    <div class="wrapper">
        <form method="POST" action="<?php echo URL_ROOT.'equipment/proc/new_product.php';?>" id="new">
            <p>Nom: <input type="text" name="name" value="" id="name"></p>
            <p>Marque: <select name="mark" id="mark">
                    <option value=""></option>
                    <?php if($MarkList!=null){
                        foreach($MarkList as $value){
                            ?><option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option><?php
                        }
                    }?>
                </select>
                <span class="addButton" id="newMark"><img id="addMark" src="<?php echo URL_ROOT.'img/add.png';?>"></span>

            </p>
            <p id="boxErrorMark"></p>
            <p> Catégorie: <select name="category_id" id="category_id" >
                <option value=""></option>
                    <?php if($productList!=null){
                   foreach($productList as $value){
                       ?><option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option><?php
                   }
                }?>
                    </select>
            </p>
            <p>Description:</p>
            <p><textarea id="description" name="description"></textarea></p>

            <input type="submit" value="Valider">
        </form>
        <div id="box_error"></div>
    </div>
    <script>
        $(document).ready(function(){
            $('#addMark').click(function(){
                $('#newMark').html('<input type="text" name="markName" id="markName" value="" placeholder="Entrez la marque à ajouter"><input type="button" value="+" id="markSubmit">');
                $('#markSubmit').click(function(){
                    var mark=$('#markName').val();

                    $.post('proc/addMark.php',{'name':mark}).done(function(data){
                        data=JSON.parse(data);
                        if(data.reponse=='ok'){

                        }else{
                            $('#boxErrorMark').html(data);
                            alert(data.reponse);
                        }

                    });
                });
            });


            $('#new').submit(function(e){
                e.preventDefault();
                var $this = $(this);
                var name=$('#name').val();
                if( name==''){
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
                                 //alert('Tout est bon');
                                $('.wrapper').html('<p>Produit ajouté avec succès.</p><p><a href="" onclick="loaction.reload()">Ajouter un nouveau produit</a></p>')
                            } else {
                                 //alert('Erreur : '+ json.reponse);
                                $('#box_error').html('<p>'+ json.reponse+'</p>');
                            }
                        }
                    });
                }

            });
        });



    </script>

<?php include(FOOTER);?>