<!DOCTYPE html>
<html>
    <head>
        <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
        <?php include "../scripts/incl_head.php";?>
        <title>PollSense &rsaquo; Manage</title>
    </head>

    <body id="manage">
        <!-- Navigation bar -->
        <?php include "../scripts/incl_navbar.php";?>

        <!-- Main content -->
        <div class="content">
            <div class="card-container">
                <div class="card">

<?php
include "../scripts/incl_db_handler.php";

if (isset($_SESSION["username"])){
    // Unpack username session variable (escaping, to prevent SQL injection) and
    // store it in the $username variable for later use in queries.
    if (isset($_GET["all-polls"])){
        if ($_SESSION["isAdmin"]){
            $usernameCondition = "";
        } else {
            header("location: ../pages/info?error=no_admin");
        }
    } else {
        $username = mysqli_real_escape_string($dbConn, $_SESSION["username"]);
        $usernameCondition = "AND users.username = \"$username\"";
    }

    // Using the provided $username in a SQL database query to find polls
    // that the user is linked to.
    $dbQuery = "SELECT polls.poll_id, polls.title, polls.mult_choice,
    SUM(options.votes) AS total_votes, users.forename FROM polls, options, users
    WHERE polls.poll_id = options.poll_id AND users.username = polls.username
    $usernameCondition GROUP BY poll_id
    HAVING COUNT(polls.poll_id) >= 1;";

    // Execute the above query, and store the result in $dbQueryResult.
    $dbQueryResult = mysqli_query($dbConn, $dbQuery);

    // Check for any MySQL errors or if zero rows are returned. If so,
    // redirect to error page.
    if (mysqli_error($dbConn)) {
        header("location: ../pages/info?error=manage");
    } elseif (mysqli_num_rows($dbQueryResult) < 1) {
        header("location: ../pages/info?error=manage--no_polls");
    } else {
        // Fetch the first poll result row, and store it in $dbQueryResultRow.
        $dbQueryResultRow = mysqli_fetch_assoc($dbQueryResult);

        if (isset($_GET["all-polls"])){
            $header = "All Polls";
        } else {
            $header = $dbQueryResultRow["forename"]."'s Polls";
        }
        echo "<form name=\"manage\" action=\"../scripts/form_handler.php\"
        method=\"post\">
        <h2>$header</h2>
        <table>";
        while ($dbQueryResultRow){
            echo "<tr>
                <td><td><input type=\"radio\" value=\"".
                $dbQueryResultRow["poll_id"]."\" required name=\"radio_poll_manage\"></td></td>
                <td><h3>".$dbQueryResultRow["title"]."</h3></td>
                <td><p>".$dbQueryResultRow["total_votes"]." votes</p></td>
            </tr>";
            $dbQueryResultRow = mysqli_fetch_assoc($dbQueryResult);
        }
        echo "
        </form>";
    }
} else {
    header("location: ../pages/info?error=manage");
}

?>

                    </table>
                    <table class="actions">
                        <td><input type="submit" name="poll_manage_view" value="View"></td>
                        <td><input type="submit" class="secondary" name="poll_manage_edit" value="Edit"></td>
                        <td><input type="submit" class="tertiary" name="poll_manage_delete" value="Delete"></td>
                    </table>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include "../scripts/incl_footer.php";?>
    </body>
</html>
