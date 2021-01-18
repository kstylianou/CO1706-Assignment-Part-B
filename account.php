<?php
/* Kyriakos Stylianou
This page is for changing plan.
As default the selected is users plan, you can select other plan and is going to display all the information about the selected plan.
The plan details are all for database and when change by using xml it ask for data from action_plan.php with out refreshing.
*/
session_start();
$msg = "";
if(isset($_SESSION['name'])){
    $id = $_SESSION['id']; // Get user id
}else{
    header("location: login.php"); // if user is not login redirect to login page
}

$offerId = $_SESSION['offer_id']; // Get plan id
include('connection.php'); // Connection to database

// Select the user selected offer
$sql = "SELECT * FROM `offers` INNER JOIN login ON offers.offer_id = login.offer_id WHERE id = '$id'";
$result = mysqli_query($connection,$sql);

// Select the offer id title and price from offers
$offers = "SELECT offer_id, title, price FROM `offers`";
$results = mysqli_query($connection,$offers);

// If you change plan it shows the message
if(isset($_GET['suc'])){
     $msg = "Plan updated successfully";
}
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

<p id="success"><?php echo $msg ?></p>
<!-- details of pricing plans in a box with the logo and different color for each plan. -->
<div class="row">
    <?php  while($row = mysqli_fetch_array($result)){ ?>
        <div class="column">
            <div class="card">
                <!-- offers img -->
                <img id="img" class ="offerImg" src="<?php echo $row['image']?>" alt="<?php echo $row['title']?>" >
                <div class="container">
                    <!-- offers title -->
                    <h3 id="title"><?php echo $row['title']?></h3>
                    <!-- offers description -->
                    <p id="description"><?php echo $row['description']?></p>
                    <!-- offers price -->
                    <p id="price"><?php echo $row['price']?></p>
                    <!-- form to change plan -->
                    <form action="action_updatePlan.php">
                        <select class="plan-selectAccount" id="offers" name="offer_id" required>
                            <?php  while($row = mysqli_fetch_array($results)){
                                if($offerId == $row['offer_id']){?>
                                    <option value="<?php echo $row['offer_id'] ?>" selected disabled><?php echo $row['title'] ?>  <?php echo $row['price']?></option>
                                <?php } else{ ?>
                                    <option value="<?php echo $row['offer_id'] ?>"><?php echo $row['title'] ?>  <?php echo $row['price']?></option>
                                <?php } }?>
                        </select>
                        <p><button type="submit" class="button">Change Plan</button></p>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<p id ="copyright"><small>Copyright 2019 SOUNDWAVE</small></p>

<script>

    // Get data from loadOffers.php using fetch when user change plan it shows all the details abou the plan
    var option = document.getElementById("offers");
    option.onchange = function () {
        var selected = option.options[option.selectedIndex].value;
        fetch("loadOffers.php?offer_id="+selected+"")
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                // Get the data and display it
                document.getElementById('img').src = data[0].image;
                document.getElementById('title').innerHTML = data[0].title;
                document.getElementById('description').innerHTML = data[0].description;
                document.getElementById('price').innerHTML = data[0].price;
            });
    };
</script>

</body>
</html>
