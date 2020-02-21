<nav>
<a style="height:auto;" class="logo" href="./">
    <img class="logo" src="../assets/logo.svg" alt="PollSense Logo" height="60px">
</a>
<?php
    // ini_set("display_errors",false);

    preg_match("/[a-zA-Z_]+\.php/",$_SERVER["REQUEST_URI"],$current_page);
    if (isset($current_page[0])) {
        $current_page=$current_page[0];
    }

    $about_class = "";
    $join_class = "";
    $create_class = "";
    $account_class = "";
    $index_class = "";

    switch ($current_page){
        // check if URL is just "/" (without any page name)
        case false:
            // "falling through" to the next case, as the action is identical
            // to this case.
        case "./":
            $index_class = "current";
            break;
        case "about.php":
            $about_class = "current";
            break;
        case "join.php":
            $join_class = "current";
            break;
        case "create.php":
            $create_class = "current";
            break;
        case "register_login.php":
            // "falling through" to the next case, as the action is identical
            // to this case.
        case "logged_in_menu.php":
            $account_class = "current";
            break;
    }
    $index = "<li><a class=\"$index_class\" href=\"./\" title=\"Return to the homepage\">Home</a></li>";
    $about = "<li><a class=\"$about_class\" href=\"about\" title=\"Learn more about PollSense\">About</a></li>";
    $join = "<a class=\"action $join_class\" href=\"join\" title=\"Participate in an existing poll\">Join&nbsp;Poll</a>";
    $create = "<a class=\"action $create_class\" href=\"create\" title=\"Make a new poll\">Create&nbsp;Poll</a>";
    $account = "<a class=\"action secondary $account_class\" href=\"../scripts/account_redirect.php\" title=\"Log In or Sign Up\">Account</a>";

    if (isset($_SESSION["username"])){
        $logout = "<a class=\"action secondary\" href=\"../scripts/logout.php\" title=\"Log out of your account\">Log&nbsp;Out</a>";
    } else {
        $logout = "";
    }

    echo "
    <ul class=\"navbar-links\">
        $index
        $about
    </ul>
    <div>
        $join
        $create
    </div>
    <div class=\"vl\"></div>
    <div>
        $account
        $logout
    </div>

    <!-- TEMP: devpages - to be removed before release -->
    <a style=\"margin-left:5px;background-color:#303138;color:#484a54;\" href=\"devpages\" class=\"action\">Dev</a>
    ";
?>
</nav>
