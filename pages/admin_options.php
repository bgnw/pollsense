<!DOCTYPE html>
<html lang="en">
<head>
    <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
    <?php include "../scripts/incl_head.php";?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PollSense &rsaquo; Admin Options</title>
</head>

<?php
    // Redirect to an error message if the user is not logged in.
    if ((!isset($_SESSION["username"])) || (!isset($_SESSION["isAdmin"]))) {
        header("location: info?error=no_login");
        exit;
    }
    // Redirect to an error message if a non-admin user tries to access this page.
    elseif (!$_SESSION["isAdmin"]) {
        header("location: info?error=no_admin");
        exit;
    }
?>

<body id="admin_options">
    <!-- Navigation bar -->
    <?php include "../scripts/incl_navbar.php";?>
    <!-- Main content -->
    <div class="content">
    <h1>Admin Options</h1>
    <h2>Here's the admin-only control page.</h2>
    <br>
        <!-- Links and descriptions of admin features -->
        <div class="card-container">
            <div class="card option-card">
                <h3>New Admin</h3>
                <p>Make another account with admin privileges</p>
                <a class="action primary" href="new_admin"
                    title="Make another admin account">New Admin</a>
            </div>
            <div class="card option-card">
                <h3>Reported Polls</h3>
                <p>View all polls that have been reported.</p>
                <a class="action primary" href="reports"
                    title="See polls that have been reported">View Reported Polls</a>
            </div>
        </div>
        <div class="card-container">
            <div class="card option-card">
                <h3>Manage All Polls</h3>
                <p>Manage all polls stored in the database.</p>
                <a class="action primary" href="manage_polls?all-polls"
                    title="View all polls in the database.">All Polls</a>
            </div>
            <div class="card option-card">
                <h3>Manage All Users</h3>
                <p>Manage all users stored in the database.</p>
                <a class="action primary" href="manage_users"
                title="View all polls in the database.">All Users</a>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php include "../scripts/incl_footer.php";?>
</body>
</html>
