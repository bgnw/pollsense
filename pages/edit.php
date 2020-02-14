<!DOCTYPE html>
<html>
    <head>
        <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
        <?php include "../scripts/incl_head.php";?>
        <title>PollSense &rsaquo; Edit Poll</title>
    </head>

    <body id="edit">
        <!-- Navigation bar -->
        <?php include "../scripts/incl_navbar.php";?>

        <!-- Main content -->
        <div class="content">
            <div class="card-container">
                <div class="card">
<?php
include "../scripts/incl_db_handler.php";
try {
    if (isset($_GET["poll_id"])){
        // Unpack Poll ID field (escaping, to prevent SQL injection) and
        // store it in the $poll_id variable use in the database SELECT query.
        $poll_id = mysqli_real_escape_string($dbConn, $_GET["poll_id"]);

        // Using the above variable to prepare the database SELECT query string.
        $dbPollsQuery = "SELECT title, mult_choice FROM polls WHERE polls.poll_id = $poll_id;";
        $dbPollsQueryResult = mysqli_query($dbConn, $dbPollsQuery);

        if ((mysqli_error($dbConn)) or (mysqli_num_rows($dbPollsQueryResult) !== 1)){
            throw new Exception();
        } else {
            $dbOptionsQuery = "SELECT options.option_no, options.option_text,
            options.votes FROM options, polls
            WHERE polls.poll_id = options.poll_id AND polls.poll_id = $poll_id;";

            $dbOptionsQueryResult = mysqli_query($dbConn, $dbOptionsQuery);

            if (mysqli_error($dbConn)){
                throw new Exception();
            } else {
                $dbPollsQueryResultRow = mysqli_fetch_assoc($dbPollsQueryResult);
                $dbOptionsQueryResultRow = mysqli_fetch_assoc($dbOptionsQueryResult);
                echo "<form name=\"poll_edit\" action=\"../scripts/form_handler.php\"  method=\"POST\">
                <input type=\"hidden\" name=\"poll_id\" value=\"$poll_id\">
                <table><tr>
                <td><label for=\"title\">Title: </label></td>
                <td><input type=\"text\" name=\"title\" value=\"".$dbPollsQueryResultRow["title"]."\"></td>
                </table>
                <table>";
                // TODO implement mult. choice

                if ($dbPollsQueryResultRow["mult_choice"]){
                    $checked_value = "checked";
                } else {
                    $checked_value = "";
                }
                echo "<tr>
                <td><label for=\"mult_choice\">Multiple choice: </label></td>
                <td><input type=\"checkbox\" name=\"mult_choice\" $checked_value></td>";
                $i = 1;
                while ($dbOptionsQueryResultRow){
                    $plural = "";
                    if ($dbOptionsQueryResultRow["votes"] != 1){
                        $plural = "s";
                    }

                    echo "<tr>
                        <td><input type=\"text\" name=\"option_$i\" value=\"".$dbOptionsQueryResultRow["option_text"]."\"></td>
                        <td>".$dbOptionsQueryResultRow["votes"]." vote$plural</td>
                    </tr>";
                    $dbOptionsQueryResultRow = mysqli_fetch_assoc($dbOptionsQueryResult);
                    $i++;
                }
                echo "</table>
                <input type=\"submit\" name=\"poll_edit_submit\" value=\"Submit changes\">
                </form>";
            }
        }
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    // echo "<script type=\"text/javascript\">document.location = \"../pages/info.php?error=poll_edit\";</script>";
}
?>

                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include "../scripts/incl_footer.php";?>
    </body>
</html>
