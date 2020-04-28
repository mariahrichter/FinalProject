<?php include '../view/header.php'; ?>
    <h1>Database Error</h1>
    <p>There was an error connecting to the database.</p>
    <p>The database must be installed as described in the appendix.</p>
    <p>MySQL must be running as described in chapter 1.</p>
    <p>Error message: <?php echo $error_message; ?></p>
    <p>&nbsp;</p>
<?php include_once '../view/footer.php'; ?>
<?php include_once '../model/showGetPostVariables.php'; ?>
<?php //funShowAllPOSTandGETvariables(); ?>
