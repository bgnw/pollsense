<!DOCTYPE html>
<html lang="en">

<head>
    <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
    <?php include "../scripts/incl_head.php";?>
    <title>PollSense &rsaquo; Change Password</title>
</head>

        <!-- Main content -->
        <div class="content">
            <div class="card-container">
                <div class="card">
                    <form name="user_change_password" action="../scripts/form_handler.php" method="post">
                        <h2>Change Account Password</h2>
                        <p>Please enter a new password for your account. (Username: <b><?php echo $_SESSION["username"];?></b>)</p><br>
                        <input type="password" name="new_password" maxlength="64" placeholder="New password" required>
                        <input type="submit" name="user_change_password_submit" value="Change account password">
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include "../scripts/incl_footer.php";?>
    </body>
</html>
