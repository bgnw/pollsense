<!DOCTYPE html>
<html>
    <head>
        <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
        <?php include "../scripts/incl_head.php";?>
        <title>PollSense &rsaquo; Info</title>
    </head>

    <body>
        <!-- Navigation bar -->
        <?php include "../scripts/incl_navbar.php";?>

        <!-- Main content -->
        <div class="content">
            <div class="card-container">
                <div class="card">
                    <div class="infoMessage">

                    <?php
                    $message = "";
                    $linkTo = "./";
                    $buttonLabel = "Back to homepage";

                    if (isset($_GET["error"])) {
                        $error = $_GET["error"];
                        $tabTitle = "Error";
                        $messageTitle = "Uh oh!";
                        $buttonLabel = "Try again";
                        switch ($error) {
                            case "user_register":
                                $message = "Something went wrong whilst creating your account, sorry.";
                                $linkTo = "../scripts/account_redirect.php";
                                break;
                            case "user_register--username_exists":
                                $username = $_GET["username"];
                                $message = "Unfortunately, the username <b>$username</b> is already in use.<br>Please try another username.";
                                $linkTo = "../scripts/account_redirect.php";
                                break;
                            case "poll_vote":
                                $message = "We couldn't find anything that matched that Poll ID, sorry.";
                                $linkTo = "join";
                                break;
                            case "manage":
                                $message = "We couldn't load your poll management page, sorry.";
                                $linkTo = "../scripts/account_redirect.php";
                                break;
                            case "manage--no_polls":
                                $message = "You don't have any polls connected to your account.<br>Try creating one now!";
                                $linkTo = "create";
                                $buttonLabel = "Create a poll";
                                break;
                            case "user_login--db_error":
                                $message = "A database error occurred, so we couldn't log you in at this time. Sorry.";
                                $linkTo = "../scripts/account_redirect.php";
                                break;
                            case "user_login--invalid_credentials":
                                $message = "The username / password combination you provided was not valid.";
                                $linkTo = "../scripts/account_redirect.php";
                                break;
                            case "poll_create":
                                $message = "Something went wrong whilst creating your poll, sorry.";
                                $linkTo = "create";
                                break;
                            case "poll_create--invalid_username":
                                $message = "The username you provided is not valid.<br>Please use another username, or leave the field blank.";
                                $linkTo = "create";
                                break;
                            case "poll_create--malformed":
                                $message = "It looks like you missed out an option field in the middle of other options.";
                                $linkTo = "create";
                                break;
                            case "poll_delete":
                                $poll_id = $_GET["poll_id"];
                                $message = "We couldn't delete your poll with ID: $poll_id at this time. Sorry.";
                                $linkTo = "manage";
                                break;
                            case "poll_vote":
                                $message = "We couldn't record your poll_vote at this time, sorry.";
                                break;
                            case "poll_vote--db_error":
                                $poll_id = $_GET["poll_id"];
                                $message = "We couldn't record your poll_vote at this time, sorry.";
                                $buttonLabel = "View the poll";
                                $linkTo = "vote?poll_id=$poll_id";
                                break;
                            case "user_change_password":
                                $message = "Something went wrong whilst changing your password.<br>Your password has <b>not</b> been changed!";
                                $linkTo = "change_password";
                                break;
                        }

                    } else if (isset($_GET["success"])) {
                        $success = $_GET["success"];
                        $tabTitle = "Success";
                        $messageTitle = "Success!";
                        $buttonLabel = "OK";
                        switch ($success) {
                            case "user_register":
                                $username = $_GET["username"];
                                $message = "Your account was successfully created!<br>You can now log in using your username, <b>$username</b>.";
                                $linkTo = "../scripts/account_redirect.php";
                                $buttonLabel = "Log in now";
                                break;
                            case "poll_create":
                                $poll_id = $_GET["poll_id"];
                                $message = "Your poll was successfully created!<br>The Poll ID is: <b>$poll_id</b>.<br>Share this ID with others to get their opinions!";
                                $linkTo = "vote?poll_id=$poll_id";
                                $buttonLabel = "View this poll";
                                break;
                            case "poll_delete":
                                $poll_id = $_GET["poll_id"];
                                $message = "Your poll with ID: $poll_id has been successfully deleted.";
                                $linkTo = "manage";
                                break;
                            case "poll_vote":
                                $poll_id = $_GET["poll_id"];
                                $message = "Thank you for voting!<br>Your vote has been successfully recorded.";
                                $buttonLabel = "View the poll";
                                $linkTo = "vote?poll_id=$poll_id";
                                break;
                            case "user_change_password":
                                $message = "Your account password has been successfully changed.<br>You have been logged out because of this.";
                                $linkTo = "../scripts/account_redirect.php";
                                break;
                            }
                    } else {
                        header("location: ./");
                    }
                    echo "<script type=\"text/javascript\">document.title = \"PollSense › $tabTitle\"</script>";
                    echo "<h2>$messageTitle</h2>
                    <p>$message</p>
                    <a class=\"action\" href=\"$linkTo\">$buttonLabel</a>";
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include "../scripts/incl_footer.php";?>
    </body>
</html>
