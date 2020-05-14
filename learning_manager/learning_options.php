<?php include_once '../view/header.php'; ?>

<h1>Please choose a player</h1>
<div class="player">
<?php
    foreach ($children as $child) :
    ?> 
<form action="" method="POST">  
     <input type="hidden" name="controllerRequest" 
               value="select_child">
     <br>
     <label><b>Player</b></label><br>
        <label>Username:</label>
        <label><?php echo $child->getChildUsername(); ?></label><br>
        <label>Birthday:</label>
        <label><?php echo date( "m/d/Y", strtotime ( $child->getBirthday()) );  ?></label><br>
        <br>
        <input type="hidden" name="parent_id"
               value="<?php echo $child->getParentId(); ?>">
        <input type="hidden" name="child_id"
               value="<?php echo $child->getId(); ?>">
        <input type="submit" value="Select" class="button">  
        <br>
        <br>
</form>
    <?php endforeach; ?>
 </div>  
<h2 class="error"> <?php echo $error_message; ?></h2>
<?php include_once '../view/footer.php'; ?>