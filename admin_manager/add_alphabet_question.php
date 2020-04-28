<?php include_once '../view/header.php'; ?>
<aside>
<h1>Add Alphabet Question</h1>
<br>
<form action="" method="POST">
    <label>Description:<label>
    <input type="text" name="description" size="100">
    <br>
    <br>
    <label>Letter:</label>
    <input type="text" name="letter" size="100">
    <br>
    <br>
    <label>Image:</label>
    <input type="text" name="image" size="100">
    <br>
    <br>
    <input type="hidden" name="controllerRequest" value="add_alphabet_question">
    <input type="submit" name="register" value="Add">
</form>
<br><br>
</aside>
<h2 class="error"> <?php echo $error_message; ?></h2>
<br>
<?php include_once '../view/footer.php'; ?>