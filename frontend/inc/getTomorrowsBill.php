<?php
$sql = mysqli_query($db_conx, "SELECT * FROM bills WHERE id = 2");
$tomorrowsBill = mysqli_fetch_array($sql);
$sqlrow = $tomorrowsBill;
$tomorrowsBillConvert = str_replace("html", "json", $sqlrow['local_html']);
//$tomorrowsBillJson = file_get_contents("C:\Ampps\www\FourthBranch\FourthBranch\outside_resources\\".str_replace("/", "\\", $tomorrowsBillConvert));
$tomorrowsBillJson = file_get_contents("./cgi-bin/".$tomorrowsBillConvert);
$tomorrowsBillJsonDecoded = json_decode($tomorrowsBillJson, true);
$tomorrowsBillJsonSnippit = $tomorrowsBillJsonDecoded['summary']['text'];
?>