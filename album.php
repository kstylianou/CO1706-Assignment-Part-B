<?php
/* Kyriakos Stylianou
 * This page is to display all the details for the selected album and all the tracks in the album
 * On the table user can click on name or artist to go to the song page
 */
session_start();
//When user is logged in and try to visit this page it redirects to index page
if (!isset($_SESSION['login_user'])) {
    header("Location: index.php");
}

// Check if get album exist
if (isset($_GET['album'])) {
    $album = htmlspecialchars($_GET['album']);
}else{
    // else take the user back to the tracks
    header("location: tracks.php");
}
include('connection.php'); // Connection to database
$sql = "SELECT * FROM `tracks` WHERE album = '$album'"; // Select all from the given album
$result = mysqli_query($connection, $sql);
$results = mysqli_query($connection, $sql);
$samples = array();
// row all the selected data
while ($row = mysqli_fetch_array($result)) {
    array_push($samples, $row['sample']);
    $artist = $row['artist'];
    $album = $row['album'];
    $description = $row['description'];
    $name = $row['name'];
    $genre = $row['genre'];
    $image = $row['image'];
    $thumb = $row['thumb'];
    $sample = $row['sample'];
}
if($count = mysqli_num_rows($result) == 0) {
    // If result not matched, it redirects to tracks page
    header("location: tracks.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Artist</title>
    <link rel="stylesheet"  href="css/homepage.css">
    <link rel="stylesheet"  href="css/album.css">
    <link rel="stylesheet" type="text/css"  href="css/navbar.css">
    <script src="js/navbar.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>

<!-- Including Navigation bar -->
<?php include('navbar.php'); ?>
<div class="album-back">
    <!-- Desplay all album details -->
    <img class="artist-img" src="<?php echo $image ?>" alt="Album Image">
    <h3><strong>Artist: </strong></h3>
    <p class="song-detail-p"><?php echo $artist ?></p>
    <h3><strong>Album: </strong></h3>
    <p class="song-detail-p"><?php echo $album ?></p>
    <h3><strong>Description:</strong></h3>
    <p class="song-detail-p"><?php echo $description ?></p>

    <!-- Table to show all the track from the selected album -->
    <table>
        <tr>
            <th>Artist:</th>
            <th>Name</th>
            <th>Play</th>
        </tr>
        <?php while ($rows = mysqli_fetch_array($results)) { ?>
        <tr>
            <td onclick="window.open('artist.php?id=<?php echo $rows['track_id']; ?>', '_self')"><?php echo $rows['artist']; ?></td>
            <td onclick="window.open('artist.php?id=<?php echo $rows['track_id']; ?>', '_self')"><?php echo $rows['name']; ?></td>
            <td><span class = "playButton"><i class="far fa-play-circle"></i></span></td>
        </tr>

        <?php } ?>
    </table>
</div>
<!-- audio tag to play the tracks -->
<audio controls  class="track-control" id="trackPlayer"></audio>

<!-- the play functionality for the tracks -->
<script src="js/playTrack.js"></script>
<script>
    // parse songs into json array
    let samples = JSON.parse('<?php echo JSON_encode($samples);?>'); // Load all the sample to js from php to play them
</script>
</body>
</html>