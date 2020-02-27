<!DOCTYPE html>
<html>
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
                <div class="card">

<?php
include "../scripts/incl_db_handler.php";

if (isset($_SESSION["isAdmin"])){
    if ($_SESSION["isAdmin"]){
        $dbQuery = "SELECT poll_id, title, reports FROM polls
        WHERE reports > 0;";

        // Execute the above query, and store the result in $dbQueryResult.
        $dbQueryResult = mysqli_query($dbConn, $dbQuery);

        // Check for any MySQL errors or if zero rows are returned. If so,
        // redirect to error page.
        if (mysqli_error($dbConn)) {
            // header("location: ../pages/info?error=reports--db_error");
        } else if (mysqli_num_rows($dbQueryResult) < 1) {
            header("location: ../pages/info?error=reports--no_polls");
        } else {
            // Fetch the first poll result row, and store it in $dbQueryResultRow.
            $dbQueryResultRow = mysqli_fetch_assoc($dbQueryResult);
            echo "<form name=\"reports\" action=\"../scripts/form_handler.php\"
            method=\"post\">
            <table>";
            while ($dbQueryResultRow){
                $plural = "";
                if ($dbQueryResultRow["reports"] != 1){
                    $plural = "s";
                }
                echo "<tr>
                    <td><td><input type=\"radio\" value=\"".
                    $dbQueryResultRow["poll_id"]."\" required name=\"radio_reports\"></td></td>
                    <td><h3>".$dbQueryResultRow["title"]."</h3></td>
                    <td><p>".$dbQueryResultRow["reports"]." report$plural</p></td>
                </tr>";
                $dbQueryResultRow = mysqli_fetch_assoc($dbQueryResult);
            }
            echo "";
        }
    }
} else {
    header("location: ../pages/info?error=reports");
}

?>
                    </table>
                    <table>
                        <td><input type="submit" name="poll_report_view" value="View poll"></td>
                        <td><input type="submit" class="secondary" name="poll_report_clear" value="Clear reports"></td>
                        <td><input type="submit" class="tertiary" name="poll_report_delete" value="Delete poll"></td>
                    </form>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include "../scripts/incl_footer.php";?>
    </body>
</html>
