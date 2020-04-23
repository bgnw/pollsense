<!DOCTYPE html>
<html lang="en">
<head>
    <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
    <?php include "../scripts/incl_head.php";?>
    <title>PollSense &rsaquo; Account</title>
</head>

<?php
    if (isset($_SESSION["username"])) {
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
            <form action="../scripts/form_handler.php" method="POST">
                <h2>New Users</h2>
                <div>
                    <input type="text" name="forename" maxlength="64" placeholder="Forename"
                        required>
                    <input type="text" name="surname" maxlength="64" placeholder="Surname"
                        required>
                    <input type="text" name="username" maxlength="64" placeholder="Username"
                        required>
                    <input type="password" name="password" autocomplete="new-password" minlength="12"
                        maxlength="64" placeholder="Password (min. 12 characters)" required>
                </div>
                <input type="submit" name="user_register_submit" value="Create Account">
            </form>
        </div>
        <div class="card">
            <!-- PHP form to log into a user account -->
            <form action="../scripts/form_handler.php" method="POST">
                <h2>Existing Users</h2>
                <div>
                    <input type="text" name="username" maxlength="64" placeholder="Username"
                        required autofocus>
                    <input type="password" name="password" autocomplete="current-password"
                        minlength="12" maxlength="64" placeholder="Password" required>
                </div>
                <input type="submit" name="user_login_submit" value="Log In">
            </form>
        </div>
    </div>
    <div class="card-container">
        <div class="card">
            <h2>Important notice</h2>
            <p>Please note that passwords are currently stored as <b>plaintext</b>.
                Do not use a password you use elsewhere!</p>
        </div>
    </div>
    </div>
    <!-- Footer -->
    <?php include "../scripts/incl_footer.php";?>
</body>
</html>
