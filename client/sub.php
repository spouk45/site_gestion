<?php include('../config.php');?>
<?php include(HEAD);?>
<?php
session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}
$new_sub=1;
?>
<?php include(HEADER);?>
<h2>Sous-traitant</h2>
<div id="filter" class="filter">
    <h3>Recherche</h3>
    <div>
        <form method="POST" action="proc/seek_sub.php" id="formFilter">
            <p>Nom: <label for="name"></label><input type="text" name="name" id="name" value=""></p>
        </form>
    </div>
</div>

<!-- affichage tableau -->
<div id="client" class="cadre hoverTab"></div>


<script>
    $(document).ready(function() {

        var form = $('#formFilter');
        form.on('submit', function(e) {
            e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire

            var $this = $(this);

            $.ajax({
                url: $this.attr('action'),
                type: $this.attr('method'),
                data: $this.serialize(),
                success: function(html) {
                   $('#client').html(html);

                }
            });

        });

        function result(){
            form.trigger( "submit" );
        }
        // -- Envoie de la requete au chargement de la page. --
        //result();

        // -- on change --
        var formChildren = $('#formFilter > *' );
        formChildren.change(function(){
            result();
        });

        $("#client.hoverTab").delegate("tbody>tr", "click", function(){
            var $this=$(this);
            var trId=$this.attr('id');
            var id=trId.replace('tr','');
            $.redirect('view_sub.php', {'id': id});

            //alert(id);
        });
    });
</script>


<?php include(FOOTER);?>

