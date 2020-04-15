<!DOCTYPE html>
<html lang="en">
<head>
    <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
    <?php include "../scripts/incl_head.php";?>
    <title>PollSense &rsaquo; Manage Polls</title>
</head>

<body id="manage_polls">
    <!-- Navigation bar -->
    <?php include "../scripts/incl_navbar.php";?>

    <!-- Main content -->
    <div class="content">
    <div class="card-container">

<?php
if (isset($_GET["all-polls"])) {
    echo "<div class=\"large card\">";
} else {
    echo "<div class=\"card\">";
}

include "../scripts/incl_db_handler.php";

// Redirect user if they are not logged in.
if (!isset($_SESSION["username"]) || !isset($_SESSION["isAdmin"])) {
    header("location: ../scripts/account_redirect.php");
    exit;
}

// Check if a username is provided as a GET variable (for admin use only)
if (isset($_GET["username"])) {
    // Verify admin status
    if ($_SESSION["isAdmin"]) {
        $usernameCondition = "AND polls.username = \"".$_GET["username"]."\"";
    } else {
        header("location: ../pages/info?error=no_admin");
        exit;
    }
}

// Check if the "all-polls" GET variable was sent (for admin use only)
elseif (isset($_GET["all-polls"])) {
    // Verify admin status
    if ($_SESSION["isAdmin"]) {
        $usernameCondition = "";
    } else {
        header("location: ../pages/info?error=no_admin");
        exit;
    }
}

/* If neither of the two above conditions are met, show the polls of the
current session's user. */
else {
    // Prepare a condition to show only the polls that a user owns.
    $usernameCondition = "AND polls.username = \"".$_SESSION["username"]."\"";
}

// Query the database to retrieve relevant poll data.
$dbq_polls = "SELECT polls.poll_id, polls.title, polls.mult_choice,
SUM(options.votes) AS total_votes, polls.username FROM polls, options
WHERE polls.poll_id = options.poll_id
$usernameCondition
GROUP BY polls.poll_id
HAVING COUNT(polls.poll_id) >= 1;";

$dbq_polls_result = mysqli_query($dbConn, $dbq_polls);

// Check for any MySQL errors or if zero rows are returned. If so,
// redirect to error page.
if (mysqli_error($dbConn)) {
    echo mysqli_error($dbConn);
    die;
    header("location: ../pages/info?error=database");
    exit;
} elseif (mysqli_num_rows($dbq_polls_result) < 1) {
    header("location: ../pages/info?error=manage_polls--no_polls");
    exit;
}
// Fetch the first poll result row, and store it in $dbq_polls_result_row.
$dbq_polls_result_row = mysqli_fetch_assoc($dbq_polls_result);

if (isset($_GET["all-polls"])) {
    $header = "All Polls";
}
elseif (isset($_GET["username"])) {
    $header = $_GET["username"]."'s Polls";
} else {
    $header = "Your Polls";
}

// Iterate through each result row and echo it to the user.
echo "<form action=\"../scripts/form_handler.php\" method=\"POST\">
<h2>$header</h2>
<table class=\"large-table\">
<thead>
<tr>
    <th></th>
    <th>ID</th>
    <th>Title</th>";
if (isset($_GET["all-polls"])) {
    echo "<th>Owner</th>";
}
echo "<th>Multiple Choice</th>
    <th>Total Votes</th>
</tr>
</thead>
<tbody>";
while ($dbq_polls_result_row) {
    echo "<tr>
        <td><input type=\"radio\" value=\"".
        $dbq_polls_result_row["poll_id"]."\" required name=\"radio_poll_manage\"></td>
        <td><p>".$dbq_polls_result_row["poll_id"]."</p></td>
        <td><p>".$dbq_polls_result_row["title"]."</p></td>";
        if (isset($_GET["all-polls"])) {
            echo "<td><p>";
            if ($dbq_polls_result_row["username"] == "") {
                echo "<i>No owner</i>";
            } else {
                echo "<a class=\"blue-link\" href=\"manage_polls?username=".
                $dbq_polls_result_row["username"]."\">"
                .$dbq_polls_result_row["username"]."</a>";
            }
            echo "</p></td>";
        }

        if ($dbq_polls_result_row["mult_choice"]) {
            echo "<td><p>Yes</p></td>";
        } else {
            echo "<td><p>No</p></td>";
        }
        echo "</p></td>
        <td><p>".$dbq_polls_result_row["total_votes"]."</p></td>
    </tr>";
    $dbq_polls_result_row = mysqli_fetch_assoc($dbq_polls_result);
}
echo "
</table>
";
?>
        <table class="actions">
            <td><input type="submit" name="poll_manage_view" value="View"></td>
            <td><input type="submit" class="secondary" name="poll_manage_edit" value="Edit"></td>
            <td><input type="submit" class="tertiary" name="poll_manage_delete" value="Delete"></td>
        </table>
        </form>
    </div>
    </div>
    </div>
    <!-- Footer -->
    <?php include "../scripts/incl_footer.php";?>
</body>
</html>
