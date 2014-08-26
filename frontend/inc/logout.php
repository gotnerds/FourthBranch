<?php
session_start();
if(session_destroy()) //Destroying all sessions
{
header("Location: ../index1.php"); //Redirecting to home page
}
?>