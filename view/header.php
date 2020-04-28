<!DOCTYPE HTML>
<html>
    <head>
        <title>Early Learning</title>
        <base href="http://localhost/final_project/EarlyLearning/">
        
<!--        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>-->
        
        <link rel="stylesheet" type="text/css" href="styles/main.css">
    </head>

    <header>
        <nav>
            <ul>
                <li><a href="">Home</a></li>
                <?php if (Utility::getUserRoleIdFromSession() == 0) { ?>
                    <li><a href="parent_manager/?controllerRequest=login_parent_form">Login</a></li>
                    <li><a href="parent_manager/?controllerRequest=register_parent_form">Sign Up</a></li>
                <?php } elseif (Utility::getUserRoleIdFromSession() > 0 || Utility::getUserRoleIdFromSession() == 2) {
                    ?>
                    <li><a href="parent_manager/?controllerRequest=display_parent_profile">My Profile</a></li>
                    <li><a href="learning_manager/?controllerRequest=display_learning_options">Learning</a></li>
                    <li><a href="parent_manager/?controllerRequest=logOut">
                            <form action="" method="post">
                                <input type="hidden" name="controllerRequest" value="logOut">
                                Log Out
                            </form></a></li>
                    <?php if (Utility::getUserRoleIdFromSession() == 2) { ?>
                        <li><a href="admin_manager/?controllerRequest=display_all_parents">All Users</a></li>
                        <li><a href="admin_manager/?controllerRequest=display_alphabet_question_list">All Alphabet Questions</a></li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </nav>
    </header>

    <body>
        <main>


