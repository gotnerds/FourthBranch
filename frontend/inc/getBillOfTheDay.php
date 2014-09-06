<?php
$sql = mysqli_query($db_conx, "SELECT * FROM bills WHERE id = 1");
$billOfTheDay = mysqli_fetch_array($sql);
$sqlrow = $billOfTheDay;
$billOfTheDayConvert = str_replace("html", "json", $sqlrow['local_html']);
//$billOfTheDayJson = file_get_contents("C:\Ampps\www\FourthBranch\FourthBranch\outside_resources\\".str_replace("/", "\\", $billOfTheDayConvert));
$billOfTheDayHtml = file_get_contents("./cgi-bin/".$billOfTheDayConvert);
$billOfTheDayJsonDecoded = json_decode($billOfTheDayJson, true);
$billJsonSnippit = $billOfTheDayJsonDecoded['summary']['text'];
?>