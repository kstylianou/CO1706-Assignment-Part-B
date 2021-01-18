<?php
/* Kyriakos Stylianou
 * Track page display all tracks if there is not get on url you it can display the track by , genre, user playlist, and search by name, artist, album
 * This page display random tracks table on all track you can click on name, album, and picture to take you to the track page for more information and reviews
 * It also display recommend tracks on table by the highest rating you user give, if there is not rating recommend table is hidden
 *
 * Playlist:
 * If the playlist is empty is a button to add 5 random tracks to playlist
 * User can remove the track from playlist.
 *
 * Random Playlist:
 * Selects 5 random track from database
 * It display on table you can click on name or artist to go to the track page for comments , rating etc
 *
 * Recommend Playlist:
 * Selects 5 tracks by the grater rating number user rated and display 5 by its genre
 * It display on table you can click on name or artist to go to the track page for comments , rating etc
 *
 * Playing Track:
 * User can click on play button and by using javascript the track is loaded at audio tag on the bottom
 * When user click on play button it change to pause button and user can pause the track from there or at the bottom audio tag
 *
 * Shuffle play:
 * user can click on shuffle play icon and automatic start to play random from trucks or playlist to stop user can click pause on audio tag or on shuffle play icon again
 *
 * Genre dropdown:
 * User can open the dropdown by clicking on it and can choose genre
 *
 * Right arrow:
 * Open full screen navigation bar and includes all artists and albums for user to choose and see the content
 *
 * Search input
 * Users can search by artist, album, track name
 */
session_start();
// Check if the user is logged in if not redirect to login page
if(!isset($_SESSION['login_user'])){
    header("location: login.php");
}
$id = $_SESSION['id']; // user id
include('connection.php'); // Database Connection
if(!isset($_GET['genre'])) { // if not get genre selects all tracks
    $sql = "SELECT * FROM `tracks`";
}else{
    // Select track by the given genre
    $genre = $_GET['genre'];
    $sql = "SELECT * FROM `tracks` WHERE genre = '$genre'";
}
// if user have search for something
if(isset($_GET['search'])){
    // Try to find what user searched by artist, album, name
    $search = $_GET['search'];
    $sql = "select * from `tracks` where CONCAT(artist, album, name) like '%$search%'";
}
// if playlist get exist select track tha user have on playlist
if(isset($_GET['playlist'])){
    $sql = "SELECT * FROM `playlist` INNER JOIN tracks ON playlist.track_id = tracks.track_id WHERE user_id = '$id'";
}

// 5 random tracks
$rand = "SELECT * FROM tracks  ORDER BY RAND ()  LIMIT 5 ";
$randResult = mysqli_query($connection,$rand);

// Get the genre user haves the highest rating to display 5 random tracks
$recomend = "SELECT  DISTINCT genre FROM `reviews` INNER JOIN tracks ON reviews.product_id = tracks.track_id WHERE user_id = '$id' ORDER BY rating DESC ";
$recomendResult = mysqli_query($connection,$recomend);
while ($rows = mysqli_fetch_array($recomendResult)) {
    $recomend_tracks = $rows['genre']; // Get the recommend genre
}
// Select the recommended tracks
if(isset($recomend_tracks)){
    $selectRecoment = "SELECT * FROM `tracks` WHERE genre = '$recomend_tracks' ORDER BY RAND ()  LIMIT 5";
    $recomendResults = mysqli_query($connection,$selectRecoment);
}

$result = mysqli_query($connection,$sql);
$samples = array(); // Sample to for js to play tracks

// for the side bar selects distinct the artists
$select = "SELECT DISTINCT artist FROM tracks";
$query = mysqli_query($connection,$select);

// for the side bar selects distinct the album
$select1 = "SELECT DISTINCT album FROM tracks";
$query1 = mysqli_query($connection,$select1);

// Add 5 random tracks to playlist this can happen only one time and must the playlist be empty
if(isset($_GET['playlist']) && isset($_GET['add'])) {
    // Check if there is no tracks on playlist
    if ($result->num_rows == 0) {
        // Select 5 random tracks
        $randomPlaylist = "SELECT track_id FROM tracks  ORDER BY RAND ()  LIMIT 5 ";
        $randomResult = mysqli_query($connection,$randomPlaylist);
        // insert the 5 random tracks to database
        while ($row = mysqli_fetch_array($randomResult)) {
            $track_id = $row['track_id']; // Get the track id
            $insert = "INSERT INTO `playlist`(`user_id`, `track_id`) VALUES ('$id','$track_id')";
            $connection->query($insert);
        }
    }
    $sql = "SELECT * FROM `playlist` INNER JOIN tracks ON playlist.track_id = tracks.track_id WHERE user_id = '$id'";
    $result = mysqli_query($connection,$sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Music Selection</title>
    <link rel="stylesheet"  href="css/homepage.css">
    <link rel="stylesheet"  href="css/navbar.css">
    <script src="js/navbar.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <srcipt src="js/playTrack.js"></srcipt>
</head>
<body>
<!-- Including Navigation bar -->
<?php include('navbar.php'); ?>

<!-- Music navigation bar that the user can choose genre and using id and a href it take the to the genre it choose-->
<div class="musicBar-background">
    <div class="musicBar" id="myHeader">
        <div class="select-sample" onclick="openNav()">
            <i class="fas fa-arrow-alt-circle-right"></i>
        </div>
        <!-- Genre dropdown -->
        <div class="dropdown">
            <button class="dropbtn">GENRE
               <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
                <a href="?genre=RAP">RAP</a>
                <a href="?genre=R and B">R&B</a>
                <a href="?genre=ROCK">ROCK</a>
                <a href="?genre=indie">INDIE</a>
                <a href="?genre=dance">DANCE</a>
            </div>
        </div>

        <!-- Search box tha user can search for album, music and artists-->
        <div class="search-container">
            <form onsubmit="searchUrl()">
            <input type="text" placeholder="Search..." id="search" name="search">
                <button type="submit"><i class="fa fa-search"></i></button>

            <!-- Shuffle play -->
            <div class="random-sample" onclick="randomTrack()">
                <i id="randPlay" class="fas fa-random"></i>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Side navigation bar -->
<!-- Reference:  W3schools.com. 2020. How To Create A Full Screen Overlay Navigation. [online] Available at: <https://www.w3schools.com/howto/howto_js_fullscreen_overlay.asp>. -->
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <p class="side-bar-p">Artist:</p>
    <?php while($row = mysqli_fetch_array($query)){ ?>
        <a href="?search=<?php echo $row['artist'] ?>"><?php echo $row['artist'] ?></a>

    <?php } ?>

    <p class="side-bar-p">Album: </p>
    <?php while($row = mysqli_fetch_array($query1)){ ?>
        <a href="album.php?album=<?php echo $row['album'] ?>"><?php echo $row['album'] ?></a>

    <?php } ?>
</div>

<!-- Random Playlist on click it toggles hide/visible  -->
<div id="randPlaylist" onclick="hideRandomPlaylist()">
    <p id="random-p">Random Playlist <i id="faUp" class="fa fa-caret-down"></i></p>
</div>
<div id="hidden-table">
    <table id="tableHeight">
        <tr>
            <th>Artist:</th>
            <th>Name</th>
            <th>Play</th>
        </tr>
        <?php while ($rows = mysqli_fetch_array($randResult)) {
            array_push($samples, $rows['sample']);?>
            <tr>
                <td onclick="window.open('artist.php?id=<?php echo $rows['track_id']; ?>', '_self')"><?php echo $rows['artist']; ?></td>
                <td onclick="window.open('artist.php?id=<?php echo $rows['track_id']; ?>', '_self')"><?php echo $rows['name']; ?></td>
                <td><span class = "playButton table-Play"><i class="far fa-play-circle"></i></span></td>
            </tr>
        <?php } ?>
    </table>
</div>

<!-- Recommended tracks if user hava rate at least one track on click it toggles hide/visible -->
<?php if(isset($recomend_tracks)){ ?>
<div id="recomentPlaylist" onclick="hideRecomentPlaylist()">
    <p id="random-p">Recoment Playlist <i id="faR" class="fa fa-caret-down"></i></p>
</div>
<div id="hidden-Recoment-table">
    <table>
        <tr>
            <th>Artist:</th>
            <th>Name</th>
            <th>Play</th>
        </tr>
        <?php while ($rows = mysqli_fetch_array($recomendResults)) {
            array_push($samples, $rows['sample']);?>
            <tr>
                <td onclick="window.open('artist.php?id=<?php echo $rows['track_id']; ?>', '_self')"><?php echo $rows['artist']; ?></td>
                <td onclick="window.open('artist.php?id=<?php echo $rows['track_id']; ?>', '_self')"><?php echo $rows['name']; ?></td>
                <td><span class = "playButton table-Play"><i class="far fa-play-circle"></i></span></td>
            </tr>
        <?php } ?>
    </table>
</div>
<?php } ?>

<?php
// if playlist is empty message and button to add 5 random take place
if(isset($_GET['playlist'])){
    if ($result->num_rows == 0) {
        echo "<h2 id='playlistErr'>Your playlist is empty</h2> <p id='button-align'><a href='tracks.php?playlist=true&add=5' id='tracksA'>Add 5 random tracks</a></p>";
    }
}
$count = 0; // Count the tracks and place to work like a number for array as it loops
while($row = mysqli_fetch_array($result)){
    array_push($samples, $row['sample']); // push the samples to array

    $track_id = $row['track_id']; // track id
    // Get the all the track tha are on database to show different button to remove not to add
    $playlist = "SELECT * FROM `playlist` WHERE user_id = '$id' and track_id = '$track_id'";
    $listResult = $connection->query($playlist);
    ?>

    <div class = "appText content" >
        <!--<h3 class = "appH2">RAP</h3>-->
            <div onclick="openTrack(<?php echo $row['track_id'] ?>)" class = "box">
                <div class="bg-img-thumb">
                <img class = "man" src="<?php echo $row['thumb'] ?>" alt="<?php echo $row['name'] ?>" >
                </div>
                <p><strong>Artist:</strong> <?php echo $row['artist'] ?></p>
                <p><strong>Name:</strong> <?php echo $row['name'] ?></p>
                <p><strong>Album:</strong> <?php echo $row['album'] ?></p>
            </div>
        <span class = "playButton" ><i class="far fa-play-circle"></i></span>
        <p class="button-align">
            <?php if ($listResult->num_rows > 0) { ?>
                <button type="button" class="addPlaylist" onclick="removePlaylist(<?php echo $row['track_id']; ?>, <?php echo $count; ?>, true)">Remove from playlist</button>
            <?php } else{ ?>
                <button type="button" class="addPlaylist" onclick="addPlaylist(<?php echo $row['track_id']; ?>, <?php echo $count; ?>)">Add to playlist</button>
            <?php } ?>
        </p>
    </div>

<?php $count = $count + 1;  } ?>

<!-- audio tag is loaded samples by javascript -->
<audio controls  class="track-control" id="trackPlayer"></audio>
<!-- playlist functionality add or remove -->
<script src="js/addRemovePlaylist.js"></script>
<!-- playing track functionality load track, play and pause -->
<script src="js/playTrack.js"></script>
<script>
    // if the there is recommended tracks hide the table
    <?php if(isset($recomend_tracks)){ ?>
    document.getElementById("hidden-Recoment-table").style.display = 'none';
    <?php } ?>
    document.getElementById("hidden-table").style.display = 'none';
    let samples = JSON.parse('<?php echo JSON_encode($samples);?>');
    let randomSample = Math.floor(Math.random() * samples.length);
    let randPlay = false;

    // Get parameters from url to add 5 random tracks to playlist
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const add = urlParams.get('add');
    if(add !== null) {
        let url = window.location.href;
        url = url.replace("&add=" + add + "", "");
        window.history.pushState("Tracks", "Tracks", url);
    }

    // Active the sticky on tracks navigation bar
    window.onscroll = function() {stickyNav()};
    var header = document.getElementById("myHeader");
    var sticky = header.offsetTop;
    function stickyNav() {
        if (window.pageYOffset > sticky) {
            header.classList.add("sticky");
        } else {
            header.classList.remove("sticky");
        }
    }

    // get the search value
    function searchUrl(){
        let search = document.getElementById("search").value;
        location.href = "?search="+search+"";
    }

    // open the side navigation bar
    function openNav() { document.getElementById("mySidenav").style.width = "100%"; }
    // closse the side navigation bar
    function closeNav() { document.getElementById("mySidenav").style.width = "0"; }

    // Go to track page
    function openTrack(id) { window.open("artist.php?id="+id+"", '_self'); }


    // toggle hide/visible random playlist table
    function hideRandomPlaylist() {
        var x = document.getElementById("hidden-table");
        var fa = document.getElementById('faUp');
        if (x.style.display === "none") {
            x.style.display = "block";
            fa.className = "fa fa-caret-up";
        } else {
            x.style.display = "none";
            fa.className = "fa fa-caret-down"
        }
    }


    // toggle hide/visible recommend playlist table
    function hideRecomentPlaylist() {
        var x = document.getElementById("hidden-Recoment-table");
        var fa = document.getElementById('faR');
        if (x.style.display === "none") {
            x.style.display = "block";
            fa.className = "fa fa-caret-up";
        } else {
            x.style.display = "none";
            fa.className = "fa fa-caret-down"
        }
    }


</script>
<span class="space"></span>
<span class="space"></span>
<p id ="copyright"><small>Copyright 2019 SOUNDWAVE</small></p>
<span class="space"></span>

</body>
</html>