<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
        <?php include "../scripts/incl_head.php";?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PollSense &rsaquo; User Options</title>
    </head>

<?php if (!isset($_SESSION["username"])){
    header("location: ../pages/register_login");
}?>

    <body id="user_options">
        <!-- Navigation bar -->
        <?php include "../scripts/incl_navbar.php";?>
        <!-- Main content -->
        <div class="content">
            <!-- Customised user greeting -->
            <?php echo"<h1>Hey, ".$_SESSION["forename"]."!</h1>"?>

            <h2>Here's what you can do, now that you're logged in.</h2>
            <br>
            <!-- Links and descriptions of logged in features -->
            <div class="card-container">
                <?php if (isset($_SESSION["isAdmin"])){
                    if ($_SESSION["isAdmin"]){
                        echo "
                        <div class=\"card welcome-card\">
                            <h3>Reported Polls</h3><img title=\"Admin-only option\" style=\"position:absolute;top:20px;right:20px;\" src=\"../assets/admin_icon.svg\" width=\"20px\">
                            <p>View all polls that have been reported.</p>
                            <a class=\"action primary\" href=\"reports\" title=\"See polls that have been reported\">View Reported Polls</a>
                        </div>
                        ";
                    }
                }?>
                <?php if (isset($_SESSION["isAdmin"])){
                    if ($_SESSION["isAdmin"]){
                        echo "
                        <div class=\"card welcome-card\">
                            <h3>Manage All Polls</h3><img title=\"Admin-only option\" style=\"position:absolute;top:20px;right:20px;\" src=\"../assets/admin_icon.svg\" width=\"20px\">
                            <p>Manage all polls stored in the database.</p>
                            <a class=\"action primary\" href=\"manage?all-polls\" title=\"View all polls in the database.\">All Polls</a>
                        </div>
                        ";
                    }
                }?>
                <div class="card welcome-card">
                    <h3>Manage Polls</h3>
                    <p>See the polls you own, and view, edit, or delete them.</p>
                    <a class="action primary" href="manage" title="Manage the polls you own">My Polls</a>
                </div>
            </div>
            <div class="card-container">
                <div class="card welcome-card">
                    <h3>Change Password</h3>
                    <p>Make a strong, unique password to protect your account.</p>
                    <a class="action secondary" href="change_password" title="Change your account password">Change Password</a>
                </div>
                <div class="card welcome-card" >
                    <h3>Close Account</h3>
                    <p>Delete all of your polls and account data immediately.</p>
                    <a class="action secondary" href="delete_account" title="Delete all data relating to your account">Delete My Data</a>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include "../scripts/incl_footer.php";?>
    </body>
</html>
