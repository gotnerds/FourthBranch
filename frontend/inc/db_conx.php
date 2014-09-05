<?php
    $db_conx = 
        mysqli_connect("fourthbranch.db.9192271.hostedresource.com", "fourthbranch", "G0tnerds!", "fourthbranch");
    // Evaluate the connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }
?>
