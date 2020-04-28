<?php include_once '../view/header.php'; ?>
<h1>Learn your Alphabet</h1><br>
<br>
<br>
<br>
<h1> What capital letter matches this lower case letter?</h1>
    <div class='lower_letter'>
        <input type="hidden" name="question_id"
                           value="<?php echo $question->getId(); ?>">
    <img src="<?php echo $question->getImage(); ?>" alt=""/>
    </div> 
<br><br><br>
<form action="" method="post">
                    <input type="hidden" name="controllerRequest"
                           value="next_question">
                    <input type="submit" value="Next">
                </form></td>
<br>
<h2 class="message"> <?php echo $message; ?></h2>
<br>
<br>
<div class='capital_letters'>
    
     <?php
    foreach ($answers as $answer) :
    ?>
    <input type="hidden" name="answer_id"
                           value="<?php echo $answer->getId(); ?>">
    <a href="learning_manager/?controllerRequest=answer_alphabet_question" >
        <img src="<?php echo $answer->getImage(); ?>" alt="<?php echo $answer->getDescription(); ?>"></a>
     <?php endforeach; ?>

</div>
<?php include_once '../view/footer.php'; ?>