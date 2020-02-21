<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
        <?php include "../scripts/incl_head.php";?>
        <title>PollSense &rsaquo; Join Poll</title>
    </head>

    <body id="join">
        <!-- Navigation bar -->
        <?php include "../scripts/incl_navbar.php";?>

        <!-- Main content -->
        <div class="content">
            <div class="card-container">
                <div class="card">
                    <!-- PHP form to load an existing poll -->
                    <form name="poll_join" action="vote" method="get">
                        <h2>Join a Poll</h2>
                        <div>
                            <input type="text" name="poll_id" maxlength="6" placeholder="Poll ID" required autofocus>
                        </div>
                        <input type="submit" value="Join Poll">
                    </form>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include "../scripts/incl_footer.php";?>
    </body>
</html>
