<!--
    Kyriakos Stylianou
    Error 404 page when the page tha user search does not exist it redirect here.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error 404</title>
    <link rel="stylesheet"  href="css/navbar.css">
    <link rel="stylesheet"  href="css/homepage.css">
    <link rel="stylesheet"  href="css/error404.css">
    <script src="js/navbar.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

</head>
<body>

<!-- Including Navigation bar -->
<?php include('navbar.php'); ?>

<div id="notfound">
    <div class="notfound">
        <div class="notfound-404">
            <h1>404</h1>
        </div>
        <h2>Oops! This Page Could Not Be Found</h2>
        <p>Sorry but the page you are looking for does not exist, have been removed. name changed or is temporarily unavailable</p>
        <a href="index.php">Go To Homepage</a>
    </div>
</div>
