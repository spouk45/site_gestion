
<?php include('../config.php');?>
<?php include(HEAD);?>
<?php
session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}

include(HEADER);

try{
    include(CONNECT);
    include(DIR_ROOT.'class/Generic.php');

    // recup des type de gaz
    $Gen=new Generic($db);
    $listType='id,name';
    $gazList=$Gen->getData('flu_gaz','','',$listType,'');
   // print_r($gazList);

    //recup des type de bouteille
    $listType='id,name';
    $typeBottleList=$Gen->getData('flu_type','','',$listType,'');

    // recup liste fournisseur
    $listType='id,name';
    $fournisseurList=$Gen->getData('fournisseur','','',$listType,'');
}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}
?><h2>Nouvelle bouteille</h2>
<div id="wrapper" class="detail">
    <form method="POST" action="<?php echo URL_ROOT.'fluido/proc/addBottle.php';?>" id="formAddBottle">
        <p>Type de bouteille:
            <label for="typeId"></label><select id="typeId" name="typeId">
                <?php foreach ($typeBottleList as $value){
                    ?><option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                <?php } ?>
            </select>
        </p>
        <p>N° de série: <input type="text" id="serial" name="serial"></p>
        <p>Date d'achat: <input type="text" class="datePicker" id="dateOfBuy" name="dateOfBuy" maxlength="10" pattern="(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d"></p>
        <div id="ifCharge">
            <p>Type de gaz:
                <label for="gazId"></label><select id="gazId" name="gazId">
                    <option value=""></option>
                    <?php foreach ($gazList as $value){
                        ?><option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                    <?php } ?>
                </select>
            </p>
            <p>charge en Kg: <input type="text" id="charge" name="charge"></p>
        </div>
        <p>Fournisseur:
            <label for="fournisseurId"></label><select id="fournisseurId" name="fournisseurId">
                <?php foreach ($fournisseurList as $value){
                    ?><option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                <?php } ?>
            </select>
        </p>
        <p><input type="submit" name="submit" id="submit" value="Valider"></p>
    </form>
    <div id="boxError"></div>
</div>

<script>
    function checkType(){
        var typeName= $('#typeId option:selected').text();
        if(typeName=='charge'){
            $('#ifCharge').css('display','block');
        }
        else {
            $('#ifCharge').css('display','none');
        }
        //alert(typeName);
    }

    /*function writeDate(){
        var dateBox=$('#dateOfBuy');
        var date=dateBox.val().trim();

        if(date.length==2){
            dateBox.val(date+'/');
        }

        if(date.length==5){
            dateBox.val(date+'/');
        }

        if(date.length==10) {
          alert(  checkDate());
        }*/

       /* function checkDate(){
            if(date.length==10){
                var d=date.substring(0,2);
                var m=date.substring(3,5);
                var Y=date.substring(6,10);
                // alert(d+'/'+m+'/'+Y);
                //var Date = new Date(Y,m,d);
               // alert( checkDate(Y,m,d));
                // alert(Date.getDate());
                var D = new Date(Y, m, d);
                return D.getFullYear() == Y &&
                    D.getMonth() == m &&
                    D.getDate() == d;
            }
            else{
                return false;
            }
        }
    }*/
    $(document).ready(function() {

        checkType();// init au chargement
        $('#typeId').change(function(){
           checkType();
        });

        /*$('#dateOfBuy').keyup(function(){
            writeDate();
        });
        */
        $('#formAddBottle').submit(function(e){
            e.preventDefault();
            var $this=$(this);
            var url=$this.attr('action');
            var data=$this.serialize();

            /*$.ajax({
                url: $this.attr('action'),
                type: $this.attr('method'),
                data: $this.serialize(),
                //dataType: 'json', // JSON
                success: function(json) {
                    if(json.reponse === 'ok') {
                        $('#wrapper').html('<p>Bouteille ajoutée avec succès.</p>');
                        setTimeout(reloader, 2500);
                    } else {

                        $('#box_error').html('<p>'+ json.reponse+'</p>');
                    }
                    alert(json);
                }
            });*/
            $.post(url,data,function(json){
              // alert(json.reponse);
                if(json.reponse!='ok'){
                    $('#boxError').html(json.reponse);
                }
               else{
                    //alert('succès: a pofiner');
                    $('#wrapper').html('<p>Bouteille ajouté avec succès.</p><p><a href="">Ajouter une nouvelle bouteille</a></p>');
                }
            },'json');
        });



    });

</script>
