<?php
include("include/dbcon.php");

if (isset($_POST["pnews1pic"])) {
$pnews1pic = mysqli_real_escape_string($con, $_POST["pnews1pic"]);
$pnews1url = mysqli_real_escape_string($con, $_POST["pnews1url"]);
$pnews1title = mysqli_real_escape_string($con, $_POST["pnews1title"]);
$pnews2pic = mysqli_real_escape_string($con, $_POST["pnews2pic"]);
$pnews2url = mysqli_real_escape_string($con, $_POST["pnews2url"]);
$pnews2title = mysqli_real_escape_string($con, $_POST["pnews2title"]);
$pnews3pic = mysqli_real_escape_string($con, $_POST["pnews3pic"]);
$pnews3url = mysqli_real_escape_string($con, $_POST["pnews3url"]);
$pnews3title = mysqli_real_escape_string($con, $_POST["pnews3title"]);
$pnews4pic = mysqli_real_escape_string($con, $_POST["pnews4pic"]);
$pnews4url = mysqli_real_escape_string($con, $_POST["pnews4url"]);
$pnews4title = mysqli_real_escape_string($con, $_POST["pnews4title"]);
$pnews5pic = mysqli_real_escape_string($con, $_POST["pnews5pic"]);
$pnews5url = mysqli_real_escape_string($con, $_POST["pnews5url"]);
$pnews5title = mysqli_real_escape_string($con, $_POST["pnews5title"]);
$enews1pic = mysqli_real_escape_string($con, $_POST["enews1pic"]);
$enews1url = mysqli_real_escape_string($con, $_POST["enews1url"]);
$enews1title = mysqli_real_escape_string($con, $_POST["enews1title"]);
$enews2pic = mysqli_real_escape_string($con, $_POST["enews2pic"]);
$enews2url = mysqli_real_escape_string($con, $_POST["enews2url"]);
$enews2title = mysqli_real_escape_string($con, $_POST["enews2title"]);
$enews3pic = mysqli_real_escape_string($con, $_POST["enews3pic"]);
$enews3url = mysqli_real_escape_string($con, $_POST["enews3url"]);
$enews3title = mysqli_real_escape_string($con, $_POST["enews3title"]);
$enews4pic = mysqli_real_escape_string($con, $_POST["enews4pic"]);
$enews4url = mysqli_real_escape_string($con, $_POST["enews4url"]);
$enews4title = mysqli_real_escape_string($con, $_POST["enews4title"]);
$enews5pic = mysqli_real_escape_string($con, $_POST["enews5pic"]);
$enews5url = mysqli_real_escape_string($con, $_POST["enews5url"]);
$enews5title = mysqli_real_escape_string($con, $_POST["enews5title"]);
$jnews1pic = mysqli_real_escape_string($con, $_POST["jnews1pic"]);
$jnews1url = mysqli_real_escape_string($con, $_POST["jnews1url"]);
$jnews1title = mysqli_real_escape_string($con, $_POST["jnews1title"]);
$jnews2pic = mysqli_real_escape_string($con, $_POST["jnews2pic"]);
$jnews2url = mysqli_real_escape_string($con, $_POST["jnews2url"]);
$jnews2title = mysqli_real_escape_string($con, $_POST["jnews2title"]);
$jnews3pic = mysqli_real_escape_string($con, $_POST["jnews3pic"]);
$jnews3url = mysqli_real_escape_string($con, $_POST["jnews3url"]);
$jnews3title = mysqli_real_escape_string($con, $_POST["jnews3title"]);
$jnews4pic = mysqli_real_escape_string($con, $_POST["jnews4pic"]);
$jnews4url = mysqli_real_escape_string($con, $_POST["jnews4url"]);
$jnews4title = mysqli_real_escape_string($con, $_POST["jnews4title"]);
$jnews5pic = mysqli_real_escape_string($con, $_POST["jnews5pic"]);
$jnews5url = mysqli_real_escape_string($con, $_POST["jnews5url"]);
$jnews5title = mysqli_real_escape_string($con, $_POST["jnews5title"]);
$snews1pic = mysqli_real_escape_string($con, $_POST["snews1pic"]);
$snews1url = mysqli_real_escape_string($con, $_POST["snews1url"]);
$snews1title = mysqli_real_escape_string($con, $_POST["snews1title"]);
$snews2pic = mysqli_real_escape_string($con, $_POST["snews2pic"]);
$snews2url = mysqli_real_escape_string($con, $_POST["snews2url"]);
$snews2title = mysqli_real_escape_string($con, $_POST["snews2title"]);
$snews3pic = mysqli_real_escape_string($con, $_POST["snews3pic"]);
$snews3url = mysqli_real_escape_string($con, $_POST["snews3url"]);
$snews3title = mysqli_real_escape_string($con, $_POST["snews3title"]);
$snews4pic = mysqli_real_escape_string($con, $_POST["snews4pic"]);
$snews4url = mysqli_real_escape_string($con, $_POST["snews4url"]);
$snews4title = mysqli_real_escape_string($con, $_POST["snews4title"]);
$snews5pic = mysqli_real_escape_string($con, $_POST["snews5pic"]);
$snews5url = mysqli_real_escape_string($con, $_POST["snews5url"]);
$snews5title = mysqli_real_escape_string($con, $_POST["snews5title"]);
$unews1pic = mysqli_real_escape_string($con, $_POST["unews1pic"]);
$unews1url = mysqli_real_escape_string($con, $_POST["unews1url"]);
$unews1title = mysqli_real_escape_string($con, $_POST["unews1title"]);
$unews2pic = mysqli_real_escape_string($con, $_POST["unews2pic"]);
$unews2url = mysqli_real_escape_string($con, $_POST["unews2url"]);
$unews2title = mysqli_real_escape_string($con, $_POST["unews2title"]);
$unews3pic = mysqli_real_escape_string($con, $_POST["unews3pic"]);
$unews3url = mysqli_real_escape_string($con, $_POST["unews3url"]);
$unews3title = mysqli_real_escape_string($con, $_POST["unews3title"]);
$unews4pic = mysqli_real_escape_string($con, $_POST["unews4pic"]);
$unews4url = mysqli_real_escape_string($con, $_POST["unews4url"]);
$unews4title = mysqli_real_escape_string($con, $_POST["unews4title"]);
$unews5pic = mysqli_real_escape_string($con, $_POST["unews5pic"]);
$unews5url = mysqli_real_escape_string($con, $_POST["unews5url"]);
$unews5title = mysqli_real_escape_string($con, $_POST["unews5title"]);
$hnews1pic = mysqli_real_escape_string($con, $_POST["hnews1pic"]);
$hnews1url = mysqli_real_escape_string($con, $_POST["hnews1url"]);
$hnews1title = mysqli_real_escape_string($con, $_POST["hnews1title"]);
$hnews2pic = mysqli_real_escape_string($con, $_POST["hnews2pic"]);
$hnews2url = mysqli_real_escape_string($con, $_POST["hnews2url"]);
$hnews1title = mysqli_real_escape_string($con, $_POST["hnews2title"]);
$hnews3pic = mysqli_real_escape_string($con, $_POST["hnews3pic"]);
$hnews3url = mysqli_real_escape_string($con, $_POST["hnews3url"]);
$hnews3title = mysqli_real_escape_string($con, $_POST["hnews3title"]);
$hnews4pic = mysqli_real_escape_string($con, $_POST["hnews4pic"]);
$hnews4url = mysqli_real_escape_string($con, $_POST["hnews4url"]);
$hnews4title = mysqli_real_escape_string($con, $_POST["hnews4title"]);
$hnews5pic = mysqli_real_escape_string($con, $_POST["hnews5pic"]);
$hnews5url = mysqli_real_escape_string($con, $_POST["hnews5url"]);
$hnews5title = mysqli_real_escape_string($con, $_POST["hnews5title"]);
$mnews1pic = mysqli_real_escape_string($con, $_POST["mnews1pic"]);
$mnews1url = mysqli_real_escape_string($con, $_POST["mnews1url"]);
$mnews1title = mysqli_real_escape_string($con, $_POST["mnews1title"]);
$mnews2pic = mysqli_real_escape_string($con, $_POST["mnews2pic"]);
$mnews2url = mysqli_real_escape_string($con, $_POST["mnews2url"]);
$mnews2title = mysqli_real_escape_string($con, $_POST["mnews2title"]);
$mnews3pic = mysqli_real_escape_string($con, $_POST["mnews3pic"]);
$mnews3url = mysqli_real_escape_string($con, $_POST["mnews3url"]);
$mnews3title = mysqli_real_escape_string($con, $_POST["mnews3title"]);
$mnews4pic = mysqli_real_escape_string($con, $_POST["mnews4pic"]);
$mnews4url = mysqli_real_escape_string($con, $_POST["mnews4url"]);
$mnews5pic = mysqli_real_escape_string($con, $_POST["mnews5pic"]);
$mnews5url = mysqli_real_escape_string($con, $_POST["mnews5url"]);
$evnews1pic = mysqli_real_escape_string($con, $_POST["evnews1pic"]);
$evnews1url = mysqli_real_escape_string($con, $_POST["evnews1url"]);
$evnews2pic = mysqli_real_escape_string($con, $_POST["evnews2pic"]);
$evnews2url = mysqli_real_escape_string($con, $_POST["evnews2url"]);
$evnews3pic = mysqli_real_escape_string($con, $_POST["evnews3pic"]);
$evnews3url = mysqli_real_escape_string($con, $_POST["evnews3url"]);
$evnews4pic = mysqli_real_escape_string($con, $_POST["evnews4pic"]);
$evnews4url = mysqli_real_escape_string($con, $_POST["evnews4url"]);
$evnews5pic = mysqli_real_escape_string($con, $_POST["evnews5pic"]);
$evnews5url = mysqli_real_escape_string($con, $_POST["evnews5url"]);
$sql="UPDATE admin SET pnews1pic='$pnews1pic', pnews1url='$pnews1url', pnews2pic='$pnews2pic', pnews2url='$pnews2url', pnews3pic='$pnews3pic', pnews3url='$pnews3url', pnews4pic='$pnews4pic', pnews4url='$pnews4url', pnews5pic='$pnews5pic', pnews5url='$pnews5url',
							  enews1pic='$enews1pic', enews1url='$enews1url', enews2pic='$enews2pic', enews2url='$enews2url', enews3pic='$enews3pic', enews3url='$enews3url', enews4pic='$enews4pic', enews4url='$enews4url', enews5pic='$enews5pic', enews5url='$enews5url',	
							  jnews1pic='$jnews1pic', jnews1url='$jnews1url', jnews2pic='$jnews2pic', jnews2url='$jnews2url', jnews3pic='$jnews3pic', jnews3url='$jnews3url', jnews4pic='$jnews4pic', jnews4url='$jnews4url', jnews5pic='$jnews5pic', jnews5url='$jnews5url',		
							  snews1pic='$snews1pic', snews1url='$snews1url', snews2pic='$snews2pic', snews2url='$snews2url', snews3pic='$snews3pic', snews3url='$snews3url', snews4pic='$snews4pic', snews4url='$snews4url', snews5pic='$snews5pic', snews5url='$snews5url',
							  unews1pic='$unews1pic', unews1url='$unews1url', unews2pic='$unews2pic', unews2url='$unews2url', unews3pic='$unews3pic', unews3url='$unews3url', unews4pic='$unews4pic', unews4url='$unews4url', unews5pic='$unews5pic', unews5url='$unews5url',
							  hnews1pic='$hnews1pic', hnews1url='$hnews1url', hnews2pic='$hnews2pic', hnews2url='$hnews2url', hnews3pic='$hnews3pic', hnews3url='$hnews3url', hnews4pic='$hnews4pic', hnews4url='$hnews4url', hnews5pic='$hnews5pic', hnews5url='$hnews5url',
							  mnews1pic='$mnews1pic', mnews1url='$mnews1url', mnews2pic='$mnews2pic', mnews2url='$mnews2url', mnews3pic='$mnews3pic', mnews3url='$mnews3url', mnews4pic='$mnews4pic', mnews4url='$mnews4url', mnews5pic='$mnews5pic', mnews5url='$mnews5url',
							  evnews1pic='$evnews1pic', evnews1url='$evnews1url', evnews2pic='$evnews2pic', evnews2url='$evnews2url', evnews3pic='$evnews3pic', evnews3url='$evnews3url', evnews4pic='$evnews4pic', evnews4url='$evnews4url', evnews5pic='$evnews5pic', evnews5url='$evnews5url'
							  WHERE id='1'";
if (!mysqli_query($con,$sql))
  {
  die('Error: ' . mysqli_error($con));
  }
$succesful = "update successful";
}
?>


<html>

<!-- Mirrored from demo.themepixels.com/webpage/shamcey/dashboard.html by HTTrack Website Copier/3.x [XR&CO'2013], Sat, 25 Jan 2014 06:34:05 GMT -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Admin Panel</title>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />

<link rel="stylesheet" href="css/responsive-tables.css">
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.min.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.min.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="js/responsive-tables.js"></script>
<script type="text/javascript" src="js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
</head>

<body>

<div id="mainwrapper" class="mainwrapper">
    
    <?php
    	include("header.php");
    	include("leftbar.php")
    ?>
    
 
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="dashboard.html"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>Dashboard</li>
            <li class="right">
                  
            </li>
        </ul>
        
        <div class="pageheader">
            <form action="http://demo.themepixels.com/webpage/shamcey/results.html" method="post" class="searchbar">
                <input type="text" name="keyword" placeholder="To search type and hit enter..." />
            </form>
            <div class="pageicon"><span class="iconfa-laptop"></span></div>
            <div class="pagetitle">
                
                <h1>Dashboard</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
                <div class="row-fluid">
                    <div id="dashboard">
                        
                        
                        <h4 class="widgettitle"><span class="icon-comment icon-white"></span>News</h4>
                        <div class="widgetcontent nopadding">
                          
                        </div>
                        <div class="row-fluid">

                        		
                                <h3 align="center">Politics as Usual</h3>
								<?php if (isset($_POST["pnews1pic"])){echo $succesful;} ?>
                                <form action="news.php" method="post" name="form" id="form">
                                <p> News box 1 </p>
                                picture url: <input type="text" id="pnews1pic" name="pnews1pic" size="50">
                                url link to article: <input type="text" id="pnews1url" name="pnews1url" size="50">
                                <p> News box 2 </p>
                                picture url: <input type="text" id="pnews2pic" name="pnews2pic" size="50">
                                url link to article: <input type="text" id="pnews2url" name="pnews2url" size="50">
                                <p> News box 3 </p>
                                picture url: <input type="text" id="pnews3pic" name="pnews3pic" size="50">
                                url link to article: <input type="text" id="pnews3url" name="pnews3url" size="50">
                                <p> News box 4 </p>
                                picture url: <input type="text" id="pnews4pic" name="pnews4pic" size="50">
                                url link to article: <input type="text" id="pnews4url" name="pnews4url" size="50">
                                <p> News box 5 </p>
                                picture url: <input type="text" id="pnews5pic" name="pnews5pic" size="50">
                                url link to article: <input type="text" id="pnews5url" name="pnews5url" size="50">
                                
                                <h3 align="center">Economy</h3>
                                <p> News box 1 </p>
                                picture url: <input type="text" id="enews1pic" name="enews1pic" size="50">
                                url link to article: <input type="text" id="enews1url" name="enews1url" size="50">
                                <p> News box 2 </p>
                                picture url: <input type="text" id="enews2pic" name="enews2pic" size="50">
                                url link to article: <input type="text" id="enews2url" name="enews2url" size="50">
                                <p> News box 3 </p>
                                picture url: <input type="text" id="enews3pic" name="enews3pic" size="50">
                                url link to article: <input type="text" id="enews3url" name="enews3url" size="50">
                                <p> News box 4 </p>
                                picture url: <input type="text" id="enews4pic" name="enews4pic" size="50">
                                url link to article: <input type="text" id="enews4url" name="enews4url" size="50">
                                <p> News box 5 </p>
                                picture url: <input type="text" id="enews5pic" name="enews5pic" size="50">
                                url link to article: <input type="text" id="enews5url" name="enews5url" size="50">
                                
                                <h3 align="center">Justice</h3>
                                <p> News box 1 </p>
                                picture url: <input type="text" id="jnews1pic" name="jnews1pic" size="50">
                                url link to article: <input type="text" id="jnews1url" name="jnews1url" size="50">
                                <p> News box 2 </p>
                                picture url: <input type="text" id="jnews2pic" name="jnews2pic" size="50">
                                url link to article: <input type="text" id="jnews2url" name="jnews2url" size="50">
                                <p> News box 3 </p>
                                picture url: <input type="text" id="jnews3pic" name="jnews3pic" size="50">
                                url link to article: <input type="text" id="jnews3url" name="jnews3url" size="50">
                                <p> News box 4 </p>
                                picture url: <input type="text" id="jnews4pic" name="jnews4pic" size="50">
                                url link to article: <input type="text" id="jnews4url" name="jnews4url" size="50">
                                <p> News box 5 </p>
                                picture url: <input type="text" id="jnews5pic" name="jnews5pic" size="50">
                                url link to article: <input type="text" id="jnews5url" name="jnews5url" size="50">
                            
                                <h3 align="center">Social</h3>
                                <p> News box 1 </p>
                                picture url: <input type="text" id="snews1pic" name="snews1pic" size="50">
                                url link to article: <input type="text" id="snews1url" name="snews1url" size="50">
                                <p> News box 2 </p>
                                picture url: <input type="text" id="snews2pic" name="snews2pic" size="50">
                                url link to article: <input type="text" id="snews2url" name="snews2url" size="50">
                                <p> News box 3 </p>
                                picture url: <input type="text" id="snews3pic" name="snews3pic" size="50">
                                url link to article: <input type="text" id="snews3url" name="snews3url" size="50">
                                <p> News box 4 </p>
                                picture url: <input type="text" id="snews4pic" name="snews4pic" size="50">
                                url link to article: <input type="text" id="snews4url" name="snews4url" size="50">
                                <p> News box 5 </p>
                                picture url: <input type="text" id="snews5pic" name="snews5pic" size="50">
                                url link to article: <input type="text" id="snews5url" name="snews5url" size="50">
                            
                                <h3 align="center">US</h3> 
                                <p> News box 1 </p>
                                picture url: <input type="text" id="unews1pic" name="unews1pic" size="50">
                                url link to article: <input type="text" id="unews1url" name="unews1url" size="50">
                                <p> News box 2 </p>
                                picture url: <input type="text" id="unews2pic" name="unews2pic" size="50">
                                url link to article: <input type="text" id="unews2url" name="unews2url" size="50">
                                <p> News box 3 </p>
                                picture url: <input type="text" id="unews3pic" name="unews3pic" size="50">
                                url link to article: <input type="text" id="unews3url" name="unews3url" size="50">
                                <p> News box 4 </p>
                                picture url: <input type="text" id="unews4pic" name="unews4pic" size="50">
                                url link to article: <input type="text" id="unews4url" name="unews4url" size="50">
                                <p> News box 5 </p>
                                picture url: <input type="text" id="unews5pic" name="unews5pic" size="50">
                                url link to article: <input type="text" id="unews5url" name="unews5url" size="50">
                            
                                <h3 align="center">Healthcare</h3>
                                <p> News box 1 </p>
                                picture url: <input type="text" id="hnews1pic" name="hnews1pic" size="50">
                                url link to article: <input type="text" id="hnews1url" name="hnews1url" size="50">
                                <p> News box 2 </p>
                                picture url: <input type="text" id="hnews2pic" name="hnews2pic" size="50">
                                url link to article: <input type="text" id="hnews2url" name="hnews2url" size="50">
                                <p> News box 3 </p>
                                picture url: <input type="text" id="hnews3pic" name="hnews3pic" size="50">
                                url link to article: <input type="text" id="hnews3url" name="hnews3url" size="50">
                                <p> News box 4 </p>
                                picture url: <input type="text" id="hnews4pic" name="hnews4pic" size="50">
                                url link to article: <input type="text" id="hnews4url" name="hnews4url" size="50">
                                <p> News box 5 </p>
                                picture url: <input type="text" id="hnews5pic" name="hnews5pic" size="50">
                                url link to article: <input type="text" id="hnews5url" name="hnews5url" size="50">
                            
                                <h3 align="center">Military</h3>
                                <p> News box 1 </p>
                                picture url: <input type="text" id="mnews1pic" name="mnews1pic" size="50">
                                url link to article: <input type="text" id="mnews1url" name="mnews1url" size="50">
                                <p> News box 2 </p>
                                picture url: <input type="text" id="mnews2pic" name="mnews2pic" size="50">
                                url link to article: <input type="text" id="mnews2url" name="mnews2url" size="50">
                                <p> News box 3 </p>
                                picture url: <input type="text" id="mnews3pic" name="mnews3pic" size="50">
                                url link to article: <input type="text" id="mnews3url" name="mnews3url" size="50">
                                <p> News box 4 </p>
                                picture url: <input type="text" id="mnews4pic" name="mnews4pic" size="50">
                                url link to article: <input type="text" id="mnews4url" name="mnews4url" size="50">
                                <p> News box 5 </p>
                                picture url: <input type="text" id="mnews5pic" name="mnews5pic" size="50">
                                url link to article: <input type="text" id="mnews5url" name="mnews5url" size="50">
                            
                                <h3 align="center">Environment</h3>
                                <p> News box 1 </p>
                                picture url: <input type="text" id="evnews1pic" name="evnews1pic" size="50">
                                url link to article: <input type="text" id="evnews1url" name="evnews1url" size="50">
                                <p> News box 2 </p>
                                picture url: <input type="text" id="evnews2pic" name="evnews2pic" size="50">
                                url link to article: <input type="text" id="evnews2url" name="evnews2url" size="50">
                                <p> News box 3 </p>
                                picture url: <input type="text" id="evnews3pic" name="evnews3pic" size="50">
                                url link to article: <input type="text" id="evnews3url" name="evnews3url" size="50">
                                <p> News box 4 </p>
                                picture url: <input type="text" id="evnews4pic" name="evnews4pic" size="50">
                                url link to article: <input type="text" id="evnews4url" name="evnews4url" size="50">
                                <p> News box 5 </p>
                                picture url: <input type="text" id="evnews5pic" name="evnews5pic" size="50">
                                url link to article: <input type="text" id="evnews5url" name="evnews5url" size="50">
                                
                                <p><input id="button" type="submit"></p>
                                </form>

                        </div>
                        <br />
                        
                        
                    </div><!--span8-->
                    
                    <!--span4-->
                </div><!--row-fluid-->
                
                <div class="footer">
                    <div class="footer-left">
                       
                    </div>
                    <div class="footer-right">
                        
                    </div>
                </div><!--footer-->
                
            </div><!--maincontentinner-->
        </div><!--maincontent-->
        
    </div><!--rightpanel-->
    
</div><!--mainwrapper-->
<script type="text/javascript">
    jQuery(document).ready(function() {
        
      // simple chart
		var flash = [[0, 11], [1, 9], [2,12], [3, 8], [4, 7], [5, 3], [6, 1]];
		var html5 = [[0, 5], [1, 4], [2,4], [3, 1], [4, 9], [5, 10], [6, 13]];
      var css3 = [[0, 6], [1, 1], [2,9], [3, 12], [4, 10], [5, 12], [6, 11]];
			
		function showTooltip(x, y, contents) {
			jQuery('<div id="tooltip" class="tooltipflot">' + contents + '</div>').css( {
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 5
			}).appendTo("body").fadeIn(200);
		}
	
			
		var plot = jQuery.plot(jQuery("#chartplace"),
			   [ { data: flash, label: "Flash(x)", color: "#6fad04"},
              { data: html5, label: "HTML5(x)", color: "#06c"},
              { data: css3, label: "CSS3", color: "#666"} ], {
				   series: {
					   lines: { show: true, fill: true, fillColor: { colors: [ { opacity: 0.05 }, { opacity: 0.15 } ] } },
					   points: { show: true }
				   },
				   legend: { position: 'nw'},
				   grid: { hoverable: true, clickable: true, borderColor: '#666', borderWidth: 2, labelMargin: 10 },
				   yaxis: { min: 0, max: 15 }
				 });
		
		var previousPoint = null;
		jQuery("#chartplace").bind("plothover", function (event, pos, item) {
			jQuery("#x").text(pos.x.toFixed(2));
			jQuery("#y").text(pos.y.toFixed(2));
			
			if(item) {
				if (previousPoint != item.dataIndex) {
					previousPoint = item.dataIndex;
						
					jQuery("#tooltip").remove();
					var x = item.datapoint[0].toFixed(2),
					y = item.datapoint[1].toFixed(2);
						
					showTooltip(item.pageX, item.pageY,
									item.series.label + " of " + x + " = " + y);
				}
			
			} else {
			   jQuery("#tooltip").remove();
			   previousPoint = null;            
			}
		
		});
		
		jQuery("#chartplace").bind("plotclick", function (event, pos, item) {
			if (item) {
				jQuery("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");
				plot.highlight(item.series, item.datapoint);
			}
		});
    
        
        //datepicker
        jQuery('#datepicker').datepicker();
        
        // tabbed widget
        jQuery('.tabbedwidget').tabs();
        
        
    
    });
</script>
</body>

<!-- Mirrored from demo.themepixels.com/webpage/shamcey/dashboard.html by HTTrack Website Copier/3.x [XR&CO'2013], Sat, 25 Jan 2014 06:34:07 GMT -->
</html>
