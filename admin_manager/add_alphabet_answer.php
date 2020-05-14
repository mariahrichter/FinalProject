<?php include_once '../view/header.php'; ?>
<aside>
<h1>Add Alphabet Answer</h1>
<br>
<form action="" method="POST">
    <input type="hidden" name="question_id"
        value="<?php echo $question->getId(); ?>">
    <label>Question:</label><br>
    <label><?php echo $question->getDescription(); ?></label>
    <br><br>
    <label>Description:<label>
    <input type="text" name="description" size="100">
    <br>
    <br>
    <label>Image:</label>
    <input type="text" name="image" size="100">
    <br>
    <br>
    <input type="hidden" name="controllerRequest" value="add_alphabet_answer">
    <input type="submit" name="register" value="Add" class="button">
</form>
</aside>
<br><br>

<h2 class="error"> <?php echo $error_message; ?></h2>

<?php include_once '../view/footer.php'; ?>