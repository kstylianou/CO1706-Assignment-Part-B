<?php
/* Kyriakos Stylianou
 * This page is only for update users plan it can be accessed only if the user is logged in
 */
session_start();
// if user is not logged in it take user to login page
if(!isset($_SESSION['id'])){
    header("location: login.php");
}else {
    $user_id = $_SESSION['id']; // user id
    $offer_id = htmlspecialchars($_GET['offer_id']); // plan id

    include('connection.php'); // Connection to database
    // update plan where user_id to the given plan id
    $sql = "UPDATE login SET offer_id='$offer_id' WHERE id ='$user_id'";

    // if everything is updated it updates the session and take the user back to account.php page
    if ($connection->query($sql) === TRUE) {
        $_SESSION['offer_id'] = $offer_id;
        header("location: account.php?suc=true");
    } else {
        // if there is error it display it
        echo "Error updating record: " . $connection->error;
    }
}