// Show more options (up to 10) as the user fills in the option fields
// when creating a poll.
function show_opt(opt) {
    var target = "opt["
    var target = target.concat(opt,"]")
    document.getElementsByName(target)[0].style.display="inline-block";
}
