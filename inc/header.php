


<header>
    <div id="back-header">
        <div id="header_left">
        <?php if(isset($new_client)){ ?>
          <p><a href="<?php echo URL_ROOT.'client/new_client.php';?>" ><img src="<?php echo URL_ROOT.'/img/new_client.png';?>"></a></p>
        <?php }?>

            <?php if(isset($update_client)){ ?>
                <p><a id="updateClient" data-id="<?php echo $_POST['id'];?>" href="<?php echo URL_ROOT.'client/update_client.php';?>"><img src="<?php echo URL_ROOT.'/img/edit.png';?>"></a></p>
            <?php }?>

            <?php if(isset($new_sub)){ ?>
                <p><a href="<?php echo URL_ROOT.'client/new_sub.php';?>" ><img src="<?php echo URL_ROOT.'/img/new_client.png';?>"></a></p>
            <?php }?>

            <?php if(isset($update_sub)){ ?>
                <p><a id="updateSub" data-id="<?php echo $_POST['id'];?>" href="<?php echo URL_ROOT.'client/update_sub.php';?>"><img src="<?php echo URL_ROOT.'/img/edit.png';?>"></a></p>
            <?php }?>
            <?php if(isset($edit_equipment)){ ?>
                <p><a id="editEquipment" data-id="<?php echo $_POST['id'];?>" href="<?php echo URL_ROOT.'equipment/edit_equipment.php';?>"><img src="<?php echo URL_ROOT.'/img/pompe.png';?>"></a></p>
            <?php }?>
            <?php if(isset($new_bottle)){ ?>
                <p><a id="newBottle"  href="<?php echo URL_ROOT.'fluido/new_bottle.php';?>"><img src="<?php echo URL_ROOT.'/img/new_client.png';?>"></a></p>
            <?php }?>
        </div>

        <div id="header_right">
            <p><a href="<?php echo URL_ROOT.'profil/index.php';?>"><img src="<?php echo URL_ROOT.'img/profile.png';?>" class="hover"></a></p>
        </div>
        <div class="clear"></div>
        <div id="cadre-button">
            <div id="home-button">
                <img src="<?php echo URL_ROOT.'img/clim.png';?>" onclick="location.replace('<?php echo URL_ROOT.'home.php';?>')">
            </div>
        </div>
    </div>

</header>
<script>
    $(document).ready(function(){
        $('#updateClient').click(function(e){
            e.preventDefault();
            var $this=$(this);
            var href=$this.attr('href');
            var id=$this.attr('data-id');
            $.redirect('update_client.php', {'id': id});
        });

        $('#updateSub').click(function(e){
            e.preventDefault();
            var $this=$(this);
            var href=$this.attr('href');
            var id=$this.attr('data-id');
            $.redirect('update_sub.php', {'id': id});
        });
        $('#editEquipment').click(function(e){
            e.preventDefault();
            var $this=$(this);
            var href=$this.attr('href');
            var id=$this.attr('data-id');
            $.redirect('../equipment/edit_equipment.php', {'id': id});
        });


    });

</script>