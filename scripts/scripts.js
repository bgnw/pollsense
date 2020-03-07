// Show more options (up to 10) as the user fills in the option fields
// when creating a poll.
function show_opt(opt) {
    var target = "opt["
    var target = target.concat(opt,"]")
    document.getElementsByName(target)[0].style.display="inline-block";
}

function show_mobile_nav() {
    document.getElementById("navbar-mobile-overlay").style.width="100%";
}

function hide_mobile_nav() {
    document.getElementById("navbar-mobile-overlay").style.width="0%";
}

// TEMP start
function showUsers(){
    document.getElementById("sample-users").style.display="block";
}

function fillUser(user){
    if (user == "admin") {
        document.getElementsByName("username")[1].value = "admin";
        document.getElementsByName("password")[1].value = "7SxgFf29N2rJxuZB";
    }
    else if (user == "alice.adams") {
        document.getElementsByName("username")[1].value = "alice.adams";
        document.getElementsByName("password")[1].value = "AYXi6sooWjNc0ZVU";
    }
    else if (user == "bob.bennett") {
        document.getElementsByName("username")[1].value = "bob.bennett";
        document.getElementsByName("password")[1].value = "dCQi6Nzo1p7FLj1o";
    }
    else if (user == "charlie.cook") {
        document.getElementsByName("username")[1].value = "charlie.cook";
        document.getElementsByName("password")[1].value = "vVQuuR2IdpV9NFgU";
    }
}
// TEMP end
