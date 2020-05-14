<?php include_once '../view/header.php'; ?>
<h1>Add Child</h1>
<br>
<br>
<form action="" method="POST">
    <input type="hidden" name="parent_id"
           value="<?php echo $parent->getId(); ?>">
    <label>Child's Username:</label>
    <input type="text" name="username">
    <br>
    <label>Birthday:</label>
    <input type="date" name="birthday">
    <br>

    <input type="hidden" name="controllerRequest" value="add_child">
    <input type="submit" name="register" value="Register" class="button">
</form>

<h2 class="error"> <?php echo $error_message; ?></h2>
<?php include_once '../view/footer.php'; ?>