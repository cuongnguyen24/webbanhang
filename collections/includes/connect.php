<?php

    $conn = mysqli_connect('localhost', 'root', '', 'webbanhang');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

?>