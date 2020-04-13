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
        <!-- Form to create a new poll -->
        <form action="../scripts/form_handler.php" method="POST">
            <h2>Create a Poll</h2>
            <div>
                <input type="text" name="title" style="font-weight:bold;"
                    placeholder="Question" maxlength="1024" required autofocus>

                <input type="text" name="opt[0]" placeholder="Option 1" maxlength="1024" required>
                <input type="text" name="opt[1]" onkeyup="show_opt(2)"
                    placeholder="Option 2" maxlength="1024" required>
                <input type="text" name="opt[2]" style="display:none;" onkeyup="show_opt(3)"
                    placeholder="Option 3, optional" maxlength="1024">
                <input type="text" name="opt[3]" style="display:none;" onkeyup="show_opt(4)"
                    placeholder="Option 4, optional" maxlength="1024">
                <input type="text" name="opt[4]" style="display:none;" onkeyup="show_opt(5)"
                    placeholder="Option 5, optional" maxlength="1024">
                <input type="text" name="opt[5]" style="display:none;" onkeyup="show_opt(6)"
                    placeholder="Option 6, optional" maxlength="1024">
                <input type="text" name="opt[6]" style="display:none;" onkeyup="show_opt(7)"
                    placeholder="Option 7, optional" maxlength="1024">
                <input type="text" name="opt[7]" style="display:none;" onkeyup="show_opt(8)"
                    placeholder="Option 8, optional" maxlength="1024">
                <input type="text" name="opt[8]" style="display:none;" onkeyup="show_opt(9)"
                    placeholder="Option 9, optional" maxlength="1024">
                <input type="text" name="opt[9]" style="display:none;"
                    placeholder="Option 10, optional" maxlength="1024">

                <label for="mult_choice">Allow multiple choices? </label>
                <input type="checkbox" name="mult_choice"
                    alt="Tick the box to allow multiple choices.">
                <input type="text" name="username" maxlength="64"
                    placeholder="Owner username, optional"
                    <?php if (isset($_SESSION["username"])) {
                        echo "value=\"".$_SESSION["username"]."\"";
                    } ?>
                >
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
