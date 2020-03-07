<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
        <?php include "../scripts/incl_head.php";?>
        <title>PollSense &rsaquo; Account</title>
    </head>
<?php
if (isset($_SESSION["username"])){
    header("location: ../pages/user_options");
}?>
    <body id="account">
        <!-- Navigation bar -->
        <?php include "../scripts/incl_navbar.php";?>

        <!-- Main content -->
        <div class="content">
            <div class="card-container">
                <div class="card">
                    <!-- PHP form to create a new user account -->
                    <form name="user_register" action="../scripts/form_handler.php" method="post">
                        <!-- Removed the breaks and added a div around the center part -->
                        <h2>New Users</h2>
                        <div>
                            <input type="text" name="forename" maxlength="64" placeholder="Forename" required>
                            <input type="text" name="surname" maxlength="64" placeholder="Surname" required>
                            <input type="text" name="username" maxlength="64" placeholder="Username" required>
                            <input type="password" name="password" maxlength="64" placeholder="Password" required>
                        </div>
                        <input type="submit" name="user_register_submit" value="Create Account">
                    </form>
                </div>
                <div class="card">
                    <!-- PHP form to log into a user account -->
                    <form name="user_login" action="../scripts/form_handler.php" method="post">
                        <a style="display:inline;position:absolute;top:12px;right:30px;width:50px;" class="action secondary" onclick="showUsers()">+</a>
                        <h2>Existing Users</h2>
                        <div>
                            <input type="text" name="username" maxlength="64" placeholder="Username" required autofocus>
                            <input type="password" name="password" maxlength="64" placeholder="Password" required>
                        </div>
                        <input type="submit" name="user_login_submit" value="Log In">
                    </form>
                </div>
            </div>

            <!-- TEMP START -->
            <div style="width:200px;position:absolute;top:160px;right:10px;background-color:rgba(0,0,0,0.7);display:none;" id="sample-users" class="card"><br><br>
                <h4 style="color:white;">Sample Users</h4><br><br>
                <a class="action tertiary" onclick="fillUser('admin')">admin</a><br><br><br>
                <a class="action tertiary" onclick="fillUser('alice.adams')">alice.adams</a><br><br><br>
                <a class="action tertiary" onclick="fillUser('bob.bennett')">bob.bennett</a><br><br><br>
                <a class="action tertiary" onclick="fillUser('charlie.cook')">charlie.cook</a><br><br>
            </div>
            <!-- TEMP END -->

        </div>
        <!-- Footer -->
        <?php include "../scripts/incl_footer.php";?>
    </body>
</html>
