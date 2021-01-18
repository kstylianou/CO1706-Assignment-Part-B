<?php
/* Kyriakos Stylianou
 * This page is to display to the user all data for selected track by getting the id of the track
 * It shows the average of people that review the track and comments
 * User can also rate the track and add to playlist
 * User can visit the album from this page and click on the genre to see all the track by the selected genre
 */
session_start();
//When user is logged in and try to visit this page it redirects to index page
if(!isset($_SESSION['login_user'])) {
    header("Location: index.php");
}
// if there is not id it take the user back to tracks page
if(!isset($_GET['id'])){
   header("Location: tracks.php");
}else{
    $track_id = htmlspecialchars($_GET['id']); // track id
    $id = $_SESSION['id']; // user id
}
include('connection.php'); // Database connection
$sql = "SELECT * FROM `tracks` WHERE track_id = '$track_id'"; // Selects all from the track with the given track id
$result = mysqli_query($connection,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$count = mysqli_num_rows($result);

// table row must be 1 row
// Get all the data from database if exist
if($count == 1) {
    $artist = $row['artist'];
    $album = $row['album'];
    $description = $row['description'];
    $name = $row['name'];
    $genre = $row['genre'];
    $image = $row['image'];
    $thumb = $row['thumb'];
    $sample = $row['sample'];
}else {
    // If result not matched, it redirects to tracks page
    header("location: tracks.php");
}
// Checks if this track belongs to user playlist
$playlist = "SELECT * FROM `playlist` WHERE user_id = '$id' and track_id = '$track_id'";
$listResult = $connection->query($playlist);

// Get the avarage rating for this track
$ratingAvg = "SELECT CAST(AVG(rating) AS DECIMAL(10,1)) AS AVG FROM `reviews` WHERE product_id = $track_id";
$avgResult = $connection->query($ratingAvg);
$row = mysqli_fetch_array($avgResult,MYSQLI_ASSOC);
$avg = $row['AVG'];
// if the average is null (empty) it shows to users 0.0
if($avg == null){
    $avg = 0.0;
}
// Count how many ratings this track have
$ratingCount = "SELECT COUNT(rating) AS count FROM `reviews` WHERE product_id = $track_id";
$countResult = $connection->query($ratingCount);
$row = mysqli_fetch_array($countResult,MYSQLI_ASSOC);
$count = $row['count'];

// Selects all the reviews and rating of this track
$reviesSql = "SELECT review , name, rating FROM `reviews` WHERE product_id = $track_id ORDER BY review_id DESC";
$reviewResult = $connection->query($reviesSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Artist</title>
    <link rel="stylesheet"  href="css/homepage.css">
    <link rel="stylesheet"  href="css/artist.css">
    <link rel="stylesheet" type="text/css"  href="css/navbar.css">
    <script src="js/navbar.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>

<!-- Including Navigation bar -->
<?php include('navbar.php'); ?>

<!-- Show the track details -->
<div class="artist-back">
    <img class="artist-img" src="<?php echo $image ?>" alt="<?php echo $artist ?>">

    <h3><strong>Artist:</strong></h3>
    <p class="artist-detail-p"><?php echo $artist ?></p>

    <h3><strong>Song Name:</strong></h3>
    <p class="artist-detail-p"><?php echo $name ?></p>

    <h3><strong>Album:</strong></h3>
    <a href="album.php?album=<?php echo $album ?>" class="artist-detail-p"><?php echo $album ?></a>

    <h3><strong>Genre:</strong></h3>
    <a href="tracks.php?genre=<?php echo $genre ?>" class="artist-detail-p"><?php echo $genre ?></a>

    <br>
    <br>
    <!-- if is allready in user playlist it shows remove from playlist else add to playlist -->
    <?php if ($listResult->num_rows > 0) { ?>
        <button type="button" class="addPlaylist" onclick="removePlaylist(<?php echo $track_id ?>, 0)">Remove from playlist</button>
    <?php } else{ ?>
        <button type="button" class="addPlaylist" onclick="addPlaylist(<?php echo $track_id ?>, 0)">Add to playlist</button>
    <?php } ?>

    <br>
    <br>
    <!-- if user didnt review this track it shows a button to rate it else it shows message to thank -->
    <?php if(!isset($_GET['review'])){ ?>
    <p class="button-align">
        <button id="myBtn">Rate this Track</button>
    </p>
    <?php } else{ ?>
    <p class="button-align">Thanks for your review!</p>
    <?php } ?>
</div>

<!-- Audio tag to play the sample -->
<audio controls class="track-control" id="trackPlayer" style="display: block">
    <source src="<?php echo $sample ?>">
    <source src="<?php echo $sample ?>">
    Your browser does not support the audio element.
</audio>

<!-- Reference  W3schools.com. 2020. How To Make A Modal Box With CSS And Javascript. [online] Available at: <https://www.w3schools.com/howto/howto_css_modals.asp> -->
<!-- Rating Modal -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <form action="action_rate.php?id=<?php echo $track_id?>" method="post">
        <div class="rate-artist">
            <p>Rate:</p>
            <div class="rate">
                <input type="radio" id="star10" name="rate" value="10">
                <label for="star10" title="text">10 stars</label>
                <input type="radio" id="star9" name="rate" value="9">
                <label for="star9" title="text">9 stars</label>
                <input type="radio" id="star8" name="rate" value="8">
                <label for="star8" title="text">8 stars</label>
                <input type="radio" id="star7" name="rate" value="7">
                <label for="star7" title="text">7 stars</label>
                <input type="radio" id="star6" name="rate" value="6">
                <label for="star6" title="text">6 star</label>
                <input type="radio" id="star5" name="rate" value="5">
                <label for="star5" title="text">5 stars</label>
                <input type="radio" id="star4" name="rate" value="4">
                <label for="star4" title="text">4 stars</label>
                <input type="radio" id="star3" name="rate" value="3">
                <label for="star3" title="text">3 stars</label>
                <input type="radio" id="star2" name="rate" value="2">
                <label for="star2" title="text">2 stars</label>
                <input type="radio" id="star1" name="rate" value="1" checked>
                <label for="star1" title="text">1 star</label>
            </div>
            <div class="space"></div>
            <label>Comment:</label>
            <textarea class="textareaComment" rows="5" name="comment" required></textarea>
            <p class="button-align">
                <input type="submit" id="submit">
            </p>
        </form>
        </div>
    </div>
</div>
<div id="ratingSystem">
    <span class="heading">Users Rating</span>
        <!-- Using for loop for example avg is 7 is loops 7 yellow start and the rest black -->
    <?php for($i = 0; $i < 10; $i++){
        if($i < $avg){
            echo "<span class=\"fa fa-star checked\"></span>";
        }else{
          echo "<span class=\"fa fa-star\"></span>";
        }
    } ?>

    <p><?php echo $avg ?> average based on <?php echo $count ?> reviews.</p>
    <hr id="hr-border">
</div>

<!-- Show all the comments rating that users rate for this track -->
<?php  while($row = mysqli_fetch_array($reviewResult)){?>
<div id='reviewBack'>
    <div class="chip">
        <span id="profileImg"><i class="fa fa-user" aria-hidden="true"></i></span>
        <?php echo $row['name']; ?>
    </div>
    <span id="rate"><?php echo $row['rating']; ?>/10 <i class="fa fa-star checked-active"></i></span>
    <div id="review-Bg">
        <p id='review'><?php echo $row['review'] ?></p>
    </div>
</div>
<?php } ?>

<div class="space"></div>
<p id ="copyright"><small>Copyright 2020 SOUNDWAVE</small></p>
<div class="space"></div>

<!-- The javascript functionality for adding to playlist or removing -->
<script src="js/addRemovePlaylist.js"></script>
<script>
    // Reference:  W3schools.com. 2020. How To Make A Modal Box With CSS And Javascript. [online] Available at: <https://www.w3schools.com/howto/howto_css_modals.asp>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    };

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>