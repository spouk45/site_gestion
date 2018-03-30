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

}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}
?>

<h2>Bilan</h2>
<!-- navigation fluido -->
<div id="wrapper" class="detail">
   <div id="filter">
           <p>Sélection de l'année:</p>
           <p><input type="number" id="year" name="year" value="<?php echo date('Y');?>">  </p>

   </div>
    <div id="boxError"></div>
    <div class="group">
        <h4><span id="stockTitle">Stock en <?php echo date('Y');?></span></h4>
        <div id="stock"></div>
    </div>
    <div class="group">
        <h4><span id="stockBeforeTitle">Stock au 31-12-<?php echo date('Y')-1;?></span></h4>
         <div id="stockBefore"></div>
    </div>
    <div class="group">
        <h4><span id="bilanTitle">Stock théorique en <?php echo date('Y');?></span></h4>
        <div id="stockT"></div>
    </div>

</div>

<script>
    $(function(){
        $('#year').change(function(){
           getStock();
           getStockBefore();
            changeDate();
            getBilan();
        });
        getStock(); // au chargement de la page
        getStockBefore(); // au chargement de la page
        getBilan();

    });

    function getStock(){
        var year=$('#year').val();// récupération de l'année selectionnée:

        $.post('proc/getStock.php',{'year':year}).done(function(data){
            $('#stock').html(data);
            update();
        });
    }


    function getStockBefore(){
        var year=$('#year').val()-1;// récupération de l'année selectionnée:
        //var year=$('#year').val();
        $.post('proc/getStock.php',{'year':year,'notEdit':1}).done(function(data){
            $('#stockBefore').html(data);
            var jsonStock=$('#jsonStock').val();
           // alert(jsonStock);

            // on veux mettre les form pour modifier
        });
    }

    function changeDate(){
        var year=$('#year').val();
        var titleBefore=$('#stockBeforeTitle');
        var title=$('#stockTitle');
        var before=year-1;
        titleBefore.text('Stock au 31-12-'+before);
        title.text('Stock en '+year);
    }

    function getBilan(){
        var year=$('#year').val();
        //var DateStart=new Date(year,0,1);
       // var DateEnd=new Date(year,11,31);
        var dateStart='01-01-'+year;
        var dateEnd='31-12-'+year;

        $.post('proc/getBilan.php',{'dateStart':dateStart,'dateEnd':dateEnd}).done(function(data){
            $('#stockT').html(data);
        });
    }

    function update(){
        $('.td-edit').click(function(){
            var $this=$(this);
            var tr=$this.parent('tr');
            var id=$this.parent('tr').attr('data-tr-id');

            var gazNeuf=tr.children('td:nth-child(2)'); //col2
            var gazRecup=tr.children('td:nth-child(3)'); //col3

            gazNeuf.html('<input type="text" class="inputStatus" data-type="charge" value="'+gazNeuf.text().trim()+'">');
            gazRecup.html('<input type="text" class="inputStatus" data-type="recup" value="'+gazRecup.text().trim()+'">');

            $('.inputStatus').change(function(){
                var val=$(this).val();
                var year=$('#year').val();
                var type=$(this).attr('data-type');

                $.post('proc/updateBilan.php',{'id':id,'val':val,'type':type,'year':year},function(json){
                    if(json.repnse!='ok'){
                        $('#BoxError').html('<p>Erreur de mise à jour</p>');
                    }
                },'json');
            });


        });
    }



</script>