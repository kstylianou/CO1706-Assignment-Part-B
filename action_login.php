<?php
/* Kyriakos Stylianou
 * This page the user is sent from login page to get data from database about the user.
 */
session_start();
// if server request method post
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
//Database Connection
    include('connection.php');

    // Select from database details for the user if username and password are correct
    $sql = "SELECT id, username, name, offer_id FROM `login` WHERE username = '$username' AND password = sha1('$password')";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

// If result matched username and password, table row must be 1 row
    if ($count == 1) {
        $_SESSION['login_user'] = true;
        $_SESSION['username'] = htmlspecialchars($username);
        $_SESSION['id'] = htmlspecialchars($row['id']);
        echo $_SESSION['offer_id'] = htmlspecialchars($row['offer_id']);
        $_SESSION['name'] = htmlspecialchars($row['name']);
        header("location: index.php");
    } else {
        // If result not matched username and password, it redirects to login page with error message
        header("location: login.php?err=true");
    }
}