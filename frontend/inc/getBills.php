<?php 
$mysqli = new mysqli("localhost", "root", "mysql", "fourthbranch"); 
# Number of entries to load per page. 
$limit = 5;
# Get the page number from GET, or set it to 0.
$index = isset ( $_GET['page'] ) && $_GET['page'] ? (int) $_GET['page'] : 0;
$page = $index * $limit;
# Get the total number of posts. We need this to know when we've reached the last # page. 
# You probably want to do some error handling here, if mysql queries fail. 
$statement = $mysqli->prepare ("SELECT COUNT(*) FROM bills");
$statement->execute();
$statement->bind_result($count);
$statement->fetch();
#The result is now in the $count variable.
$statement->close();
if (!empty($_REQUEST['term'])) {
$term = mysqli_real_escape_string($db_conx, $_REQUEST['term']);
}
?>