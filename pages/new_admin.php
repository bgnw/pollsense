<!DOCTYPE html>
<html lang="en">
<head>
    <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
    <?php include "../scripts/incl_head.php";?>
    <title>PollSense &rsaquo; New Admin</title>
</head>

<?php
    // Redirect to an error message if the user is not logged in.
    if ((!isset($_SESSION["username"])) || (!isset($_SESSION["isAdmin"]))){
        header("location: info?error=no_login");
        exit;
    }
    // Redirect to an error message if a non-admin tries to access this page.
    elseif (!$_SESSION["isAdmin"]){
        header("location: info?error=no_admin");
        exit;
    }
?>

<body id="**PAGE**">
    <!-- Navigation bar -->
    <?php include "../scripts/incl_navbar.php";?>

    <!-- Main content -->
    <div class="content">
    <div class="card-container">
        <div class="card">
            <!-- PHP form to create a new user account -->
            <form action="../scripts/form_handler.php" method="POST">
                <h2>New Admin Account</h2>
                <div>
                    <input type="text" name="forename" maxlength="64" placeholder="Forename" required>
                    <input type="text" name="surname" maxlength="64" placeholder="Surname" required>
                    <input type="text" name="username" maxlength="64" placeholder="Username" required>
                    <input type="password" name="password" autocomplete="new-password"
                        minlength="12" maxlength="64" placeholder="Password (min. 12 characters)"
                        required>
                </div>
                <input type="submit" name="new_admin_submit" value="Create Admin Account">
            </form>
        </div>
    </div>
    </div>
    <!-- Footer -->
    <?php include "../scripts/incl_footer.php";?>
</body>
</html>
