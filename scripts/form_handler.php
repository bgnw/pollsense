<!-- Headers -->
<meta charset="utf-8">
<link rel="icon" type="image/png" sizes="32x32" href="../assets/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="../assets/favicons/favicon-16x16.png">

<!-- User message, to show while processing form. -->
<title>PollSense &rsaquo; Processing...</title>
<h2 style="font-family: sans-serif">Processing your query...<br></h2>
<p><i>You should be redirected from this page within a few seconds.<br>
    If not, something went wrong.</i></p><hr><br>

<?php
include "incl_db_handler.php";
if(!isset($_SESSION)) {session_start();}

// Check if the sent form is the form on create.php.
if (isset($_POST["poll_create_submit"])) {
    /* Escape the form data to prevent SQL injection and store in respective
    variables.
    Note: When setting $mult_choice, the "+" before "isset" is used to convert
    the boolean value into its 0-1 integer equivalent value. */
    $title = mysqli_real_escape_string($dbConn, $_POST["title"]);
    $mult_choice = +isset($_POST["mult_choice"]);
    $username = mysqli_real_escape_string($dbConn, $_POST["username"]);

    /* Perform a check against the database to see if the provided owner username
    exists in the database, redirect to an error page if not. */
    if ($username === "") {
        $username = "NULL";
    } else {
        $dbq_usernameCheck = "SELECT * FROM users WHERE username = \"$username\";";
        $dbq_usernameCheck_result = mysqli_query($dbConn, $dbq_usernameCheck);
        if (mysqli_error($dbConn)) {
            header("location: ../pages/info?error=database");
            exit;
        }
        elseif (mysqli_num_rows($dbq_usernameCheck_result) !== 1) {
            header("location: ../pages/info?error=poll_create--invalid_username");
            exit;
        }
        else {
            mysqli_free_result($dbq_usernameCheck_result);
            $username = "\"$username\"";
        }
    }

    /* Using the above variables to prepare the database INSERT query string for
    the polls table. */
    $dbq_poll = "INSERT INTO polls (title, mult_choice, username) VALUES
        (\"$title\",$mult_choice,$username);";

    // Executing the above query.
    mysqli_query($dbConn, $dbq_poll);

    /* Checking for any returned errors from executing the above query,
    directing users to an error page if there was an error, and continuing
    with execution if not. */
    if (mysqli_error($dbConn)) {
        header("location: ../pages/info?error=database");
        exit;
    }

    /* If the query executed successfully, the newly created poll_id is
    retrieved for use in the INSERT query for the options table. */
    $poll_id = mysqli_insert_id($dbConn);

    /* Check if each option actually contains data; if it is an empty
    string, skips the option and decrements $i so options are in order, with no
    gaps.
    If not empty, escapes option text and prepares a string to be appended.
    Then, appends these options onto to a string so that it can be used in
    the VALUES section of the database INSERT query. */
    $i = 0;
    $option_query_string = "";
    foreach($_POST["opt"] as $option) {
        if ($option !== "") {
            $escaped_option = mysqli_real_escape_string($dbConn, $option);
            $option_query_string .= "($poll_id, $i,\"$escaped_option\"),";
            $i++;
        } elseif ($option === "") {
            $i--;
        } else {
            header("location: ../pages/info?error=poll_create");
            exit;
        }
    }
    $option_query_string = rtrim($option_query_string,",");

    /* Using the above option string to prepare the database INSERT query
    string for the options table. */
    $dbq_options = "INSERT INTO options (poll_id, option_no, option_text)
    VALUES $option_query_string;";

    // Executing the above query.
    mysqli_query($dbConn, $dbq_options);

    /* Checking for any returned errors from executing the above query, and
    directing users to a success / error page accordingly. */
    if (mysqli_error($dbConn)) {
        header("location: ../pages/info?error=database");
        exit;
    } else {
        header("location: ../pages/info?success=poll_create&poll_id=$poll_id");
        exit;
    }
}

// Check if the sent form is the "New Users" form (from register_login.php).
elseif (isset($_POST["user_register_submit"])) {
    /* Escape the form data to prevent SQL injection and store in respective
    variables. */
    $forename = mysqli_real_escape_string($dbConn, $_POST["forename"]);
    $surname = mysqli_real_escape_string($dbConn, $_POST["surname"]);
    $username = mysqli_real_escape_string($dbConn, $_POST["username"]);
    $password = mysqli_real_escape_string($dbConn, $_POST["password"]);

    // Prepare a database INSERT query to create the new user account.
    $dbq_NewUser = "INSERT INTO users (forename, surname, username, password, admin) VALUES
    (\"$forename\", \"$surname\", \"$username\", \"$password\", 0);";

    // Execute the above query.
    mysqli_query($dbConn, $dbq_NewUser);

    // Unset sensitive data, as it is no longer needed.
    unset($password, $_POST, $dbq_NewUser);

    /* Checking for any returned errors from executing the above query, and
    directing users to success / error pages accordingly. */
    if (mysqli_error($dbConn)) {
        /* If there was an error, checking if the error was that there a
        user account already exists with the provided username. */
        if (strpos(mysqli_error($dbConn),"Duplicate entry") !== false) {
            header("location: ../pages/info?error=user_register--username_exists&username=$username");
            exit;
        } else {
            header("location: ../pages/info?error=database");
            exit;
        }
    } else {
        header("location: ../pages/info?success=user_register&username=$username");
        exit;
    }
}

// Check if the sent form is the "New Users" form (from register_login.php).
elseif (isset($_POST["new_admin_submit"])) {
    /* Escape the form data to prevent SQL injection and store in respective
    variables. */
    $forename = mysqli_real_escape_string($dbConn, $_POST["forename"]);
    $surname = mysqli_real_escape_string($dbConn, $_POST["surname"]);
    $username = mysqli_real_escape_string($dbConn, $_POST["username"]);
    $password = mysqli_real_escape_string($dbConn, $_POST["password"]);

    // Prepare a database INSERT query to create the new user account.
    $dbq_NewAdmin = "INSERT INTO users (forename, surname, username, password, admin) VALUES
    (\"$forename\", \"$surname\", \"$username\", \"$password\", 1);";

    // Execute the above query.
    mysqli_query($dbConn, $dbq_NewAdmin);

    // Unset sensitive data, as it is no longer needed.
    unset($password, $_POST, $dbq_NewAdmin);

    /* Checking for any returned errors from executing the above query, and
    directing users to success / error pages accordingly. */
    if (mysqli_error($dbConn)) {
        /* If there was an error, checking if the error was that there a
        user account already exists with the provided username. */
        if (strpos(mysqli_error($dbConn),"Duplicate entry") !== false) {
            header("location: ../pages/info?error=new_admin--username_exists&username=$username");
            exit;
        } else {
            header("location: ../pages/info?error=database");
            exit;
        }
    } else {
        header("location: ../pages/info?success=new_admin&username=$username");
        exit;
    }
}

// Check if the sent form is the "Existing Users" form (from register_login.php).
elseif (isset($_POST["user_login_submit"])) {
    /* Escape the form data to prevent SQL injection and store in respective
    variables. */
    $username = mysqli_real_escape_string($dbConn, $_POST["username"]);
    $password = mysqli_real_escape_string($dbConn, $_POST["password"]);

    // Prepare a database SELECT query to check the user credentials.
    $dbq_user = "SELECT * FROM users WHERE username =
        \"$username\" AND password = \"$password\";";

    // Executing the query, and storing results in $dbqResult for later use.
    $dbq_user_result = mysqli_query($dbConn, $dbq_user);

    // Unset sensitive data, as it is no longer needed.
    unset($password, $_POST, $dbq_user);

    // Checking for any returned errors from executing the above query, and
    // directing users to success / error pages accordingly.
    if (mysqli_error($dbConn)) {
        mysqli_free_result($dbq_user_result);
        header("location: ../pages/info?error=database");
        exit;
    } elseif ((mysqli_num_rows($dbq_user_result)) !== 1) {
        mysqli_free_result($dbq_user_result);
        header("location: ../pages/info?error=user_login--invalid_credentials");
        exit;
    } else {
        $dbq_user_result_row = mysqli_fetch_assoc($dbq_user_result);
        $_SESSION["isAdmin"] = boolval($dbq_user_result_row["admin"]);
        $_SESSION["forename"] = $dbq_user_result_row["forename"];
        $_SESSION["username"] = $dbq_user_result_row["username"];
        mysqli_free_result($dbq_user_result);
        header("location: ../scripts/account_redirect.php");
        exit;
    }
}

// Check if the sent form is the "Submit Vote" button from the form on vote.php.
elseif (isset($_POST["poll_vote_submit"])) {
    /* Escape the form data to prevent SQL injection and store in respective
    variables. */
    $poll_id = mysqli_real_escape_string($dbConn, $_POST["poll_id"]);

    /* Prepare database UPDATE queries to increment the vote count by one for
    each option the user selected. */
    $dbq_vote = "";
    foreach($_POST["options"] as $option) {
        $option = mysqli_real_escape_string($dbConn, $option);
        $dbq_vote .= "UPDATE options SET votes = votes + 1 WHERE poll_id =
            $poll_id AND option_no = $option; ";
    }

    // Execute the above queries.
    mysqli_multi_query($dbConn, $dbq_vote);

    /* Check for any errors returned from the query, or if the number of updated
    rows is not the same as the amount of options selected by the user.
    Then, redirect to success / error page as appropriate. */
    if ((mysqli_error($dbConn))) {
        header("location: ../pages/info?error=database");
        exit;
    } else {
        header("location: ../pages/info?success=poll_vote&poll_id=$poll_id");
        exit;
    }
}

// Check if the sent form is the "Report Poll" button from the form on vote.php.
elseif (isset($_POST["poll_vote_report"])) {
    // Retrieve poll ID from form.
    $poll_id = mysqli_real_escape_string($dbConn, $_POST["poll_id"]);

    /* Prepare database UPDATE query to increment number of reports on
    appropriate query by one. */
    $dbq_report = "UPDATE polls SET reports = reports + 1 WHERE poll_id = $poll_id;";

    // Execute the above query.
    mysqli_query($dbConn, $dbq_report);

    // Checking for any returned errors from executing the above query, and
    // directing users to success / error pages accordingly.
    if ((mysqli_error($dbConn)) || (mysqli_affected_rows($dbConn) !== 1)) {
        header("location: ../pages/info?error=database");
        exit;
    } else {
        header("location: ../pages/info?success=poll_report&poll_id=$poll_id");
        exit;
    }
}

// Check if the user clicked "View" on the manage_polls.php page.
elseif (isset($_POST["poll_manage_view"])) {
    $poll_id = $_POST["radio_poll_manage"];
    header("location: ../pages/vote?poll_id=$poll_id");
    exit;
}

// Check if the user clicked "Edit" on the manage_polls.php page.
elseif (isset($_POST["poll_manage_edit"])) {
    $poll_id = $_POST["radio_poll_manage"];
    header("location: ../pages/edit?poll_id=$poll_id");
    exit;
}

// Check if the sent form is the form on edit.php
elseif (isset($_POST["poll_edit_submit"])) {
    /* Escape the form data to prevent SQL injection and store in respective
    variables.
    Note: When setting $mult_choice, the "+" before "isset" is used to convert
    the boolean value into its 0-1 integer equivalent value. */
    $poll_id = mysqli_real_escape_string($dbConn, $_POST["poll_id"]);
    $title = mysqli_real_escape_string($dbConn, $_POST["title"]);
    $mult_choice = +isset($_POST["mult_choice"]);

    /* Perform a check against the database to see if the provided username
    exists in the database, redirect to an error page if not. */
    $dbq_usernameCheck = "SELECT username FROM polls WHERE poll_id = $poll_id;";
    $dbq_usernameCheck_result = mysqli_query($dbConn, $dbq_usernameCheck);
    if (mysqli_error($dbConn)) {
        mysqli_free_result($dbq_usernameCheck_result);
        header("location: ../pages/info?error=database");
        exit;
    }
    elseif (mysqli_num_rows($dbq_usernameCheck_result) === 1) {
        $db_username = (mysqli_fetch_assoc($dbq_usernameCheck_result))["username"];
        if ($_SESSION["username"] === $db_username || $_SESSION["isAdmin"]) {
            mysqli_free_result($dbq_usernameCheck_result);
            $username = "\"$db_username\"";
        }
        else {
            mysqli_free_result($dbq_usernameCheck_result);
            header("location: ../pages/info?error=poll_edit--invalid_username");
            exit;
        }
    }
    else {
        mysqli_free_result($dbq_usernameCheck_result);
        header("location: ../pages/info?error=poll_edit--invalid_username");
        exit;
    }

    /* Using the above variables to prepare the database INSERT query string for
    the polls table. */
    $dbq_poll = "UPDATE polls
    SET title = \"$title\", mult_choice = $mult_choice, username = $username
    WHERE poll_id = $poll_id;";

    // Executing the above query.
    mysqli_query($dbConn, $dbq_poll);

    /* Checking for any returned errors from executing the above query,
    directing users to an error page if there was an error, and continuing
    with execution if not. */
    if (mysqli_error($dbConn)) {
        header("location: ../pages/info?error=database");
        exit;
    }

    /* Check if each option actually contains data; if it is an empty
    string, skips the option and decrements $i so options are in order, with no
    gaps.
    If not empty, escapes option text and prepares a string to be appended.
    Then, appends these options onto to a string so that it can be used in
    the VALUES section of the database INSERT query. */
    $i = 0;
    $dbq_options = "";
    foreach($_POST["opt"] as $option) {
        if ($option !== "") {
            $escaped_option = mysqli_real_escape_string($dbConn, $option);
            $dbq_options .= "UPDATE options
            SET option_text = \"$escaped_option\"
            WHERE poll_id = $poll_id AND option_no = $i; ";
            $i++;
        } elseif ($option === "") {
            $i--;
        } else {
            header("location: ../pages/info?error=poll_edit");
            exit;
        }
    }

    // Executing the above queries.
    mysqli_multi_query($dbConn, $dbq_options);

    /* Checking for any returned errors from executing the above queries, and
    directing users to a success / error page accordingly. */
    if (mysqli_error($dbConn)) {
        header("location: ../pages/info?error=database");
        exit;
    } else {
        header("location: ../pages/info?success=poll_edit&poll_id=$poll_id");
        exit;
    }
}

// Check if the user clicked "Delete" on the manage_polls.php page.
elseif (isset($_POST["poll_manage_delete"])) {
    header("location: ../pages/delete_poll?poll_id=".$_POST["radio_poll_manage"]);
    exit;
}

// Check if the user clicked "Cancel" on the poll delete confirmation page.
elseif (isset($_POST["delete_poll_cancel"])) {
    header("location: ../pages/user_options");
    exit;
}

// Check if the user clicked "DELETE POLL" on the poll delete confirmation page.
elseif (isset($_POST["delete_poll_submit"])) {
    /* Escape the form data to prevent SQL injection and store in respective
    variables. */
    $poll_id = mysqli_real_escape_string($dbConn, $_POST["poll_id"]);
    $confirm = $_POST["delete_poll_confirm"];
    $username = $_SESSION["username"];

    // Check if the user ticked the "confirm delete" tickbox.
    if ($confirm) {
        // Query the database to find who owns the poll.
        $dbq_pollOwner = "SELECT username FROM polls WHERE poll_id=\"$poll_id\"";
        $dbq_pollOwner_result = mysqli_query($dbConn, $dbq_pollOwner);

        /* If an error occurred while executing the query above, redirect the
        user to an error page. Otherwise, continue with execution. */
        if (mysqli_error($dbConn)) {
            // TODO: create related info page
            mysqli_free_result($dbq_pollOwner_result);
            header("location: ../pages/info?error=database");
            exit;
        }

        // Extract the owner's username from the query result.
        $owner = (mysqli_fetch_assoc($dbq_pollOwner_result))["username"];

        /* Check if the owner's username matches the username of the person
        currently logged in, or if the current user is an admin. */
        if ($username === $owner || $_SESSION["isAdmin"]) {
            /* Prepare and execute a DELETE query to remove the poll and its
            options (using the ON DELETE CASCATE property). */
            $dbQueryPolls = "DELETE FROM polls WHERE poll_id = $poll_id;";
            mysqli_query($dbConn, $dbQueryPolls);
            // Redirect user to success/error pages accordingly.
            if (mysqli_error($dbConn) || mysqli_affected_rows($dbConn) !== 1) {
                mysqli_free_result($dbq_pollOwner_result);
                header("location: ../pages/info?error=database");
                exit;
            } else {
                mysqli_free_result($dbq_pollOwner_result);
                // TODO: create related info page
                header("location: ../pages/info?success=poll_delete&poll_id=$poll_id");
                exit;
            }
        } else {
            mysqli_free_result($dbq_pollOwner_result);
            header("location: ../pages/info?error=poll_delete--not_owner&poll_id=$poll_id");
            exit;
        }
    } else {
        header("location: ../pages/info?error=poll_delete--no_confirm&poll_id=$poll_id");
        exit;
    }
}

// Check if the sent form is the form on delete_account.php.
elseif (isset($_POST["delete_account_submit"])) {
    $targetUsername = mysqli_real_escape_string($dbConn, $_POST["targetUsername"]);
    $confirm = $_POST["delete_account_confirm"];
    // Check if the user ticked the confirmation tickbox.
    if ($confirm) {
        /* Prepare a DELETE query to remove all user data and the polls they
        have made. */
        $dbQuery = "DELETE FROM users WHERE username = \"$targetUsername\";";
        mysqli_query($dbConn, $dbQuery);
        // Check for errors and redirect to success/error pages accordingly.
        if (mysqli_error($dbConn) || mysqli_affected_rows($dbConn) !== 1) {
            // TODO: create related info page
            header("location: ../pages/info?error=database");
            exit;
        } else {
            /* If the password change was for the user that is currently logged in,
            log them out. */
            if ($_SESSION["username"] === $targetUsername) {
                session_unset();
                session_destroy();
            }
            header("location: ../pages/info?success=account_delete&username=$targetUsername");
            exit;
        }
    } else {
        header("location: ../pages/info?error=account_delete--no_confirm&username=$username");
        exit;
    }
}

elseif (isset($_POST["delete_account_cancel"])) {
    header("location: ../pages/user_options");
    exit;
}

// Check if the sent form is the form on change_password.php.
elseif (isset($_POST["user_change_password_submit"])) {
    // Store the target user's username, after escape.
    $username = mysqli_real_escape_string($dbConn, $_POST["username"]);
    // Escape new password from form and store in $new_password.
    $new_password = mysqli_real_escape_string($dbConn, $_POST["new_password"]);
    // Prepare and execute UPDATE query to change the user's password.
    $dbQuery = "UPDATE users SET password = \"$new_password\"
        WHERE username = \"$username\";";
    mysqli_query($dbConn, $dbQuery);
    /* Check for database errors and how many rows were affected, and
    redirect to an error page if needed. */
    if (mysqli_error($dbConn) || mysqli_affected_rows($dbConn) !== 1) {
        header("location: ../pages/info?error=database");
        exit;
    /* If the query was successful, log the user out, and redirect them to
    a success page. */
    } else {
        /* If the password change was for the user that is currently logged in,
        log them out. */
        if ($_SESSION["username"] === $username) {
            session_unset();
            session_destroy();
        }
        header("location: ../pages/info?success=user_change_password");
        exit;
    }
}

// Check if the (admin) user clicked "View poll" on the reports.php page.
elseif (isset($_POST["poll_report_view"])) {
    header("location: ../pages/vote?poll_id=".$_POST["radio_reports"]);
    exit;
}

// Check if the (admin) user clicked "Clear reports" on the reports.php page.
elseif (isset($_POST["poll_report_clear"])) {
    // Get the selected poll ID.
    $poll_id = $_POST["radio_reports"];
    /* Prepare and execute a query to change the report count of the selected
    poll to zero. */
    $dbq_clearReports = "UPDATE polls SET reports = 0 WHERE poll_id = $poll_id";
    mysqli_query($dbConn, $dbq_clearReports);

    // Check for errors and redirect to success/error pages accordingly.
    if (mysqli_error($dbConn) or mysqli_affected_rows($dbConn) !== 1) {
        header("location: ../pages/info?error=database");
        exit;
    } else {
        header("location: ../pages/info?success=poll_report_clear&poll_id=$poll_id");
        exit;
    }
}

// Check if the (admin) user clicked "Delete poll" on the reports.php page.
elseif (isset($_POST["poll_report_delete"])) {
    header("location: ../pages/delete_poll?poll_id=".$_POST["radio_reports"]);
    exit;
}
// Check if the (admin) user clicked "View polls" on the manage_users.php page.
elseif (isset($_POST["user_manage_view_polls"])) {
    header("location: ../pages/manage_polls?username=".$_POST["radio_user_manage"]);
    exit;
}

// Check if the (admin) user clicked "Change password" on the manage_users.php page.
elseif (isset($_POST["user_manage_change_password"])) {
    header("location: ../pages/change_password?username=".$_POST["radio_user_manage"]);
    exit;
}

// Check if the (admin) user clicked "Delete account" on the manage_users.php page.
elseif (isset($_POST["user_manage_delete_account"])) {
    header("location: ../pages/delete_account?username=".$_POST["radio_user_manage"]);
    exit;
}

// If none of the above conditions were met, redirect the user to an error page.
else {
    header("location: ../pages/info?error=unrecognised_form");
    exit;
}
