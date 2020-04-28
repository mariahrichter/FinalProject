<?php include_once '../view/header.php'; ?>
<h1>Add Parent</h1>

<form action="" method="POST">
    <label>Role</label>
    <select name="roleId">
        <option value='1'>User</option>
        <option value='2'>Admin</option>
    </select>
    <br>
    <label>First Name:</label>
    <input type="text" name="firstName">
    <br>
    <label>Last Name:</label>
    <input type="text" name="lastName">
    <br>
    <label>Phone:</label>
    <input type="text" name="phone">
    <br>
    <label>Email:</label>
    <input type="text" name="email">
    <br>
    <label>Password:</label>
    <input type="text" name="password">
    <br>
    <label>Confirm Password:</label>
    <input type="text" name="password2">
    <br>
    <label>Zip Code:</label>
    <input type="text" name="zip">
    <br>
    
    <input type="hidden" name="controllerRequest" value="add_parent">
    <input type="submit" name="register" value="Register">
</form>

<h2 class="error"> <?php echo $error_message; ?></h2>
<?php include_once '../view/footer.php'; ?>