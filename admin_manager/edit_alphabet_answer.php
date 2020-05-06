<?php include_once '../view/header.php'; ?>

<h1>Update Answer</h1>

<form action="" method="POST">
    <input type="hidden" name="question_id"
           value="<?php echo $question->getId(); ?>">
    <br>
    <input type="hidden" name="answer_id"
           value="<?php echo $answer->getId(); ?>">
    <br>
    <label>Question:</label><br>
    <label><?php echo $question->getDescription(); ?></label>
    <br>
    <label>Description:</label>
    <input type="description" name="description"
           value="<?php echo $answer->getDescription(); ?>">
    <br>
    <label>Image:</label>
    <input type="imagePath" name="imagePath"
           value="<?php echo $answer->getImage(); ?>">
    <br>
    <label>Status</label>
    <select name="isActive">
        <option value="<?php echo $answer->getIsActive(); ?>">
            <?php echo $answer->getStatusDescription() ?>
        </option>
        <option value="<?php echo $answer->getNotIsActive(); ?>">
            <?php echo $answer->getNotStatusDescription() ?></option>
    </select>
    <br>
    <input type="hidden" name="controllerRequest" value="update_answer">
    <input type="submit" name="updateParent" value="Update Answer"><br><br>
</form>

<h2 class="error"> <?php echo $error_message; ?></h2>
<br>
<?php include_once '../view/footer.php'; ?>