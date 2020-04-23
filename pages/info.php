<!DOCTYPE html>
<html lang="en">
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
        $buttonLabel = "OK";

        // Display relevant error messages, based on the GET variable provided.
        if (isset($_GET["error"])) {
            $error = $_GET["error"];
            $tabTitle = "Error";
            $messageTitle = "Uh oh!";
            $buttonLabel = "Try again";
            switch ($error) {
                case "account_delete--no_confirm":
                    $messageTitle = "Account not deleted";
                    $username = $_GET["username"];
                    $message = "The account with username <b>$username</b> wasn't deleted, as you did
                                not check the confirmation box.";
                    $linkTo = "javascript:history.back()";
                break;
                case "database":
                    $messageTitle = "Database error";
                    $message = "A database error occured while processing your request, sorry.";
                    $linkTo = "javascript:history.back()";
                    $buttonLabel = "Go back";
                break;
                case "manage_polls--no_polls":
                    $messageTitle = "No polls";
                    $message = "There aren't any polls connected to this account.<br>Create one,
                                enter your username into the 'Owner username' box, and it'll
                                display here!";
                    $linkTo = "create";
                    $buttonLabel = "Create a poll";
                break;
                case "new_admin--username_exists":
                // 'Falling through' to the next case as the messages are identical.
                case "user_register--username_exists":
                    $messageTitle = "Username in use";
                    $username = $_GET["username"];
                    $message = "The username <b>$username</b> is already in use, please choose
                                another.";
                    $linkTo = "javascript:history.back()";
                break;
                case "no_admin":
                    $messageTitle = "Admins only";
                    $message = "You must be an admin to perform this action.";
                    $linkTo = "./";
                    $buttonLabel = "OK";
                break;
                case "no_login":
                    $messageTitle = "Not logged in";
                    $message = "You must be logged in to perform this action.";
                    $linkTo = "register_login";
                    $buttonLabel = "Register or Log-in";
                break;
                case "no_poll_id":
                    $messageTitle = "No poll ID";
                    $message = "No poll ID was provided.";
                    $linkTo = "javascript:history.back()";
                break;
                case "poll_create":
                    $message = "Something went wrong while creating your poll, sorry.";
                    $linkTo = "javascript:history.back()";
                break;
                case "poll_create--invalid_username":
                // 'Falling through' to the next case as the messages are identical.
                case "poll_edit--invalid_username":
                    $messageTitle = "Invalid username";
                    $message = "The owner username you provided is invalid. Please use another,
                                or leave the field blank.";
                    $linkTo = "javascript:history.back()";
                break;
                case "poll_delete--no_confirm":
                    $messageTitle = "Poll not deleted";
                    $poll_id = $_GET["poll_id"];
                    $message = "The poll with ID <b>$poll_id</b> wasn't deleted,
                                as you did not check the confirmation box.";
                    $linkTo = "javascript:history.back()";
                break;
                case "poll_delete--not_owner":
                    $messageTitle = "Not owner";
                    $poll_id = $_GET["poll_id"];
                    $message = "You are not the owner of the poll with ID <b>$poll_id</b> so you
                                cannot delete it.";
                    $linkTo = "./";
                    $buttonLabel = "OK";
                break;
                case "poll_edit":
                    $message = "Something went wrong updating your poll changes, sorry.";
                    $linkTo = "javascript:history.back()";
                break;
                case "poll_vote--does_not_exist":
                    $messageTitle = "Poll not available";
                    $message = "This poll doesn't exist - it may have been deleted.";
                    $linkTo = "javascript:history.back()";
                    $buttonLabel = "Go back";
                break;
                case "reports--no_polls":
                    $messageTitle = "No polls";
                    $message = "There are no reported polls at the moment - horray!";
                    $linkTo = "javascript:history.back()";
                    $buttonLabel = "Go back";
                break;
                case "unrecognised_form":
                    $messageTitle = "Unrecognised form";
                    $message = "Something went wrong while trying to process your form, sorry.";
                    $linkTo = "javascript:history.back()";
                    $buttonLabel = "Go back";
                break;
                case "user_login--invalid_credentials":
                    $messageTitle = "Invalid credentials";
                    $message = "The username/password combination you provided was invalid.";
                    $linkTo = "javascript:history.back()";
                break;
                default:
                    $message = "Something went wrong while processing your request, sorry.";
                    $linkTo = "javascript:history.back()";
                    $buttonLabel = "Go back";
            }
        }

        // Display relevant success messages, based on the GET variable provided.
        elseif (isset($_GET["success"])) {
            $success = $_GET["success"];
            $tabTitle = "Success";
            $messageTitle = "Success";
            $buttonLabel = "OK";
            switch ($success) {
                case "poll_create";
                    $messageTitle = "Poll created";
                    $poll_id = $_GET["poll_id"];
                    // Provide the user with a link to their poll so they can share it with others.
                    $link = "http://".$_SERVER['HTTP_HOST']."/pollsense/pages/vote?poll_id=$poll_id";
                    $message = "Your poll was successfully created!<br>The Poll
                                ID is: <b>$poll_id</b>.<br>Share this link with others to
                                get their opinions:<br>
                                <a class=\"blue-link\" href=\"$link\">$link</p>";
                    $linkTo = "vote?poll_id=$poll_id";
                    $buttonLabel = "View this poll";
                    break;
                break;
                case "user_register";
                    $messageTitle = "Account created";
                    $username = $_GET["username"];
                    $message = "Your account was successfully created!<br>
                    You can now log in using your username, <b>$username</b>.";
                    $linkTo = "../scripts/account_redirect.php";
                    $buttonLabel = "Log in";
                    break;
                break;
                case "new_admin";
                    $messageTitle = "Admin account created";
                    $username = $_GET["username"];
                    $message = "A new admin account with the username <b>$username</b> has been
                                successfully created.";
                    $linkTo = "admin_options";
                    $buttonLabel = "Back to admin options";
                break;
                case "poll_vote";
                    $poll_id = $_GET["poll_id"];
                    $messageTitle = "Vote recorded";
                    $message = "Thanks for voting! Your vote has been successfully recorded.";
                    $linkTo = "vote?poll_id=$poll_id";
                    $buttonLabel = "View the poll again";
                break;
                case "poll_report";
                    $poll_id = $_GET["poll_id"];
                    $messageTitle = "Report logged";
                    $message = "Your report on poll ID <b>$poll_id</b> has been logged. An admin
                                will deal with it soon.";
                    $linkTo = "./";
                    $buttonLabel = "Go to homepage";
                break;
                case "poll_edit";
                    $poll_id = $_GET["poll_id"];
                    $messageTitle = "Changes updated";
                    $message = "The changes to your poll have been applied.";
                    $linkTo = "vote?poll_id=$poll_id";
                    $buttonLabel = "View the poll";
                break;
                case "poll_delete";
                    $poll_id = $_GET["poll_id"];
                    $messageTitle = "Poll deleted";
                    $message = "The poll with ID <b>$poll_id</b> has been successfully deleted.";
                    $linkTo = "user_options";
                    $buttonLabel = "Back to user options";
                break;
                case "account_delete";
                    $username = $_GET["username"];
                    $messageTitle = "Account deleted";
                    $message = "The user account with username <b>$username</b> has been
                                successfully deleted.";
                break;
                case "user_change_password";
                    $messageTitle = "Password changed";
                    $message = "The account password has been successfully changed.";
                break;
                case "poll_report_clear";
                    $poll_id = $_GET["poll_id"];
                    $messageTitle = "Reports cleared";
                    $message = "Reports for the poll with ID <b>$poll_id</b> have been cleared.";
                break;
                case "logout";
                    $messageTitle = "Logout successful";
                    $message = "You've been logged out. Hope to see you again soon!";
                    $linkTo = "../scripts/account_redirect";
                    $buttonLabel = "Go to login page";
                break;
                default:
                    $message = "The action was successful.";
                    $linkTo = "./";
            }
        }

        // If neither an error or success parameter was given, redirect to homepage.
        else {
            header("location: ./");
            exit;
        }

        // Change the tab title to error/success accordingly and display message to user.
        echo "<script type=\"text/javascript\">
        document.title = \"PollSense › $tabTitle\"</script>
        <h2>$messageTitle</h2>
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
