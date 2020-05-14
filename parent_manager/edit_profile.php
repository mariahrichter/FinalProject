
<?php include_once '../view/header.php'; ?>
<br>
<h1>Update Profile</h1>
<div class="updateProfile">
    <form action="" method="POST">
        <input type="hidden" name="parent_id"
               value="<?php echo $parent->getId(); ?>">

        <label>First Name:</label>
        <input type="firstName" name="firstName"
               value="<?php echo $parent->getFirstName(); ?>">
        <br>
        <label>Last Name:</label>
        <input type="lastName" name="lastName"
               value="<?php echo $parent->getLastName(); ?>">
        <br>
        <label>Phone:</label>
        <input type="phone" name="phone"
               value="<?php echo $parent->getPhone(); ?>">
        <br>
        <label>Email:</label>
        <input type="email" name="email"
               value="<?php echo $parent->getEmail(); ?>">
        <br>
        <label>Zip Code:</label>
        <input type="zip" name="zip"
               value="<?php echo $parent->getZip(); ?>">
        <br>
        <br>
        <input type="hidden" name="controllerRequest" value="update_profile">
        <input type="submit" name="updateParent" value="Update Profile" class="button"><br><br>
    </form>
</div>
<div class="passwordVerify">
    <form action="" method="POST">
        <input type="hidden" name="parent_id"
               value="<?php echo $parent->getId(); ?>">
        <br>
        <br>
        <span>Input Password Twice to make sure they match.</span>
        <br>
        <br>
        <label>New Password:</label>
        <input type="password" name="password">
        <br>
        <label>Confirm New Password:</label>
        <input type="password" name="password2">
        <br>
        <h2 class="error"> <?php echo $error_message; ?></h2>    
        <br>
        <input type="hidden" name="controllerRequest" value="update_password">
        <input type="submit" name="updatePassword" value="Update Password" class="button"><br><br>
    </form>
    <br>
</div>

<?php
foreach ($children as $child) :
    ?>
    <div class="child">
        <form action="" method="post">
            <input type="hidden" name="controllerRequest" 
                   value="update_child">
            <label>Child:</label><br>
            <label>Username:</label>
            <input type="childUsername" name="childUsername"
                   value="<?php echo $child->getChildUsername(); ?>"><br>
            <label>Birthday:</label>
            <input type="date" name="childBirthday" value="<?php echo date("Y-m-d", strtotime($child->getBirthday())); ?>"><br>
            <br>
            <input type="hidden" name="child_id"
                   value="<?php echo $child->getId(); ?>">
            <input type="submit" value="Save" class="button">  
            <br>
            <br>
        </form>
    </div>
<?php endforeach; ?>
<br>
<br>
<form action="" method="POST">
    <input type="hidden" name="controllerChoice"
               value="display_parent_profile">

            <input type="submit" value="Back to Profile" class="button">  
</form>

<h2 class="error"> <?php echo $error_message; ?></h2>

<?php include_once '../view/footer.php'; ?>

