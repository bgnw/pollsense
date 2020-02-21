<!DOCTYPE html>
<html>
    <head>
        <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
        <?php include "../scripts/incl_head.php";?>
        <title>PollSense &rsaquo; View & Vote</title>
    </head>

    <body id="vote">
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
                echo "<form name=\"poll_vote\" action=\"../scripts/form_handler.php\"  method=\"POST\">
                <input type=\"hidden\" name=\"poll_id\" value=\"$poll_id\">
                <h3>".$dbPollsQueryResultRow["title"]."</h3>
                <table>";
                // TODO implement mult. choice
                echo "<h4 style=\"font-style:normal;font-size:14pt;color:#5a86f2;\">Multiple choice: ";
                if ($dbPollsQueryResultRow["mult_choice"]){
                    echo "TRUE</h4><br>";
                } else {
                    echo "FALSE</h4><br>";
                }
                $i = 1;
                while ($dbOptionsQueryResultRow){
                    $plural = "";
                    if ($dbOptionsQueryResultRow["votes"] != 1){
                        $plural = "s";
                    }

                    echo "<tr>
                        <td><input type=\"radio\" value=\"$i\" name=\"option_no\"></td>
                        <td><label for=\"\">".$dbOptionsQueryResultRow["option_text"]."</label></td>
                        <td>".$dbOptionsQueryResultRow["votes"]." vote$plural</td>
                    </tr>";
                    $dbOptionsQueryResultRow = mysqli_fetch_assoc($dbOptionsQueryResult);
                    $i++;
                }
                echo "</table>
                <input type=\"submit\" name=\"poll_vote_submit\" value=\"Submit vote\">
                </form>";
            }
        }
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    header("location: ../pages/info?error=poll_vote");
}
?>

                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include "../scripts/incl_footer.php";?>
    </body>
</html>
