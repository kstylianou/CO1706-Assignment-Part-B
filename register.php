<?php
/* Kyriakos Stylianou
 * Register page allow the user to create account to the app.
 * User validation is the javascript as user types username , password , and password repeat it shows message if something is wrong all input are required.
 * Username validation by using javascript xml request and get data from page user_check.php
 */
session_start();
//When user is logged in and try to visit this page it redirects to index page
if (!empty($_SESSION['login_user']) && $_SESSION['login_user'] == true) {
    header("Location: index.php");
}
$offerId = 0; // By default
if (isset($_GET['offer'])) {
    $offerId = htmlspecialchars($_GET['offer']); // offer id
}
include('connection.php'); // Database connection
$sql = "SELECT offer_id, title FROM `offers`"; // Select from offers from database so if there is change to plans to not break the page
$result = mysqli_query($connection,$sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" type="text/css"  href="css/register.css">
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
    <span class="login-msg">REGISTER</span>
    <form onsubmit="return check()" action="action_register.php" method="post">
        <div class="form-group">
            <label class="label-settings">
                <span class="label-text">
                    <span id="err-msg-email">Name</span>
                </span>
                <input autofocus id="email" type="text" class="form-input input-type login-email" name="name" placeholder="Name" required>
            </label>
        </div>

        <div class="form-group">
            <label class="label-settings">
                <span class="label-text">
                    <span id="err-msg-user">Username</span>
                    <span class="err-msg"></span>
                </span>
                <input id="username" type="text" oninput="checkUser()" class="form-input input-type login-email" name="username" placeholder="Username" required>
            </label>
        </div>

        <div class="form-group">
            <label class="label-settings">
                <span class="label-text">
                    <span id="err-msg-price">Pricing plan</span>
                </span>
                <select class="plan-select" id="selectPlan" name="plan" size="1" required>
                    <option value="" disabled selected>Please select plan</option>
                    <?php  while($row = mysqli_fetch_array($result)){
                        if($offerId == $row['offer_id']){?>
                            <option value="<?php echo $row['offer_id'] ?>" selected><?php echo $row['title'] ?></option>
                        <?php } else{ ?>
                            <option value="<?php echo $row['offer_id'] ?>"><?php echo $row['title'] ?></option>
                    <?php } }?>
                </select>
            </label>
        </div>

        <div class="form-group">
            <label class="label-settings">
                <span class="label-text">
                    <span id="psw-text">Password</span>
                    <span class="err-msg"></span>
                </span>
                <input class="form-input input-type login-password" oninput="checkPasswordLenght()" id="psw" type="password" name="password" placeholder="Password" required>
            </label>
        </div>

        <div class="form-group">
            <label class="label-settings">
                <span class="label-text">
                    <span>Repeat Password</span>
                    <span class="err-msg"></span>
                </span>
                <input class="form-input input-type login-password" oninput="checkPasswordEqual()" id="psw-r" type="password" name="psw-r" placeholder="Password" required>
            </label>
        </div>

        <div class="form-group">
            <button type="submit"  id="sbtBtn" class="btn login-submit">Register</button>
        </div>
    </form>
    <br>
    <span class="forgot-psw">Already have an account? <a class="forgot-psw-singup" href="login.php">Login</a></span>
    <br>
</div>
<script>
    let errMsg = document.getElementsByClassName('err-msg');
    let bpsw = false;
    let bpswr = false;
    let buser = false;
    function check() {
        // returns false or true to form
        return bpsw === true && bpswr === true && buser === true;
    }
    // Checks for username if exist and show message
    function checkUser() {
        let username = document.getElementById('username').value;
        let user = document.getElementById('err-msg-user');
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let json = JSON.parse(this.responseText);
                if(json.exist == true){
                    user.style.display = 'none';
                    errMsg[0].innerHTML = 'Username already exists';
                }else{
                    user.style.display = 'block';
                    errMsg[0].innerHTML = '';
                    buser = true;
                }
            }
        };
        xhttp.open("POST", "user_check.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("username="+username+"");
    }

    // Check the password length and show message if is less tha 8
    function checkPasswordLenght() {
        let psw = document.getElementById('psw');
        let pswT = document.getElementById('psw-text');
        if(psw.value.length < 8){
            errMsg[1].innerHTML = "Password to short";
            pswT.style.display = 'none';
        }else{
            errMsg[1].innerHTML = "";
            pswT.style.display = 'block';
            bpsw = true;
        }
    }
    // Checks if password and password repeat are equal if not it show error to the user
    function checkPasswordEqual() {
        let psw = document.getElementById('psw');
        let pswR = document.getElementById('psw-r');
        let pswT = document.getElementById('psw-text');
        if(psw.value !== pswR.value) {
            errMsg[1].innerHTML = "Your password and confirmation password do not match";
            pswT.style.display = 'none';
        }
        else{
            errMsg[1].innerHTML = "";
            pswT.style.display = 'block';
            bpswr = true;
        }
    }
</script>
</body>
</html>
