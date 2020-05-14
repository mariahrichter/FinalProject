<?php include_once '../view/header.php'; ?>
<h1>My Profile</h1>
<p id='progress'>*Progress is shown as a percent of the questions your child has gotten correct out 
    of the total amount of times they have played.*</p><br>
<div class="profile">
<label>Account:</label>
<label><?php echo $parent->getFirstName() . ' ' . $parent->getLastName(); ?></label><br>
<label>Email:</label>
<label><?php echo $parent->getEmail(); ?></label><br><br>
</div>
<div class="child">
    <?php
    foreach ($children as $child) :
        ?>
        <form action="" method="POST">  
            <input type="hidden" name="controllerRequest" 
                   value="delete_child">
            <label>Username:</label>
            <label><?php echo $child->getChildUsername(); ?></label><br>
            <label>Birthday:</label>
            <label><?php echo date("m/d/Y", strtotime($child->getBirthday())); ?></label><br>
            <?php
            //get the progress record
            $progress = LearningDB::getProgressRecordByChildId($child->getId());
            //if a child progress record does not exist then display progress as 0
            if ($progress->getChildId() == 0) {
                $progressPercent = 0;
            } else {
                //else get their wins and divide by their total to get the percent of correct
                //out of their total 
                $wins = $progress->getWin();
                $total = $progress->getTotalRounds();
                $progressPercent = round(($wins / $total) * 100, 2);
            }
            ?>
            <label>Progress</label><br>
            <label><?php echo $progressPercent . "%"; ?></label><br>
            <input type="hidden" name="parent_id"
                   value="<?php echo $child->getParentId(); ?>">
            <input type="hidden" name="child_id"
                   value="<?php echo $child->getId(); ?>">
            <input type="submit" value="Delete" class="button">  
            <br>
            <br>
            <br>
        </form>
    <?php endforeach; ?>
</div>
<br>
<br>
<form action="" method="post">
    <input type="hidden" name="controllerRequest"
           value="add_another_child">
    <input type="hidden" name="parent_id"
           value="<?php echo $parent->getId(); ?>">
    <input type="submit" value="Add Child" class="button">
</form>
<form action="" method="post">
    <input type="hidden" name="controllerRequest"
           value="edit_profile">
    <input type="hidden" name="parent_id"
           value="<?php echo $parent->getId(); ?>">
    <input type="submit" value="Edit My Profile" class="button">
</form>
<form action="" method="post">
    <input type="hidden" name="controllerRequest"
           value="verify_delete_profile">
    <input type="hidden" name="parentId"
           value="<?php echo $parent->getId(); ?>">
    <input type="submit" value="Delete My Profile" class="button">
</form><br>
</form>
<br>
<?php include_once '../view/footer.php'; ?>