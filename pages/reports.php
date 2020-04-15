<!DOCTYPE html>
<html lang="en">
<head>
    <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
    <?php include "../scripts/incl_head.php";?>
    <title>PollSense &rsaquo; Reports</title>
</head>

<body id="reports">
    <!-- Navigation bar -->
    <?php include "../scripts/incl_navbar.php";?>

    <!-- Main content -->
    <div class="content">
        <div class="card-container">
            <div class="large card">

<?php
// Redirect to an error message if the user is not logged in.
if ((!isset($_SESSION["username"])) || (!isset($_SESSION["isAdmin"]))) {
    header("location: info?error=no_login");
    exit;
}
// Redirect to an error message if a non-admin tries to access this page.
elseif (!$_SESSION["isAdmin"]) {
    header("location: info?error=no_admin");
    exit;
}

include "../scripts/incl_db_handler.php";

$dbq_polls = "SELECT polls.poll_id, polls.title, polls.mult_choice,
polls.reports, SUM(options.votes) AS total_votes, polls.username
FROM polls, options
WHERE polls.poll_id = options.poll_id AND
polls.reports > 0
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
    header("location: ../pages/info?error=reports--no_polls");
    exit;
}
// Fetch the first poll result row, and store it in $dbq_polls_result_row.
$dbq_polls_result_row = mysqli_fetch_assoc($dbq_polls_result);

// Iterate through each result row and echo it to the user.
echo "<form action=\"../scripts/form_handler.php\" method=\"POST\">
<h2>Reported Polls</h2>
<table class=\"large-table\">
<thead>
<tr>
    <th></th>
    <th>ID</th>
    <th>Title</th>
    <th>Owner</th>
    <th>Multiple Choice</th>
    <th>Reports</th>
    <th>Total Votes</th>
</tr>
</thead>
<tbody>";
while ($dbq_polls_result_row) {
    echo "<tr>
        <td><input type=\"radio\" value=\"".
        $dbq_polls_result_row["poll_id"]."\" required name=\"radio_reports\"></td>
        <td><p>".$dbq_polls_result_row["poll_id"]."</p></td>
        <td><p>".$dbq_polls_result_row["title"]."</p></td>
        <td><p>";
        if ($dbq_polls_result_row["username"] == "") {
            echo "<i>No owner</i>";
        } else {
            echo "<a class=\"blue-link\" href=\"manage_polls?username=".
            $dbq_polls_result_row["username"]."\">"
            .$dbq_polls_result_row["username"]."</a>";
        }

        echo "</p></td>";

        if ($dbq_polls_result_row["mult_choice"]) {
            echo "<td><p>Yes</p></td>";
        } else {
            echo "<td><p>No</p></td>";
        }
        echo "</p></td>
        <td><p>".$dbq_polls_result_row["reports"]."</p></td>
        <td><p>".$dbq_polls_result_row["total_votes"]."</p></td>
    </tr>";
    $dbq_polls_result_row = mysqli_fetch_assoc($dbq_polls_result);
}
echo "
</table>
";


?>
                </table>
                <table>
                    <td><input type="submit" name="poll_report_view" value="View"></td>
                    <td><input type="submit" class="secondary" name="poll_report_clear"
                        value="Clear reports"></td>
                    <td><input type="submit" class="tertiary" name="poll_report_delete"
                        value="Delete"></td>
                </form>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php include "../scripts/incl_footer.php";?>
</body>
</html>
