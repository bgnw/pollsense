<!DOCTYPE html>
<html lang="en">

<head>
    <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
    <?php include "../scripts/incl_head.php";?>
    <title>PollSense &rsaquo; Change Password</title>
</head>

<?php
    // Redirect to an error page if user is not logged in.
    if (!isset($_SESSION["username"]) || !isset($_SESSION["isAdmin"])) {
        header("location: info?error=no_login");
        exit;
    }

    // Initially set the target username as the current session's username.
    $targetUsername = $_SESSION["username"];

    /* If a username has been provided as a GET variable, check if the current
    session is an admin, and if so, change the target username to the one
    provided in the GET variable. Otherwise, redirect to an error page. */
    if (isset($_GET["username"])) {
        if ($_SESSION["isAdmin"]) {
            $targetUsername = $_GET["username"];
        } else {
            header("location: ../pages/info?error=no_admin");
            exit;
        }
    }
?>

<body id="change_password">
    <!-- Navigation bar -->
    <?php include "../scripts/incl_navbar.php";?>

    <!-- Main content -->
    <div class="content">
    <div class="card-container">
    <div class="card">
        <!-- Form to change user's password -->
        <form action="../scripts/form_handler.php" method="POST">
            <h2>Change Account Password</h2>
            <p>Please enter a new password for the account.
                    <br>Username: <b><?php echo $targetUsername;?></b></p><br>
            <input type="hidden" name="username" value=<?php echo "\"$targetUsername\"";?>>
            <input type="password" name="new_password" autocomplete="new-password"
                minlength="12" maxlength="64" placeholder="New password" required>
            <input type="submit" name="user_change_password_submit" value="Change account password">
        </form>
    </div>
    </div>
    </div>

    <!-- Footer -->
    <?php include "../scripts/incl_footer.php";?>
</body>
</html>
