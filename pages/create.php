<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- All headers (i.e. links to CSS stylesheets, JS scripts, etc.) -->
        <?php include "../scripts/incl_head.php";?>
        <title>PollSense &rsaquo; Create Poll</title>
    </head>

    <body id="create">
        <!-- Navigation bar -->
        <?php include "../scripts/incl_navbar.php";?>

        <!-- Main content -->
        <div class="content">
            <div class="card-container">
                <div class="card">
                    <form name="poll_create" action="../scripts/form_handler.php" method="post">
                        <h2>Create a Poll</h2>
                        <div>
                            <input type="text" name="title" style="font-weight:bold;" placeholder="Question" maxlength="1024" required autofocus>
                            <input type="text" name="opt[0]" placeholder="Option 1" maxlength="1024" required>
                            <input type="text" name="opt[1]" onkeyup="show_opt(2)" placeholder="Option 2" maxlength="1024" required>
                            <input type="text" name="opt[2]" onkeyup="show_opt(3)" class="hidden" placeholder="Option 3, optional" maxlength="1024">
                            <input type="text" name="opt[3]" onkeyup="show_opt(4)" class="hidden" placeholder="Option 4, optional" maxlength="1024">
                            <input type="text" name="opt[4]" onkeyup="show_opt(5)" class="hidden" placeholder="Option 5, optional" maxlength="1024">
                            <input type="text" name="opt[5]" onkeyup="show_opt(6)" class="hidden" placeholder="Option 6, optional" maxlength="1024">
                            <input type="text" name="opt[6]" onkeyup="show_opt(7)" class="hidden" placeholder="Option 7, optional" maxlength="1024">
                            <input type="text" name="opt[7]" onkeyup="show_opt(8)" class="hidden" placeholder="Option 8, optional" maxlength="1024">
                            <input type="text" name="opt[8]" onkeyup="show_opt(9)" class="hidden" placeholder="Option 9, optional" maxlength="1024">
                            <input type="text" name="opt[9]" class="hidden" placeholder="Option 10, optional" maxlength="1024">
                            <label for="mult_choice" >Allow multiple choices? </label>
                            <input type="checkbox" name="mult_choice" alt="Tick the box to allow multiple choices.">
                            <input type="text" name="username" maxlength="64" placeholder="Username, optional">
                        </div>
                        <input type="submit" name="poll_create_submit" value="Create Poll">
                    </form>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include "../scripts/incl_footer.php";?>
    </body>
</html>
