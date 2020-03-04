<!DOCTYPE html>
<html>
    <head>
        <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
        <?php include "../scripts/incl_head.php";?>
        <title>PollSense &rsaquo; Delete Poll</title>
    </head>

<?php
if (!isset($_SESSION["username"])){
    header("location: ../pages/info?error=no_login");
} elseif (!isset($_GET["poll_id"])){
    header("location: ../pages/info?error=no_poll_id");
}
?>

    <body id="delete_poll">
        <!-- Navigation bar -->
        <?php include "../scripts/incl_navbar.php";?>

        <!-- Main content -->
        <div class="content">
            <div class="card-container">
                <div class="card">
                    <form name="delete_poll" action="../scripts/form_handler.php" method="post">
                        <?php echo "<input type=\"hidden\" name=\"poll_id\" value=".$_GET["poll_id"].">";?>
                        <h2>Delete Poll</h2>
                        <p>This will erase this poll. (ID: <b><?php echo $_GET["poll_id"];?></b>)<br>This action cannot be undone!</h3><br><br>
                        <?php if ($_SESSION["isAdmin"]){
                            echo "<i>NOTICE: <b>You are logged into an admin account</b>, so this may not be your poll.<br>Please be careful.</i><br><br>";
                        }?>
                        <input type="checkbox" id="delete_poll_confirm" name="delete_poll_confirm">
                        <label for="delete_poll_confirm">I wish to delete this poll.</label><br>
                        <table><div>
                            <td><input class="action cancel" type="submit" name="delete_poll_cancel" value="Cancel"></td>
                            <td><input class="action danger" type="submit" name="delete_poll_submit" value="DELETE POLL"></td>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include "../scripts/incl_footer.php";?>
    </body>
</html>
