<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
        <?php include "../scripts/incl_head.php";?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PollSense</title>
    </head>

    <body id="index">
        <!-- Navigation bar -->
        <?php include "../scripts/incl_navbar.php";?>
        <!-- Main content -->
        <div class="content">
            <!-- Welcome message -->
            <h1>Welcome to PollSense</h1>
            <h2>A place to create and participate in polls.</h2>
            <br>
            <!-- Links and descriptions of features -->
            <div class="card-container">
                <div class="card welcome-card">
                    <h3>Join a poll</h3>
                    <p>Give your in opinion in an existing poll, if you know the ID.</p>
                    <a class="action" href="join" title="Participate in an existing poll">Join Poll</a>
                </div>
                <div class="card welcome-card">
                    <h3>Create a poll</h3>
                    <p>Create a poll to gather insight on a question from others.</p>
                    <a class="action" href="create" title="Make a new poll">Create Poll</a>
                </div>
            </div>
            <div class="card-container">
                <div class="card welcome-card" >
                    <h3>About PollSense</h3>
                    <p>Find out more about this website, and how to contact the developer.</p>
                    <a class="action secondary" href="about" title="Go to the About page">About</a>
                </div>
                <div class="card welcome-card" >
                    <h3>Sign&nbsp;Up&nbsp;/ Log&nbsp;In</h3>
                    <p>Use an account to see all of your polls in one place, and edit them.</p>

                    <a class="action secondary" href="../scripts/account_redirect.php" title="Make or log into an account">Account</a>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include "../scripts/incl_footer.php";?>
    </body>
</html>
