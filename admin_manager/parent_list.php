<?php include_once '../view/header.php'; ?>
<h1>Parent List</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Role ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Zip</th>
        <th>Status</th>
        <th>Add Child</th>
        <th>Edit Parent</th>
    </tr>
    
    <?php
    foreach ($parents as $parent) :
    ?>
        <tr>
            <td><?php echo $parent->getId(); ?></td>
            <td><?php echo $parent->getRoleId(); ?></td>
            <td><?php echo $parent->getFirstName(); ?></td>
            <td><?php echo $parent->getLastName(); ?></td>
            <td><?php echo $parent->getPhone(); ?></td>
            <td><?php echo $parent->getEmail(); ?></td>
            <td><?php echo $parent->getZip(); ?></td>
            <td><?php echo $parent->getStatusDescription(); ?></td>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="controllerRequest"
                           value="add_child_form">
                    <input type="hidden" name="parent_id"
                           value="<?php echo $parent->getId(); ?>">
                    <input type="submit" value="Add Child">
                </form></td>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="controllerRequest"
                           value="edit_parent">
                    <input type="hidden" name="parent_id"
                           value="<?php echo $parent->getId(); ?>">
                    <input type="submit" value="Edit">
                </form></td>
        </tr>
    <?php endforeach; ?>
</table>
<br>
<button type="button"><a href="admin_manager/?controllerRequest=display_add_parent">Add Parent</a></button>
<br>
<?php include_once '../view/footer.php'; ?>