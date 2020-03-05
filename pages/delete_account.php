<!DOCTYPE html>
<html>
<head>
    <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
    <?php include "../scripts/incl_head.php";?>
    <title>PollSense &rsaquo; Delete Account</title>
</head>

<?php
if (!isset($_SESSION["username"])){
header("location: ../pages/info?error=no_login");
}
?>

<body id="delete_account">
    <!-- Navigation bar -->
    <?php include "../scripts/incl_navbar.php";?>

    <!-- Main content -->
    <div class="content">
        <div class="card-container">
            <div class="card">
                <form name="delete_account" action="../scripts/form_handler.php" method="post">
                    <h2>Delete My Data</h2>
                    <p>This will erase all account and poll data related to this account? (Username: <b><?php echo $_SESSION["username"];?></b>)<br>This action cannot be undone!</h3><br><br>
                    <input type="checkbox" id="delete_account_confirm" name="delete_account_confirm">
                    <label for="delete_account_confirm">I wish to completely erase my account.</label><br>
                    <table><div>
                        <td><input class="action cancel" type="submit" name="delete_account_cancel" value="Cancel"></td>
                        <td><input class="danger" type="submit" name="delete_account_submit" value="DELETE ACCOUNT"></td>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php include "../scripts/incl_footer.php";?>
</body>
</html>
