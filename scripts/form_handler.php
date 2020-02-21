<?php
// Helpful resources:
// youtu.be/qUW6GAK6CBA
// stackoverflow.com/questions/6220546/count-number-of-iterations-in-a-foreach-loop
// youtu.be/dP0KM49IVk

include "incl_db_handler.php";
session_start();

// Checks if the sent form is the "Create a Poll" form (from create).
if (isset($_POST["poll_create_submit"])){
    // Unpack the Title field (escaping, to prevent SQL injection) and store it
    // in the $title variable use in the database INSERT query.
    $title = mysqli_real_escape_string($dbConn, $_POST["title"]);

    // Unpack the Multiple choice field (converting it from boolean to 1 or 0)
    // and store it in the $mult_choice variable use in the database INSERT query.
    // The + is to convert the boolean value to its 0-1 integer equivalent value.
    $mult_choice = +isset($_POST["mult_choice"]);

    // Unpack the Username field (escaping, to prevent SQL injection), and store
    // it in the $username variable for later use.
    // Then checking if the username provided is in the users table of the
    // database, or if it is an empty string, converts it to a NULL value for
    // use in the database INSERT query.
    $username = mysqli_real_escape_string($dbConn, $_POST["username"]);
    if ($username == ""){
        $username = "NULL";
    } else {
        $dbUsernameCheck = "SELECT * FROM users WHERE username = \"$username\";";
        $dbUsernameCheck_Result = mysqli_query($dbConn, $dbUsernameCheck);
        $dbUsernameCheck_RowsReturned = mysqli_num_rows($dbUsernameCheck_Result);
        if ($dbUsernameCheck_RowsReturned === 1) {
            $username = "\"$username\"";
        } else {
            header("location: ../pages/info?error=poll_create--invalid_username");
        }
    }

    // Using the above variables to prepare the database INSERT query string for
    // the polls table.
    $dbPollsQuery = "INSERT INTO polls (title, mult_choice, username) VALUES
        (\"$title\",$mult_choice,$username);";

    // Executing the above query.
    mysqli_query($dbConn, $dbPollsQuery);

    // Checking for any returned errors from executing the above query,
    // directing users to an error page if there was an error, and continuing
    // with execution if not.
    if (mysqli_error($dbConn)){
        header("location: ../pages/info?error=poll_create");
    } else {
        // If the query executed successfully, the newly created poll_id is
        // retrieved for use in the INSERT query for the options table.
        $poll_id = mysqli_insert_id($dbConn);

        // Unpack the Option fields, and store them in an array called $options
        // for later use.
        // Then check if each option actually contains data; if it is an empty
        // string, converts it to a NULL value for use in the database query.
        // Then appends these options into to a string so that it can be used in
        // the VALUES section of the database query.
        $options = array_map(null,$_POST["opt"]);
        $option_query_string = "";

        // Checks if the form data is "malformed", e.g. a user fills out option
        // fields 1, 2, 4, and 5, but not 3. (see ongoing testing entry no. 2)
        $malformed = FALSE;
        $emptyFieldFound = FALSE;
        for ($x = 0; $x <= 9; $x++) {
            if (!$options[$x]){
                $emptyFieldFound = TRUE;
            }
            else if (($options[$x]) and $emptyFieldFound){
                $malformed = TRUE;
            }
        }

        if ($malformed){
            header("location: ../pages/info?error=poll_create--malformed");
        } else {
            $i = 0;
            foreach($options as $option){
                $i++;
                if ($option){
                    $escaped_option = mysqli_real_escape_string($dbConn, $option);
                    $option_query_string .= "($poll_id, $i,\"$escaped_option\"),";
                }
            }
            $option_query_string = rtrim($option_query_string,",");

            // Using the above option string to prepare the database INSERT query
            // string for the options table.
            $dbOptionsQuery = "INSERT INTO options (poll_id, option_no, option_text)
            VALUES $option_query_string;";

            // Executing the above query.
            mysqli_query($dbConn, $dbOptionsQuery);

            // Checking for any returned errors from executing the above query, and
            // directing users to a success / error page accordingly.
            if (mysqli_error($dbConn)){
                header("location: ../pages/info?error=poll_create");
            } else {
                header("location: ../pages/info?success=poll_create&poll_id=$poll_id");
            }
        }
    }
}

// Checks if the sent form is the "New Users" form (from register_login).
else if (isset($_POST["user_register_submit"])){
    // Unpack all form data, escaping to prevent SQL injection.
    $forename = mysqli_real_escape_string($dbConn, $_POST["forename"]);
    $surname = mysqli_real_escape_string($dbConn, $_POST["surname"]);
    $username = mysqli_real_escape_string($dbConn, $_POST["username"]);
    $password = mysqli_real_escape_string($dbConn, $_POST["password"]);

    // Prepare a database INSERT query to create a new user account.
    $dbQuery = "INSERT INTO users (forename, surname, username, password) VALUES
    (\"$forename\", \"$surname\", \"$username\", \"$password\");";

    // Execute the above query
    mysqli_query($dbConn, $dbQuery);

    // Checking for any returned errors from executing the above query, and
    // directing users to success / error pages accordingly.
    if (mysqli_error($dbConn)) {
        // If there was an error, checking if the error was that there is
        // already a user account with the provided username.
        if (strpos(mysqli_error($dbConn),"Duplicate entry") !== false){
            header("location: ../pages/info?error=user_register--username_exists&username=$username");
        } else {
            header("location: ../pages/info?error=user_register");
        }
    } else {
        header("location: ../pages/info?success=user_register&username=$username");
    }
}

// Checks if the sent form is the "Existing Users" form (from register_login).
else if (isset($_POST["user_login_submit"])){
    // Unpack all form data, escaping to prevent SQL injection.
    $username = mysqli_real_escape_string($dbConn, $_POST["username"]);
    $password = mysqli_real_escape_string($dbConn, $_POST["password"]);

    // Prepare a database SELECT query to check the user credentials.
    $dbQuery = "SELECT * FROM users WHERE username =
        \"$username\" AND password = \"$password\";";

    // Executing the query, and storing results in $dbqResult for later use.
    $dbqResult = mysqli_query($dbConn, $dbQuery);

    // Checking for any returned errors from executing the above query, and
    // directing users to success / error pages accordingly.
    if (mysqli_error($dbConn)) {
        header("location: ../pages/info?error=user_login--db_error");
    } else if ((mysqli_num_rows($dbqResult)) !== 1) {
        // header("location: ../pages/info?error=user_login--invalid_credentials");
    } else {
        $dbForenameQuery = "SELECT forename FROM users WHERE username = \"$username\"";
        $dbqForenameResult = mysqli_query($dbConn, $dbForenameQuery);
        if (mysqli_error($dbConn)) {
            header("location: ../pages/info?error=user_login--db_error");
        } else {
            $forename = (mysqli_fetch_assoc($dbqForenameResult))["forename"];
            $_SESSION["forename"] = $forename;
            $_SESSION["username"] = $username;
            header("location: ../scripts/account_redirect.php");
        }
    }
}

else if (isset($_POST["poll_vote_submit"])){
    $poll_id = mysqli_real_escape_string($dbConn, $_POST["poll_id"]);
    $option_no = mysqli_real_escape_string($dbConn, $_POST["option_no"]);

    $dbQuery = "UPDATE options SET votes = votes + 1 WHERE poll_id = $poll_id
    AND option_no = $option_no;";

    mysqli_query($dbConn, $dbQuery);

    if ((mysqli_error($dbConn)) || (mysqli_affected_rows($dbConn) != 1)) {
        header("location: ../pages/info?error=poll_vote--db_error&poll_id=$poll_id");
    } else {
        header("location: ../pages/info?success=poll_vote&poll_id=$poll_id");
    }
}

else if (isset($_POST["poll_manage_view"])){
    $poll_id = $_POST["radio_poll_manage"];
    header("location: ../pages/vote?poll_id=$poll_id");

}

else if (isset($_POST["poll_manage_edit"])){
    $poll_id = $_POST["radio_poll_manage"];
    header("location: ../pages/edit?poll_id=$poll_id");

}

else if (isset($_POST["poll_manage_delete"])){
    $poll_id = $_POST["radio_poll_manage"];
    // TODO: db query to delete poll
    if (mysqli_error($dbConn)) {
        // TODO: create related info page
        header("location: ../pages/info?error=poll_manage--delete");
    } else {
        // TODO: create related info page
        header("location: ../pages/info?success=poll_manage--delete");
    }
}

else if (isset($_POST["user_change_password_submit"])){
    if (isset($_SESSION["username"])){
        $username = $_SESSION["username"];
        $new_password = $_POST["new_password"];
        $dbQuery = "UPDATE users SET password = \"$new_password\" WHERE username = \"$username\";";
        mysqli_query($dbConn, $dbQuery);
        if (mysqli_error($dbConn)) {
            // TODO: create related info page
            echo mysqli_error($dbConn);
            header("location: ../pages/info?error=user_change_password");
        } else {
            // TODO: create related info page
            session_unset();
            session_destroy();
            header("location: ../pages/info?success=user_change_password");
        }
    } else {
        header("location: ../pages/info?error=user_change_password");
    }
}
