<?php

    $conn = mysqli_connect('192.168.1.208', 'myuser', '12ssss21', 'myproject_db');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

?>
