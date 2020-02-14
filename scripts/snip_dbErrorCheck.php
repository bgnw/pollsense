<?php
if (mysqli_error($dbConn)) {
    echo $errorMessage;
}
// optional - for queries that return rows
else if (($dbQueryResultNum = mysqli_num_rows($dbQueryResult)) < 1) {
    echo $errorMessage;
} else {
