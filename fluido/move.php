<?php include('../config.php');?>
<?php include(HEAD);?>
<?php
session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}

include(HEADER);

$dateStart=date('01/01/Y');
$dateEnd=date('d/m/Y');
?>

    <!-- affichage des filtres -->
<?php
// list des move

?>
<h2>Mouvement de fluide</h2>
<div id="wrapper">

  <p><a href="add_move.php">Nouveau mouvement de fluide</a></p>
    <div id="filter">
        <form method="POST" action="proc/listMove.php" id="filter">
            <p> Date de début: <input type="text" id="dateStart" class="datePicker" name="dateStart" value="<?php echo $dateStart;?>">
                Date de fin: <input type="text" id="dateEnd" class="datePicker" name="dateEnd" value="<?php echo $dateEnd;?>"></p>
                <input type="submit" value="ok">


        </form>
</div>
    <div id="boxError"><?php if(isset($json)){echo $json['reponse'];}?></div>
    <div id="divTable">

    </div>
</div>


<script>




    $(document).ready(function(){
        getData();

        $('#filter').submit(function(e){
            e.preventDefault();
            getData();
        });
    });

function getData(){
    var dateStart=$('#dateStart').val();
    var dateEnd=$('#dateEnd').val();

    $.post('proc/listMove.php',{'dateStart':dateStart,'dateEnd':dateEnd}).done(function(data){
        $('#divTable').html(data);

        var table=$('#wrapper table');
        var colToFilter=[1,2,3,7,8,9,10,11,12];
        var colMax=12;
        toggleFilter(table,colToFilter,colMax);
    });
}
</script>
