<?php
/* Kyriakos Stylianou
 * Log out page to destroy the session and redirect the user to index page
 */
session_start();
session_destroy();
header("location: index.php");