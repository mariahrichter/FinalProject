<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php include_once '../view/header.php'; ?>
<h1>My Profile</h1>
<form action="" method="POST">
    <label>Account:</label>
    <label><?php echo $parent->getFirstName() . ' ' . $parent->getLastName(); ?></label><br>
    <label>Email:</label>
    <label><?php echo $parent->getEmail(); ?></label><br><br>
    
  
    <?php
    foreach ($children as $child) :
    ?>
<form action="" method="POST">  
     <input type="hidden" name="controllerRequest" 
               value="delete_child">
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
        <input type="submit" value="Delete">  
        <br>
        <br>
    <?php endforeach; ?>
 </form>
        <br>
        <br>
        <form action="" method="post">
                    <input type="hidden" name="controllerRequest"
                           value="add_another_child">
                    <input type="hidden" name="parent_id"
                           value="<?php echo $parent->getId(); ?>">
                    <input type="submit" value="Add Child">
                </form>
    <form action="" method="post">
                    <input type="hidden" name="controllerRequest"
                           value="edit_profile">
                    <input type="hidden" name="parent_id"
                           value="<?php echo $parent->getId(); ?>">
                    <input type="submit" value="Edit">
                </form>
    <form action="" method="post">
                    <input type="hidden" name="controllerRequest"
                           value="verify_delete_profile">
                    <input type="hidden" name="parentId"
                           value="<?php echo $parent->getId(); ?>">
                    <input type="submit" value="Delete My Profile">
        </form><br>
</form>
<br>
<?php include_once '../view/footer.php'; ?>