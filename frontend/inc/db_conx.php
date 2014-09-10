<?php
    $db_conx = 
        mysqli_connect("localhost", "root", "mysql", "fourthbranch");
    // Evaluate the connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }
    $db_host = 'localhost';
$db_name = 'fourthbranch';
$db_user = 'root';
$db_pass = 'mysql';
try {
$pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
