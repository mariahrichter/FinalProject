<?php include_once '../view/header.php'; ?>
<h1>Please choose a player</h1>

<?php
    foreach ($children as $child) :
    ?>
<form action="" method="POST">  
     <input type="hidden" name="controllerRequest" 
               value="select_child">
    <label>Child:</label><br>
        <label>Username:</label>
        <label><?php echo $child->getChildUsername(); ?></label><br>
        <label>Birthday:</label>
        <label><?php echo date( "m/d/Y", strtotime ( $child->getBirthday()) );  ?></label><br>
        <br>
        <input type="hidden" name="parent_id"
               value="<?php echo $child->getParentId(); ?>">
        <input type="hidden" name="child_id"
               value="<?php echo $child->getId(); ?>">
        <input type="submit" value="Select">  
        <br>
        <br>
</form>
    <?php endforeach; ?>
 

<?php include_once '../view/footer.php'; ?>