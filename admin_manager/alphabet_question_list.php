<?php include_once '../view/header.php'; ?>
<h1>Parent List</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Description</th>
        <th>Letter</th>
        <th>Image</th>
        <th>Status</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    
    <?php
    foreach ($questions as $question) :
    ?>
        <tr>
            <td><?php echo $question->getId(); ?></td>
            <td><?php echo $question->getDescription(); ?></td>
            <td><?php echo $question->getLetter(); ?></td>
            <td><?php echo $question->getImage(); ?></td>
            <td><?php echo $question->getStatusDescription(); ?></td>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="controllerRequest"
                           value="add_answer_form">
                    <input type="hidden" name="question_id"
                           value="<?php echo $question->getId(); ?>">
                    <input type="submit" value="Add Answer">
                </form></td>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="controllerRequest"
                           value="view_answer">
                    <input type="hidden" name="question_id"
                           value="<?php echo $question->getId(); ?>">
                    <input type="submit" value="View Answer">
                </form></td>
                <td>
                <form action="" method="post">
                    <input type="hidden" name="controllerRequest"
                           value="edit_question">
                    <input type="hidden" name="question_id"
                           value="<?php echo $question->getId(); ?>">
                    <input type="submit" value="Edit">
                </form></td>
        </tr>
    <?php endforeach; ?>
</table>
<br>
<button type="button"><a href="admin_manager/?controllerRequest=display_add_alphabet_question">Add Question</a></button>
<br>
<?php include_once '../view/footer.php'; ?>