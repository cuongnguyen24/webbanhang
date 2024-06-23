<?php

    $conn = mysqli_connect('localhost', 'root', '', 'websitebanhang');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

?>