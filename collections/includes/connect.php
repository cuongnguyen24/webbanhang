<?php

    $conn = mysqli_connect('localhost', 'myuser', '12ssss21', 'myproject_db');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

?>
