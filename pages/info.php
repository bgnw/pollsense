<!DOCTYPE html>
<html>
    <head>
        <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
        <?php include "../scripts/incl_head.php";?>
        <title>PollSense &rsaquo; Info</title>
    </head>

    <body id="info">
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
                            case "no_login":
                                $messageTitle = "Not loggged in";
                                $message = "You must be logged in to perform this action.";
                                $linkTo = "../scripts/account_redirect.php";
                                $buttonLabel = "Log In or Register";
                                break;
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
                            case "poll_vote--db_error":
                                $poll_id = $_GET["poll_id"];
                                $message = "We couldn't record your poll vote at this time, sorry.";
                                $buttonLabel = "View the poll";
                                $linkTo = "vote?poll_id=$poll_id";
                                break;
                            case "poll_report":
                                $message = "Something went wrong while reporting the poll, sorry.";
                                $linkTo = "join";
                                break;
                            case "manage":
                                $message = "We couldn't load your poll management page, sorry.";
                                $linkTo = "../scripts/account_redirect.php";
                                break;
                            case "manage--no_polls":
                                $message = "You don't have any polls connected to your account.<br><a class=\"inline-link\" href=\"create\">Try creating one now!</a>";
                                $linkTo = "user_options";
                                $buttonLabel = "Back to menu";
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
                                $message = "We couldn't delete your poll with ID: <b>$poll_id</b> at this time. Sorry.";
                                $linkTo = "manage";
                                break;
                            case "poll_delete--not_owner":
                                $poll_id = $_GET["poll_id"];
                                $messageTitle = "Not owner";
                                $message = "You are not the owner of the poll with ID: <b>$poll_id</b>, or it may not exist.";
                                $linkTo = "manage";
                                $buttonLabel = "OK";
                                break;
                            case "poll_delete--no_confirm":
                                $poll_id = $_GET["poll_id"];
                                $messageTitle = "Not confirmed";
                                $message = "We didn't delete your poll with ID: <b>$poll_id</b>, as you did not confirm you wanted to (by checking the checkbox).";
                                $linkTo = "manage";
                                break;
                            case "user_change_password":
                                $message = "Something went wrong whilst changing your password.<br>Your password has <b>not</b> been changed!";
                                $linkTo = "change_password";
                                break;
                            case "poll_report_clear":
                                $poll_id = $_GET["poll_id"];
                                $message = "Something went wrong while clearing the reports from the poll with ID: <b>$poll_id</b>, sorry.";
                                $linkTo = "reports";
                                break;
                            case "reports--no_polls":
                                $messageTitle = "No reports";
                                $message = "There are no reports to display at this time.";
                                $linkTo = "user_options";
                                $buttonLabel = "Back";
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
                                $message = "Your poll with ID: <b>$poll_id</b> has been successfully deleted.";
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
                            case "logout":
                                $messageTitle = "Logout successful";
                                $message = "You've been logged out. Hope to see you again soon.";
                                $linkTo = "./";
                                break;
                            case "poll_report_clear":
                                $poll_id = $_GET["poll_id"];
                                $message = "Reports have been cleared from the poll with ID: <b>$poll_id</b>.";
                                $linkTo = "reports";
                                break;
                            }
                    } else {
                        header("location: ./");
                    }
                    echo "<script type=\"text/javascript\">document.title = \"PollSense › $tabTitle\"</script>";
                    echo "<h2>$messageTitle</h2>
                    <p>$message</p>
                    <a class=\"action primary\" href=\"$linkTo\">$buttonLabel</a>";
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include "../scripts/incl_footer.php";?>
    </body>
</html>
