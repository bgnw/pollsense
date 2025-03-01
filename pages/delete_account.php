<!DOCTYPE html>
<html lang="en">
<head>
    <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
    <?php include "../scripts/incl_head.php";?>
    <title>PollSense &rsaquo; Delete Account</title>
</head>

<?php
    // Redirect to an error page if user is not logged in.
    if (!isset($_SESSION["username"]) || !isset($_SESSION["isAdmin"])) {
        header("location: ../pages/info?error=no_login");
        exit;
    }

    /* If a username has been provided as a GET variable, check if the current
    session is an admin, and if so, change the target username to the one
    provided in the GET variable. Otherwise, redirect to an error page. */
    elseif (isset($_GET["username"])) {
        if ($_SESSION["isAdmin"]) {
            $targetUsername = $_GET["username"];
        } else {
            header("location: ../pages/info?error=no_login");
            exit;
        }
    }

    else {
        /* If neither of the above conditions are true, set the target username as the current
        session's username. */
        $targetUsername = $_SESSION["username"];
    }
?>

<body id="delete_account">
    <!-- Navigation bar -->
    <?php include "../scripts/incl_navbar.php";?>

    <!-- Main content -->
    <div class="content">
    <div class="card-container">
    <div class="card">
        <!-- Form to confirm account deletion -->
        <form action="../scripts/form_handler.php" method="POST">
            <h2>Delete My Data</h2>
            <p>This will erase all account and poll data related to this account?
                (Username: <b><?php echo $targetUsername;?></b>)
                <br>This action cannot be undone!</h3><br><br>
            <?php echo "<input type=\"hidden\" value=\"$targetUsername\" name=\"targetUsername\">";?>
            <input type="checkbox" id="delete_account_confirm"
                name="delete_account_confirm">
            <label for="delete_account_confirm">I wish to completely erase my account.</label><br>
            <table><div>
                <td><input class="action cancel" type="submit"
                    name="delete_account_cancel" value="Cancel"></td>
                <td><input class="danger" type="submit"
                    name="delete_account_submit" value="DELETE ACCOUNT"></td>
            </table>
        </form>
    </div>
    </div>
    </div>
    <!-- Footer -->
    <?php include "../scripts/incl_footer.php";?>
</body>
</html>
