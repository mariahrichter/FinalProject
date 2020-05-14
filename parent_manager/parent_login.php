<?php include_once '../view/header.php'; ?>
<h1>Parent Login</h1>
<form action="" method="POST">
    <input type="hidden" name="controllerRequest" value="parent_process_login">
    <label>Email:</label>
    <input type="text" name="email" value= "">
    <br>
    <label>Password:</label>
    <input type="password" name="password" value="">
    <br>
    <input type="submit" name="login" value="Login" class="button">
</form>

<h2 class="error"> <?php echo $error_message; ?></h2>
<?php include_once '../view/footer.php'; ?>