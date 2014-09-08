<?php
    $db_conx = 
        mysqli_connect("localhost", "root", "mysql", "fourthbranch");
    // Evaluate the connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }
?>
