<?php

  $conn = mysqli_connect('localhost', 'myuser', 'linh123@', 'myproject_db');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

?>
