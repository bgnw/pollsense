<!DOCTYPE html>
<html lang="en">
<head>
    <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
    <?php include "../scripts/incl_head.php";?>
    <title>PollSense &rsaquo; Delete Poll</title>
</head>

<?php
// Redirect to an error page if user is not logged in.
if (!isset($_SESSION["username"])){
    header("location: ../pages/info?error=no_login");
    exit;
}
// Redirect to an error page if a poll ID was not provided.
elseif (!isset($_GET["poll_id"])){
    header("location: ../pages/info?error=no_poll_id");
    exit;
}
?>

<body id="delete_poll">
    <!-- Navigation bar -->
    <?php include "../scripts/incl_navbar.php";?>

    <!-- Main content -->
    <div class="content">
    <div class="card-container">
    <div class="card">
        <form action="../scripts/form_handler.php" method="POST">
            <?php echo "<input type=\"hidden\" name=\"poll_id\" value=".$_GET["poll_id"].">";?>
            <h2>Delete Poll</h2>
            <p>This will erase the poll. (ID: <b><?php echo $_GET["poll_id"];?></b>)
                <br>This action cannot be undone!</h3><br><br>
            <input type="checkbox" id="delete_poll_confirm" name="delete_poll_confirm" required>
            <label for="delete_poll_confirm">I wish to delete this poll.</label><br>
            <table><div>
                <td><input class="action cancel" type="submit" name="delete_poll_cancel"
                        value="Cancel"></td>
                <td><input class="action danger" type="submit" name="delete_poll_submit"
                        value="DELETE POLL"></td>
            </table>
        </form>
    </div>
    </div>
    </div>
    <!-- Footer -->
    <?php include "../scripts/incl_footer.php";?>
</body>
</html>
