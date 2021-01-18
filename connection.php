<?php
$connection = mysqli_connect("localhost", "kstylianou1", "FxoL2584", "kstylianou1");
if (mysqli_connect_errno()) {
    echo "ERROR: could not connect to database: " . mysqli_connect_error();
}