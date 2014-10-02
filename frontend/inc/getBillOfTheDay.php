<?php
$sql = mysqli_query($db_conx, "SELECT * FROM bills WHERE id = 1");
$billOfTheDay = mysqli_fetch_array($sql);
$row = $billOfTheDay;
$billOfTheDayConvert = str_replace("html", "json", $row['local_html']);
$billOfTheDayJson = file_get_contents("C:\Ampps\www\FourthBranch\FourthBranch\outside_resources\\".str_replace("/", "\\", $billOfTheDayConvert));
//$billOfTheDayJson = file_get_contents("./cgi-bin/".$billOfTheDayConvert);
$billOfTheDayJsonDecoded = json_decode($billOfTheDayJson, true);
$billJsonSnippit = $billOfTheDayJsonDecoded['summary']['text'];
?>