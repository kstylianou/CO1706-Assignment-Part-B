<?php
/* Kyriakos Stylianou
 * Landing page where are information about the app and the plans
 * The button buy now it take the to register if there not login with the selected plan using get and plan id.
 * if user is logged in the button is "Update Plan" and take the user to account.php page to change the plan
 */
session_start();
$msg = ""; // Php does not allow undefined!
if(isset($_SESSION['name'])){
    $msg = "Welcome back " . $_SESSION['name'] . "!"; // Show the user a welcome with his name after login
}
include('connection.php'); // Database connection
$sql = "SELECT * FROM `offers`"; // Selects all from offers
$result = mysqli_query($connection,$sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HOME</title>
    <link rel="stylesheet"  href="css/navbar.css">
    <link rel="stylesheet"  href="css/homepage.css">
    <script src="js/navbar.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

</head>
<body>

<!-- Including Navigation bar -->
<?php include('navbar.php'); ?>

<!-- welcome message to the user -->
<p class = "welcome"><?php echo $msg ?></p>
<!-- Application information -->
    <div class = "appText">
        <div class = "Box">
            <h1 class = "appH2">Our app</h1>
            <img id = "headphones" src="images/headphones-791078_1280.jpg" alt = "headphones">
            <p>Find new and trending music & audio. Follow your favorite artists and friends. Create and share playlists. Explore every genre you can think of. Our app makes it easy for you to hear what you want to hear.</p>

        </div>

        <div class="Box">
            <h1 class = "appH2">Hear today’s latest.</h1>
            <img id = "man" src="images/man-1845432_1920.jpg" alt = "Man">
            <p>Tracks about to explode. Artists heading for fame. Breaking news and podcasts. The Explore screen lets you discover new and trending music & audio. Finding new things to hear couldn’t be easier.</p>
        </div>

        <div class="Box">
            <h1 class="appH2">Make the perfect playlist.</h1>
            <img id = "musician" src="images/musician-349790_1920.jpg" alt = "musician">
            <p>Hear and like playlists made by others. Or create your own from scratch. Two hours of the latest techno tracks. An hour of rock anthems. An afternoon of nothing but your friend’s garage rock.
            Whatever you want.</p>
        </div>

        <div class ="Box">
            <h1 class = "appH2">Follow whoever you want.</h1>
            <img id = "bnW" src="images/black-and-white-2564630_1920.jpg" alt = "black and white">
            <p>Following friends and artists lets you hear everything they create and share. Play their favorites from your Stream. Or go to their Profile to get all the music & audio they post and love in one place.</p>
        </div>
    </div>

<!-- details of pricing plans in a box with the given image. -->
    <div class="row">
        <?php  while($row = mysqli_fetch_array($result)){ ?>
        <div class="column">
            <div class="card">
                <img class ="offerImg" src="<?php echo $row['image']?>" alt="<?php echo $row['title']?>" >
                <div class="container">
                    <h3><?php echo $row['title']?></h3>
                    <p><?php echo $row['description']?></p>
                    <p><?php echo $row['price']?></p>
                    <?php if(isset($_SESSION['id'])){ ?>
                        <p><button onclick="window.location.href = 'account.php'" class="button">UPDATE PLAN</button></p>
                    <?php } else{ ?>
                        <p><button onclick="window.location.href = 'register.php?offer=<?php echo $row['offer_id']?>'" class="button">BUY NOW</button></p>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

<p id ="copyright"><small>Copyright 2019 SOUNDWAVE</small></p>


</body>
</html>