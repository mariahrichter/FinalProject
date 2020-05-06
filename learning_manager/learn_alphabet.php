<?php include_once '../view/header.php'; ?>
<h1> What capital letter matches this lower case letter?</h1>
    <div class='lower_letter'>
        <input type="hidden" name="question_id"
                           value="<?php echo $question->getId(); ?>">
    <img src="<?php echo $question->getImage(); ?>" alt=""/>
    </div> 
<br>
<h2 class="message"> <?php echo $message; ?></h2>
<br>
<br>
<div class='capital_letters'>
    
     <?php
    foreach ($answers as $answer) :
    ?>
    <form action="" method="post">
                    <input type="hidden" name="controllerRequest" value="answer_alphabet_question">
    <input type="hidden" name="question_id" value="<?php echo $question->getId(); ?>">
    <input type="hidden" name="answer_id"  value="<?php echo $answer->getId(); ?>">
    <button id="image_button" type="submit">
        <img src="<?php echo $answer->getImage(); ?>" alt="<?php echo $answer->getDescription(); ?>">
    </button>
     </form>
     <?php endforeach; ?>

</div>
<?php include_once '../view/footer.php'; ?>