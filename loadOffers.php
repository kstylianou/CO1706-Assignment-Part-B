<?php
/* Kyriakos Stylianou
 * This page is only for request from javascript it loads the offer detail with the given id and return it to json encode format
 * This page is only used on account.php
 */
include('connection.php'); // Database connection
$offer_id = htmlspecialchars($_GET['offer_id']);
$offers = "SELECT * FROM `offers` WHERE offer_id = '$offer_id'"; // Select of offer by its id
$results = mysqli_query($connection,$offers);
$arr = array();
while($row = mysqli_fetch_array($results)) {
    array_push($arr, $row); // push the row to array
}
echo json_encode($arr); // encode array to json
