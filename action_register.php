<?php
/* Kyriakos Stylianou
 * This page can only be access if there is post request.
 * It Inserts to databse and if everything is ok it login the user so no need to take user to login page
 * All the validations are on html form and javascript on page register.php
 * Username check is by java script fetch you can find it on page register.php line 111
 */
session_start();
// if server request method post
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']); // Get the user name
    $username = htmlspecialchars($_POST['username']); // username/nickname
    $plan = htmlspecialchars($_POST['plan']); // plan id
    $password = htmlspecialchars($_POST['password']); // password

    //Connection to Database
    include('connection.php');

    // insert to database
    $sql = "INSERT INTO `login`(`name`, `username`, `password`, `offer_id`) VALUES ('$name','$username', sha1('$password') , '$plan')";

    // if all data are inserted to database it selects and login the user
    if ($connection->query($sql) === TRUE) {
        $select = "SELECT id, username, name, offer_id FROM `login` WHERE username = '$username' AND password = sha1('$password')";
        $result = mysqli_query($connection, $select);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $_SESSION['login_user'] = true;
        $_SESSION['username'] = $username; // Set session username
        $_SESSION['id'] = $row['id']; // Set session id
        $_SESSION['name'] = $row['name']; // Set session name
        $_SESSION['offer_id'] = $row['offer_id']; // Set session offer id
        header("location: index.php"); // Take user to index page
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error; // if there is error it display it!
    }
    $connection->close(); // close connection
}