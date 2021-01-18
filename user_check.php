<?php
/* Kyriakos Stylianou
 * This page is only used on register.php is called by xml javascript
 * It check if user exist and return true or false
 * This page because is sensitive information I use method post
 */
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $arr = array(); // Array to load the information and encode it in json format
    $username = htmlspecialchars($_POST['username']); // username
    include('connection.php'); // Database Connection
    // Select username
    $sql = "SELECT username FROM `login` WHERE username = '$username'";
    $result = mysqli_query($connection, $sql);
    // if username exist on database return true
    if (mysqli_num_rows($result) != 0) {
        $arr['exist'] = true;
    }else{
        // if username not exist on database return false
        $arr['exist'] = false;
    }
    echo json_encode($arr); // encode array in json format
}