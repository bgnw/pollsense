<!DOCTYPE html>
<html lang="en">
<head>
    <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
    <?php include "../scripts/incl_head.php";?>
    <title>PollSense &rsaquo; About</title>
</head>

<body id="about">
    <!-- Navigation bar -->
    <?php include "../scripts/incl_navbar.php";?>
    <!-- Main content -->
    <div class="content">
    <div class="card-container">
    <div class="card">
        <!-- Some info about the project -->
        <h2>About PollSense</h2>
        <p style="text-align: left;">
            PollSense is a place where you can create and participate in polls,
            to find out more about others, quickly and easily.
            <br><br>
            This site was made by myself, Ben Agnew, as part of my
            <a class="blue-link" href="https://www.sqa.org.uk/sqa/48508.html">SQA Advanced Higher
                Computing Science</a> course assessment.
            <br><br>
            Noticed any problems?<br>Contact me at
            <?php
                $link = "contact@".$_SERVER['HTTP_HOST'];
                echo "<a class=\"blue-link\" href=\"mailto:$link\">$link</p>";
            ?>
        </p>
    </div>
    </div>
    </div>
    <!-- Footer -->
    <?php include "../scripts/incl_footer.php";?>
</body>
</html>
