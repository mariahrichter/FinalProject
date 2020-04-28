
<?php include_once '../view/header.php'; ?>

<h1>Update Parent</h1>

<form action="" method="POST">
    <input type="hidden" name="parent_id"
           value="<?php echo $parent->getId(); ?>">
    <label>Role</label>
    <select name="roleId">
        <option value="<?php echo $parent->getRoleId(); ?>">
            <?php echo $parent->getRoleDescription(); ?>
        </option>
        <option value="<?php echo $parent->getNotIsActive(); ?>">
            <?php echo $parent->getNotRoleDescription(); ?></option>
    </select>
    <br>
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
    <label>Status</label>
    <select name="isActive">
        <option value="<?php echo $parent->getIsActive(); ?>">
            <?php echo $parent->getStatusDescription() ?>
        </option>
        <option value="<?php echo $parent->getNotIsActive(); ?>">
            <?php echo $parent->getNotStatusDescription() ?></option>
    </select>
    <br>
    <input type="hidden" name="controllerRequest" value="update_parent">
    <input type="submit" name="updateParent" value="Update Profile"><br><br>
</form>
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
    <input type="hidden" name="controllerRequest" value="update_parent_password">
    <input type="submit" name="updatePassword" value="Update Password"><br><br>
</form>
<br>

<?php
foreach ($children as $child) :
    ?>
    <form action="" method="post">
        <input type="hidden" name="controllerRequest" 
               value="update_child">
        <label>Kid:</label><br>
        <label>Username:</label>
        <input type="childUsername" name="childUsername"
               value="<?php echo $child->getChildUsername(); ?>"><br>
        <label>Birthday:</label>
        <input type="date" name="childBirthday" value="<?php echo date("m/d/y", strtotime($child->getBirthday())); ?>"><br>
        <br>
        <label>Status</label>
        <select name="isActive">
            <option value="<?php echo $child->getIsActive(); ?>">
                <?php echo $child->getStatusDescription() ?>
            </option>
            <option value="<?php echo $child->getNotIsActive(); ?>">
                <?php echo $child->getNotStatusDescription() ?></option>
        </select>
        <br>
        <br>
        <input type="hidden" name="parent_id"
           value="<?php echo $child->getParentId(); ?>">
        <input type="hidden" name="child_id"
               value="<?php echo $child->getId(); ?>">
        <input type="submit" value="Save">  
        <br>
        <br>
    </form>
<?php endforeach; ?>



<h2 class="error"> <?php echo $error_message; ?></h2>

<?php include_once '../view/footer.php'; ?>
