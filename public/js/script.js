var hamStatus = "false";
function hambToggle() {
    var e = document.getElementsByClassName("hamToggle");
    hamStatus = "false" == hamStatus ? "true" : "false";
    for (var t = 0; t < e.length; t++) {
        e[t].setAttribute("data-hambOn", hamStatus);
        var n = e[t].style.display;
        e[t].style.display = "none",
        e[t].style.display = n
    }
}