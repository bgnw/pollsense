<!DOCTYPE html>
<html lang="en">
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

if (isset($_GET["poll_id"])){
    // Unpack Poll ID field (escaping, to prevent SQL injection) and
    // store it in the $poll_id variable use in the database SELECT query.
    $poll_id = mysqli_real_escape_string($dbConn, $_GET["poll_id"]);

    // Using the above variable to prepare the database SELECT query string.
    $pollsQuery = "SELECT poll_id, title, mult_choice FROM polls
                    WHERE polls.poll_id = $poll_id;";
    $pollsQueryResult = mysqli_query($dbConn, $pollsQuery);

    if ((mysqli_error($dbConn)) or (mysqli_num_rows($pollsQueryResult) !== 1)){
        header("location: ../pages/info?error=database");
        exit;
    } else {
        $optionsQuery = "SELECT options.option_no, options.option_text,
        options.votes FROM options, polls
        WHERE polls.poll_id = options.poll_id AND polls.poll_id = $poll_id;";

        $optionsQueryResult = mysqli_query($dbConn, $optionsQuery);
        if (mysqli_error($dbConn)){
            header("location: ../pages/info?error=database");
            exit;
        } else {
            $pollsQueryResultRow = mysqli_fetch_assoc($pollsQueryResult);
            $optionsQueryResultRow = mysqli_fetch_assoc($optionsQueryResult);
            echo "<form action=\"../scripts/form_handler.php\"  method=\"POST\">
            <input type=\"hidden\" name=\"poll_id\" value=\"$poll_id\">
            <h3>".$pollsQueryResultRow["title"]."</h3>
            <h4>Poll ID: ".$pollsQueryResultRow["poll_id"]."</h4>
            <table>";
            if ($pollsQueryResultRow["mult_choice"]){
                $selectionType = "checkbox";
            } else {
                $selectionType = "radio";
            }
            $i = 0;
            while ($optionsQueryResultRow){
                $plural = "";
                if ($optionsQueryResultRow["votes"] != 1){
                    $plural = "s";
                }

                echo "<tr>
                    <td><input type=\"$selectionType\" value=\"$i\" name=\"options[]\"></td>
                    <td><label for=\"\">".$optionsQueryResultRow["option_text"]."</label></td>
                    <td>".$optionsQueryResultRow["votes"]." vote$plural</td>
                </tr>";
                $optionsQueryResultRow = mysqli_fetch_assoc($optionsQueryResult);
                $i++;
            }
        }
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    header("location: ../pages/info?error=poll_vote");
}
?>
                </table>
                <table class="actions">
                    <td><input class="secondary" type="submit" name="poll_vote_report"
                        value="Report this poll"></td>
                    <td><input type="submit" name="poll_vote_submit" value="Submit vote"></td>
                </form>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php include "../scripts/incl_footer.php";?>
</body>
</html>
