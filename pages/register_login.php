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
            <div class="card" style="position:absolute;right:350px;width:20% !important;text-align:center;">
            <h3>Dev Note - Sample Users</h3>
            <table style="width:100%;">
                <th>Username</th>
                <th>Password</th>
                <tr>
                    <td>admin</td>
                    <td style="font-family:monospace">$B8b^BKRSJFn*$H-</td>
                </tr>
                <tr>
                    <td>alice.adams</td>
                    <td style="font-family:monospace">pshg3yb78S3!R#!2</td>
                </tr>
                <tr>
                    <td>bob.bennett</td>
                    <td style="font-family:monospace">afZ9St2$!$Y*Su-W</td>
                </tr>
                <tr>
                    <td>charlie.cook</td>
                    <td style="font-family:monospace">WJmey5h=&8c&a#R^</td>
                </tr>
            </table>
            </div>
            <!-- TEMP END -->

        </div>
        <!-- Footer -->
        <?php include "../scripts/incl_footer.php";?>
    </body>
</html>
