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
        $reportsQuery = "SELECT poll_id, title, reports FROM polls
        WHERE reports > 0;";

        // Execute the above query, and store the result in $reportsResult.
        $reportsResult = mysqli_query($dbConn, $reportsQuery);

        // Check for any MySQL errors or if zero rows are returned. If so,
        // redirect to error page.
        if (mysqli_error($dbConn)) {
            // header("location: ../pages/info?error=reports--db_error");
        } elseif (mysqli_num_rows($reportsResult) < 1) {
            header("location: ../pages/info?error=reports--no_polls");
        } else {
            // Fetch the first poll result row, and store it in $reportsResultRow.
            $reportsResultRow = mysqli_fetch_assoc($reportsResult);
            echo "<form name=\"reports\" action=\"../scripts/form_handler.php\"
            method=\"post\">
            <table>";
            while ($reportsResultRow){
                $plural = "";
                if ($reportsResultRow["reports"] != 1){
                    $plural = "s";
                }
                echo "<tr>
                    <td><td><input type=\"radio\" value=\"".
                    $reportsResultRow["poll_id"]."\" required name=\"radio_reports\"></td></td>
                    <td><h3>".$reportsResultRow["title"]."</h3></td>
                    <td><p>".$reportsResultRow["reports"]." report$plural</p></td>
                </tr>";
                $reportsResultRow = mysqli_fetch_assoc($reportsResult);
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
                        <td><input type="submit" name="poll_report_view" value="View"></td>
                        <td><input type="submit" class="secondary" name="poll_report_clear" value="Clear reports"></td>
                        <td><input type="submit" class="tertiary" name="poll_report_delete" value="Delete"></td>
                    </form>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include "../scripts/incl_footer.php";?>
    </body>
</html>
