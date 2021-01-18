<!-- Kyriakos Stylianou -->
<!-- Reference: W3schools.com. 2020. How To Create A Responsive Navbar With Dropdown. [online] Available at: <https://www.w3schools.com/howto/howto_js_responsive_navbar_dropdown.asp>.-->
<!-- Navigation bar with dropdown using the "humburger" icon when is below 1000px-->
<div class="topnav" id="myTopnav">
    <a id="logo-imgA" href="index.php"><img id = "logo1" src = "images/pngfind.com-wave-lines-png-62652091.png" alt = "Home" ></a>
    <div class="respone-bg">
        <a href="index.php">Home</a>
        <!-- if user is not logged in show on navbar login button and register button else show all the access to the app -->
        <?php if(!isset($_SESSION['login_user'])){ ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php } else{ ?>
            <div class="navdown">
                <button class="navbtn">Tracks
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="navdown-content">
                    <a href="tracks.php">All Tracks</a>
                    <a href="tracks.php?playlist">My Playlist</a>
                </div>
            </div>
            <a href="account.php">Account</a>
            <a href="logout.php">Logout</a>
        <?php } ?>
    </div>
    <a href="javascript:void(0);" class="icon" onclick="responsiveNavBar()">
        <i class="fa fa-bars"></i>
    </a>
</div>
