<?php include_once '../view/header.php'; ?>

<h1>Answer</h1>

<form action="" method="POST">
    <input type="hidden" name="question_id"
           value="<?php echo $question->getId(); ?>">
    <br>
    <label>Question:</label><br>
    <label><?php echo $question->getDescription(); ?></label>
    <br>
    <label>Description:</label>
    <label><?php echo $answer->getDescription(); ?></label>
    <br>
    <label>Image:</label>
    <label><?php echo $answer->getImage(); ?></label>
    <br>
    <label>Status:</label>
    <td><?php echo $answer->getStatusDescription(); ?></td>
    <br>
    <input type="hidden" name="controllerRequest" value="display_edit_answer">
    <input type="submit" name="updateParent" value="Update Answer" class="button"><br><br>
</form>

<br>
<?php include_once '../view/footer.php'; ?>