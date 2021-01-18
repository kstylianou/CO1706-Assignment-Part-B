<?php
/* Kyriakos Stylianou
 * This page is to insert user rating to the database by user_id and track_id
 */
session_start();
//When user is logged in and try to visit this page it redirects to index page
if (!isset($_SESSION['login_user'])) {
    header("Location: index.php");
}else{
    $name = $_SESSION['name'];
}
if(!isset($_GET['id'])){
    header("Location: tracks.php");
}else{
    $id = htmlspecialchars($_GET['id']);
}
$user_id = $_SESSION['id']; // user id
$rate = htmlspecialchars($_POST['rate']); // rating ex 8/10
$comment = htmlspecialchars($_POST['comment']); // user comment

include('connection.php'); // Connection to database

// Insert to database
$sql = "INSERT INTO `reviews`( `product_id`, `user_id`, `name`, `review`, `rating`) VALUES ('$id', '$user_id', '$name','$comment','$rate')";

// when all details are stored to database take the user back to the track with the message
if($connection->query($sql) === TRUE) {
    header("location: artist.php?id=$id&review=suc");
}else {
    // If result not matched, it redirects to tracks page
    header("location: artist.php?id=$id");
}