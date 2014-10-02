
<?php

//$db_conx = mysqli_connect("thefourthbranch.db.11457088.hostedresource.com", "thefourthbranch", "Computer123A@", "thefourthbranch");
// Evaluate the connection
$con = mysqli_connect("localhost", "root", "mysql", "fourthbranch");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
?>