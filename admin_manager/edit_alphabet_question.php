<?php include_once '../view/header.php'; ?>

<h1>Update Question</h1>

<form action="" method="POST">
    <input type="hidden" name="question_id"
           value="<?php echo $question->getId(); ?>">
    <br>
    <label>Description:</label>
    <input type="description" name="description"
           value="<?php echo $question->getDescription(); ?>">
    <br>
    <label>Letter:</label>
    <input type="letter" name="letter"
           value="<?php echo $question->getLetter(); ?>">
    <br>
    <label>Image:</label>
    <input type="imagePath" name="imagePath"
           value="<?php echo $question->getImage(); ?>">
    <br>
        <label>Status</label>
        <select name="isActive">
        <option value="<?php echo $question->getIsActive(); ?>">
            <?php echo $question->getStatusDescription() ?>
        </option>
        <option value="<?php echo $question->getNotIsActive(); ?>">
            <?php echo $question->getNotStatusDescription() ?></option>
    </select>
    <br>
    <input type="hidden" name="controllerRequest" value="update_question">
    <input type="submit" name="updateParent" value="Update Question" class="button"><br><br>
</form>

<h2 class="error"> <?php echo $error_message; ?></h2>
<br>
<?php include_once '../view/footer.php'; ?>