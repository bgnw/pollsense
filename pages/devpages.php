<!DOCTYPE html>
<html>
    <head>
        <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
        <?php include "../scripts/incl_head.php";?>
        <title>PollSense &rsaquo; Dev Pages</title>
    </head>

    <body style="background-color: #222; background-image: none;">
        <!-- Navigation bar -->
        <?php include "../scripts/incl_navbar.php";?>

        <!-- Main content -->
        <div class="content" style="color: white;">
            <div class="card-container">
                <div class="card" style="width: 100%;white-space: nowrap;box-shadow: none; background-color: #222;">
                    <h2>Development Pages</h2>
                    <h3>vote.php</h3><br>
                    <a class="action" href="vote.php">no params</a>
                    <a class="action" href="vote.php?poll_id=999">invalid poll_id</a>
                    <a class="action" href="vote.php?poll_id=1">valid poll_id</a>
                    <br><br><h3>info.php - error pages</h3><br>
                    <a class="action" href="info.php">fallback</a>
                    <a class="action" href="info.php?error=user_register">user_register</a>
                    <a class="action" href="info.php?error=user_register--username_exists&username=sample_user">user_register--username_exists</a>
                    <a class="action" href="info.php?error=poll_vote">vote</a><br><br><br>
                    <a class="action" href="info.php?error=manage">manage</a>
                    <a class="action" href="info.php?error=user_login--db_error">user_login--db_error</a>
                    <a class="action" href="info.php?error=user_login--invalid_credentials">user_login--invalid_credentials</a><br><br><br>
                    <a class="action" href="info.php?error=poll_create">poll_create</a>
                    <a class="action" href="info.php?error=poll_create--invalid_username">poll_create--invalid_username</a>
                    <a class="action" href="info.php?error=poll_delete">poll_delete</a>
                    <br><br><h3>info.php - success pages</h3><br>
                    <a class="action" href="info.php?success=user_register&username=sample_user">user_register</a>
                    <a class="action" href="info.php?success=user_login">user_login</a>
                    <a class="action" href="info.php?success=poll_create&poll_id=1">poll_create</a>
                    <a class="action" href="info.php?success=poll_delete">poll_delete</a>
                    <br><br><h3>manage.php</h3><br>
                    <a class="action" href="manage.php">no params</a>
                    <a class="action" href="manage.php?username=alice.adams">alice.adams</a>
                    <a class="action" href="manage.php?username=bob.bennett">bob.bennett</a>
                    <a class="action" href="manage.php?username=charlie.cook">charlie.cook</a>
                    <br><br>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include "../scripts/incl_footer.php";?>
    </body>
</html>
