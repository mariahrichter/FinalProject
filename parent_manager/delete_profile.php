<?php include_once '../view/header.php'; ?>
<h1>Are you sure you want to delete you profile?</h1>
<h1>All progress will be lost.</h1>

<form action="" method="POST">
    <input type="hidden" name="controllerRequest" value="delete_profile">
    <input type="submit" name="delete" value="Yes, Delete">
</form>
<?php include_once '../view/footer.php'; ?>