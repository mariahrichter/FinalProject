<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php include_once '../view/header.php'; ?>
<h1>Parent Login</h1>
<form action="" method="POST">
    <input type="hidden" name="controllerRequest" value="parent_process_login">
    <label>Email:</label>
    <input type="text" name="email" value= "<?php echo $email ?>">
    <br>
    <label>Password:</label>
    <input type="password" name="password" value="<?php echo $password ?>">
    <br>
    <input type="submit" name="login" value="Login">
</form>

<h2 class="error"> <?php echo $error_message; ?></h2>
<?php include_once '../view/footer.php'; ?>