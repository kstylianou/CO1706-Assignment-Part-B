<?php
/* Kyriakos Stylianou
 * Login page allow the users to login to their account if exist
 */
session_start();
//When user is logged in and try to visit this page it redirects to index page
if(!empty($_SESSION['login_user']) && $_SESSION['login_user'] == true) {
    header("Location: index.php");
}
$err = "";
// Error message if exist
if(!empty($_GET['err']) && $_GET['err'] == true){
    $err = "Your username or password is invalid";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css"  href="css/login.css">
    <link rel="stylesheet" type="text/css"  href="css/navbar.css">
    <link rel="stylesheet"  href="css/homepage.css">
    <script src="js/navbar.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>

<!-- Including Navigation bar -->
<?php include('navbar.php'); ?>

<!-- Login From -->
<div class="login-background">
    <span class="login-form-logo"><i class="far fa-play-circle"></i></span>
    <span class="login-msg">LOG IN</span>
    <form action="action_login.php" method="post">
        <div class="form-group">
            <label class="label-settings">
                <span class="label-text">
                    <?php if(empty($err)){ ?>
                    <span id="err-msg-email">Username</span>
                    <?php } ?>
                    <span class="err-msg"><?php echo $err ?></span>
                </span>
                <input autofocus id="email" type="text" class="form-input input-type login-email" name="username" placeholder="Username" required>
            </label>
        </div>

        <div class="form-group">
            <label class="label-settings">
                <span class="label-text">
                    <span>Password</span>
                    <span class="err-msg"></span>
                </span>
                <input class="form-input input-type login-password" id="psw" type="password" name="password" placeholder="Password" required>
            </label>

        </div>


        <div class="form-group">
            <button type="submit" id="sbtBtn" class="btn login-submit">log In</button>
        </div>
    </form>
    <br>
    <span class="forgot-psw">Don't have an account? <a class="forgot-psw-singup" href="register.php">Sign up</a></span>
    <br>
</div>
</body>
</html>
