<?php
/* Kyriakos Stylianou
 *  This page is for return data using fetch, ajax xml etc.
 *  It inserts playlist for the user by id of the track and the id of the user.
 *  The reason I make it with fetch is to no need to refresh page after user clicks on add to playlist its all done by using javasctipt fetch
 */
session_start();
$arr = array(); // Return success by encode it
$err = array(); // Returns the errors to be handle

// Check if the user is logged in
if(isset($_SESSION['login_user'])){
    $id = $_SESSION['id'];
}else{
    // Returns error
    $err['error'] = "User Not login";
    echo json_encode($err);
}
// Check if the is track id
if(isset($_GET['track_id'])) {
    $track_id = htmlspecialchars($_GET['track_id']);
}else{
    // Returns error
    $err['error'] = "Not given track_id";
    echo json_encode($err);
}

// when is to be added to playlist
if(isset($_SESSION['login_user']) && isset($_GET['track_id']) && $_GET['remove'] == 'false'){
    include('connection.php'); // Connection to database
    $sql = "INSERT INTO `playlist`(`user_id`, `track_id`) VALUES ('$id','$track_id')"; // Insert the playlist user id and track id

    // when all the data are inserted to database return success
    if ($connection->query($sql) === TRUE) {
        $arr['suc'] = true;
    } else {
        // Returns error
        $arr['suc'] = false;
    }
    echo json_encode($arr); // encode the array to json
}

// when user remove it from playlist
if($_GET['remove'] == 'true'){
    include('connection.php'); // Connection to database
    // Delete the playlist row from database
    $sql = "DELETE FROM `playlist` WHERE track_id = '$track_id' and user_id = '$id'";

    // when all the data are removed from database return success
    if (mysqli_query($connection, $sql)) {
        $arr['suc'] = true;
    } else {
        // Returns error
        $arr['suc'] = false;
    }
    echo json_encode($arr); // encode the array to json
}
