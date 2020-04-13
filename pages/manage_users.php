<!DOCTYPE html>
<html lang="en">
<head>
    <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
    <?php include "../scripts/incl_head.php";?>
    <title>PollSense &rsaquo; Manage Users</title>
</head>

<?php
// Redirect to an error message if the user is not logged in.
if (!isset($_SESSION["isAdmin"])){
    header("location: info?error=no_login");
    exit;
}
// Redirect to an error message if a non-admin tries to access this page.
elseif (!$_SESSION["isAdmin"]){
    header("location: info?error=no_admin");
    exit;
}
?>

<body id="manage_users">
    <!-- Navigation bar -->
    <?php include "../scripts/incl_navbar.php";?>

    <!-- Main content -->
    <div class="content">
    <div class="card-container">
    <div class="large card">

<?php
include "../scripts/incl_db_handler.php";

// Query the database to retrieve all users.
$dbq_users = "SELECT forename, surname, username, admin, creation FROM users;";
$dbq_users_result = mysqli_query($dbConn, $dbq_users);

// Check for any errors and redirect to error page if needed.
if (mysqli_error($dbConn)) {
    header("location: ../pages/info?error=database");
    exit;
}
// Fetch the first user result row, and store it in $dbq_users_result_row.
$dbq_users_result_row = mysqli_fetch_assoc($dbq_users_result);

// Iterate through each result row and echo it to the user.
echo "<form action=\"../scripts/form_handler.php\"
method=\"POST\">
<h2>All Users</h2>
<table class=\"large-table\">
<thead>
<tr>
    <th></th>
    <th>Forename</th>
    <th>Surname</th>
    <th>Username</th>
    <th>Admin</th>
    <th>Creation Date</th>
</tr>
</thead>
<tbody>";
while ($dbq_users_result_row){
    echo "<tr>
        <td><input type=\"radio\" value=\"".
        $dbq_users_result_row["username"]."\" required name=\"radio_user_manage\"></td>
        <td><p>".$dbq_users_result_row["forename"]."</p></td>
        <td><p>".$dbq_users_result_row["surname"]."</p></td>
        <td><p>".$dbq_users_result_row["username"]."</p></td>
        <td><p>";
        if ($dbq_users_result_row["admin"]){
            echo "Yes";
        } else {
            echo "No";
        }
        echo "</p></td>
        <td><p>".$dbq_users_result_row["creation"]."</p></td>
    </tr>";
    $dbq_users_result_row = mysqli_fetch_assoc($dbq_users_result);
}
echo "
</tbody>
</table>";
?>
        <table class="actions">
            <td><input type="submit" name="user_manage_view_polls" value="View Owned Polls"></td>
            <td><input type="submit" class="secondary" name="user_manage_change_password"
                value="Change Password"></td>
            <td><input type="submit" class="tertiary" name="user_manage_delete_account"
                value="Delete Account"></td>
        </table>
        </form>
    </div>
    </div>
    </div>
    <!-- Footer -->
    <?php include "../scripts/incl_footer.php";?>
</body>
</html>
