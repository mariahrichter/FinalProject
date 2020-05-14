<!DOCTYPE HTML>
<html>
    <head>
        <title>Early Learning</title>
        <base href="http://localhost/final_project/EarlyLearning/">

        <link href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="styles/normalize.css">
        <link rel="stylesheet" type="text/css" href="styles/main.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="images/abc_icon.png">
        <link rel="stylesheet" href="styles/slicknav.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="js/jquery.slicknav.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#nav_menu').slicknav({prependTo: "#mobile_menu"});
            });
        </script>
    </head>

    <header>
        <nav id="mobile_menu"></nav>
        <nav id="nav_menu">
            <ul>
                <li class="home"><a href="">Home</a></li>
                <?php if (Utility::getUserRoleIdFromSession() == 0) { ?>
                    <li><a href="parent_manager/?controllerRequest=login_parent_form">Login</a></li>
                    <li><a href="parent_manager/?controllerRequest=register_parent_form">Sign Up</a></li>
                <?php } elseif (Utility::getUserRoleIdFromSession() > 0 || Utility::getUserRoleIdFromSession() == 2) {
                    ?>
                    <li><a href="parent_manager/?controllerRequest=display_parent_profile">My Profile</a></li>
                    <li><a href="learning_manager/?controllerRequest=display_learning_options">Alphabet Game</a></li>
                    <li><a href="parent_manager/?controllerRequest=logOut">
                            <form action="" method="post">
                                <input type="hidden" name="controllerRequest" value="logOut">
                                Log Out
                            </form></a></li>
                    <?php if (Utility::getUserRoleIdFromSession() == 2) { ?>
                            <li><a>Admin</a>
                                <ul class="dropdown-content">
                                    <li><a href="admin_manager/?controllerRequest=display_all_parents">All Users</a></li><br>
                                    <li><a href="admin_manager/?controllerRequest=display_alphabet_question_list">All Alphabet Questions</a></li>
                                </ul>
                            </li>

                    <?php } ?>
                <?php } ?>
            </ul>
        </nav>
        <div class="weatherContainer">
            <div class="weather">
                <?php
                if (isset($_SESSION['Parent'])) {
                    $apiKey = "7a3501b48865a753de4a7f70ee334be3";
                    $zipCode = $_SESSION['Parent']->getZip();
                    $countryCode = "US";
                    $googleApiUrl = "api.openweathermap.org/data/2.5/weather?zip=" . $zipCode . "," . $countryCode . "&units=imperial&appid=" . $apiKey;


                    $ch = curl_init();


                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    curl_setopt($ch, CURLOPT_VERBOSE, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $response = curl_exec($ch);


                    curl_close($ch);
                    $data = json_decode($response);
                    $currentTime = time();
                    $cityName = $data->name;
                }

                if (isset($_SESSION['Parent'])) {
                    echo "<div style='float: right;'>
        <h2> $cityName   Weather Status</h2><div class='time'>";
                    echo "<div>" . date('l g:i a', $currentTime) . "</div>";
                    echo "<div>" . date('jS F, Y', $currentTime) . "</div>";
                    ?>

                    <div><?php echo ucwords($data->weather[0]->description); ?></div>
                </div>
                <div class='weather-forecast'>
                    <img
                        src='http://openweathermap.org/img/w/<?php echo $data->weather[0]->icon; ?>.png'
                        class='weather-icon' /> <?php echo $data->main->temp_max; ?>°F <span
                        class='min-temperature'><?php echo $data->main->temp_min; ?>°F</span>
                </div>
                <div class='time'>
                    <div>Humidity: <?php echo $data->main->humidity; ?> %</div>
                    <div>Wind: <?php echo $data->wind->speed; ?> km/h</div>
                </div>
                <?php
            }
            ?>
        </div>
        
    </header>

    <body>
        <main>


