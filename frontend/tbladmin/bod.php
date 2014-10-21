<?php
include("../inc/db_conx.php");
$con = $db_conx;
$id=$_GET['id'];
$sql="select * from bill where id=$id";
$query=mysqli_query($con,$sql);
while($res=mysqli_fetch_array($query)){
$billtype=$res['billType'];
$bp=$res['b_or_p'];
$proposal1=$res['proposalCategory1'];
$proposal2=$res['proposalCategory2'];
$proposal3=$res['proposalCategory3'];
$title=$res['title'];
$date1=$res['dateIssued'];
$submitted=$res['submittedBy'];
$status=$res['status'];
$content=$res['content'];
$summary=$res['summary'];
$summarysubmit=$res['summarysubmit'];
$billcode=$res['billcode'];
$hyperlink=$res['hyperlinck'];
$cause=$res['cause'];
$legal=$res['legalStatus'];


}




?>


<html>

<head>
<style>
.wrapper
{
width:300px;
height:auto;
border:1px solid color:red;
}
.wrapper #title
{
width:auto;
height:70px;
border:1px solid color:black;



</style>

</head>

<body>
<div class="wrapper">
<div id="title">

<?php echo $title;?>
</div
<div id="billid">
<?php echo $billcode;?>
</div>
</div>
</body>


</html>