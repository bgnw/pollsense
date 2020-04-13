<!DOCTYPE html>
<html lang="en">
<head>
    <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
    <?php include "../scripts/incl_head.php";?>
    <title>PollSense &rsaquo; Edit Poll</title>
</head>

<?php
    // Redirect to an error page if no poll ID was provided.
    if (!isset($_GET["poll_id"])){
        header("location: ../pages/info?error=no_poll_id");
        exit;
    }
?>


<body id="edit">
    <!-- Navigation bar -->
    <?php include "../scripts/incl_navbar.php";?>

    <!-- Main content -->
    <div class="content">
        <div class="card-container">
            <div class="card">
                <form action="../scripts/form_handler.php"  method="POST">
<?php
include "../scripts/incl_db_handler.php";
/* Unpack Poll ID field (escaping, to prevent SQL injection) and
store it in the $poll_id variable use in the database SELECT query. */
$poll_id = mysqli_real_escape_string($dbConn, $_GET["poll_id"]);

// Echo a hidden input to transfer the poll ID to the form handler.
echo "<input type=\"hidden\" name=\"poll_id\" value=\"$poll_id\">
<table><tr>
<td><label for=\"title\">Title:</label></td>";

// Using the above poll ID to retrieve the poll data from the database.
$dbq_polls = "SELECT title, mult_choice, username FROM polls WHERE polls.poll_id = $poll_id;";
$dbq_polls_result = mysqli_query($dbConn, $dbq_polls);

// Check for errors and redirect to an error page if any occurred.
if ((mysqli_error($dbConn)) or (mysqli_num_rows($dbq_polls_result) !== 1)){
    header("location: ../pages/info?error=database");
    exit;
}
elseif (mysqli_num_rows($dbq_polls_result) === 1) {
    // Fetch the first row of the options query results.
    $dbq_polls_result_row = mysqli_fetch_assoc($dbq_polls_result);
    // Check if the session username matches the username of the poll owner.
    if ($_SESSION["username"] !== $dbq_polls_result_row["username"]) {
        /* If the usernames do not match, check if the current user session is
        an admin. If not, redirect to an error page. */
        if (!$_SESSION["isAdmin"]){
            header("location: ../pages/info?error=poll_edit--invalid_username");
            exit;
        }
    }
}

// Prepare and execute a query to retrieve options from the database.
$dbq_options = "SELECT options.option_text,
options.votes FROM options, polls
WHERE polls.poll_id = options.poll_id AND polls.poll_id = $poll_id;";
$dbq_options_result = mysqli_query($dbConn, $dbq_options);

// Check for errors and redirect to an error page if any occurred.
if (mysqli_error($dbConn)){
    header("location: ../pages/info?error=database");
    exit;
}

// Fetch the first row of the options query results.
$dbq_options_result_row = mysqli_fetch_assoc($dbq_options_result);

// Display the poll title.
echo "
<td><input type=\"text\" name=\"title\" value=\"".$dbq_polls_result_row["title"]."\"></td>
</table>
<table>";

/* Decide wether to display a checked or unchecked checkbox for the
multiple choice option. */
if ($dbq_polls_result_row["mult_choice"]){
    $checkboxType = "checked";
} else {
    $checkboxType = "";
}
echo "<tr>
<td><label for=\"mult_choice\">Multiple choice: </label></td>
<td><input type=\"checkbox\" name=\"mult_choice\" $checkboxType></td>";

// Iterate through all results and display the text in a textbox.
$i = 0;
while ($dbq_options_result_row){
    $plural = "";
    if ($dbq_options_result_row["votes"] != 1){
        $plural = "s";
    }

    echo "<tr>
        <td><input type=\"text\" name=\"opt[$i]\"
        value=\"".$dbq_options_result_row["option_text"]."\"></td>
        <td>".$dbq_options_result_row["votes"]." vote$plural</td>
    </tr>";
    $dbq_options_result_row = mysqli_fetch_assoc($dbq_options_result);
    $i++;
}
?>
                </table>
                <input type="submit" name="poll_edit_submit" value="Submit changes">
                </form>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php include "../scripts/incl_footer.php";?>
</body>
</html>
