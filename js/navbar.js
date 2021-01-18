/* Kyriakos Stylianou
 * This javascript file is to make the navigation bar responsive
 */

// make the navbar responsive
function responsiveNavBar() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}