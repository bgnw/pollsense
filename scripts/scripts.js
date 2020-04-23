// Show more options (up to 10) as the user fills in the option fields
// when creating a poll.
    function show_opt(opt) {
        var target = "opt[";
        var target = target.concat(opt,"]");
        document.getElementsByName(target)[0].style.display="inline-block";
    }

// Show/hide mobile navbar overlay
    function show_mobile_nav() {
        document.getElementById("navbar-mobile-overlay").style.width="100%";
    }

    function hide_mobile_nav() {
        document.getElementById("navbar-mobile-overlay").style.width="0%";
    }
