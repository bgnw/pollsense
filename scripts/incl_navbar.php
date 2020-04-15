<nav>
<a style="height:auto;" class="logo" href="./">
    <img class="logo" src="../assets/logo-with-text.png" alt="PollSense Logo" height="60px">
</a>

<!-- Script to make current page name bold in navbar -->
<?php
    $explode_result = explode("/", $_SERVER["REQUEST_URI"]);
    $current_page = end($explode_result);
    unset($explode_result);

    $about_class = "";
    $join_class = "";
    $create_class = "";
    $account_class = "";
    $index_class = "";

    switch ($current_page) {
        // check if URL is just "/" (without any page name)
        case false:
            // "falling through" to the next case, as the action is identical
            // to this case.
        case "index":
            $index_class = "current";
            break;
        case "about":
            $about_class = "current";
            break;
        case "join":
            $join_class = "current";
            break;
        case "create":
            $create_class = "current";
            break;
        case "register_login":
            // "falling through" to the next case, as the action is identical
            // to this case.
        case "user_options":
            $account_class = "current";
            break;
    }
?>

<!-- Desktop navbar -->
<div id="navbar-desktop">
<ul class="navbar-links">
    <?php
    echo "<li><a class=\"$index_class\" href=\"./\" title=\"Return to the homepage\">Home</a></li>
    <li><a class=\"$about_class\" href=\"about\"
        title=\"Learn more about PollSense\">About</a></li>";
    ?>
</ul>
<div>
    <?php
    echo "<a class=\"action primary $join_class\" href=\"join\"
        title=\"Participate in an existing poll\">Join&nbsp;Poll</a>
    <a class=\"action primary $create_class\" href=\"create\"
        title=\"Make a new poll\">Create&nbsp;Poll</a>";
    ?>
</div>
<div class="vl"></div>
<div>
    <?php
    echo "<a class=\"action secondary $account_class\" href=\"../scripts/account_redirect.php\"
        title=\"Go to account options\">Account</a>";
    // If user is logged in, show a log out button.
    if (isset($_SESSION["username"])) {
        echo "\n<a class=\"action secondary\" href=\"../scripts/logout.php\"
            title=\"Log out of your account\">Log&nbsp;Out</a>";
    }
    ?>
</div>
</div>

<!-- Mobile navbar -->
<button onclick="show_mobile_nav()" class="action primary" id="navbar-mobile-show">&#9776;</button>
<div id="navbar-mobile-overlay">
    <a onclick="hide_mobile_nav()" id="navbar-mobile-hide">&times;</a>
    <div id="navbar-mobile-container">
        <div id="navbar-mobile-content">
            <?php
            echo "<a class=\"$index_class\" href=\"./\" title=\"Return to the homepage\">Home</a>
            <a class=\"$about_class\" href=\"about\" title=\"Learn more about PollSense\">About</a>
            <a class=\"$join_class\" href=\"join\"
                title=\"Participate in an existing poll\">Join&nbsp;Poll</a>
            <a class=\"$create_class\" href=\"create\" title=\"Make a new poll\">Create&nbsp;Poll</a>
            <a class=\"$account_class\" href=\"../scripts/account_redirect.php\"
                title=\"Go to account options\">Account</a>";
            // If user is logged in, show a log out option.
            if (isset($_SESSION["username"])) {
                echo "<a href=\"../scripts/logout.php\"
                    title=\"Log out of your account\">Log&nbsp;Out</a>";
            }
            ?>

        </div>
    </div>
</div>
</nav>
