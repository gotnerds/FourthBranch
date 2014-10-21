<?php ob_start(); ?>
<?php
session_start();
	include("../inc/db_conx.php");
$con = $db_conx;
$sql="select * from individuals";
$query=mysqli_query($con,$sql);

$st=$_GET['status'];
$id=$_GET['id'];
$email=$_GET['email'];
		if($st=="Inactive"){
			$sql1="update users set activated='1' where id=$id";
			$query1=mysqli_query($con,$sql1);
            emailsent($email);
			echo"<script>window.location='index.php'</script>";
			
		}
	 if($st=="Active"){
			$sql1="update users set activated='0' where id=$id";
			$query1=mysqli_query($con,$sql1);
			echo"<script>window.location='denialemail.php?id=$id&email=$email'</script>";
			
		}

function emailsent($eml){
    $msg="Request Approve ";
if(mail($eml,"Admin",$msg,"From : Info@thefourthbranch.co"))
    echo "<script> alert('Approval Email Sent !');</script>";

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
                        
                        
                        <h4 class="widgettitle"><span class="icon-comment icon-white"></span>All Users</h4>
                        <div class="widgetcontent nopadding">
                          
                        </div>
                        <div class="row-fluid">

                        		<table class="table">
                        		<tr>
                        			<th> Username </th>
                        			<th> Email </th>
                        			<th> First Name </th>
                        			<th> Last Name </th>
                        			<th> Type </th>

                        			<th> View </th>
                        			<th> Status </th>
                        		</tr>
                        		
                        			
                        				<?php
                        					while($res=mysqli_fetch_assoc($query)){
                        						$username=$res['username'];
                        						$email=$res['email'];
                        						$firstname=$res['firstName'];
                        						$lastname=$res['lastName'];
                        						$type=$res['userType'];
                        						$id=$res['id'];
                        						$activate=$res['activated'];
                        						if($type=="i"){
                        							$typefull="Individual";
                        						}
                        						else if($type=="o"){
                        							$typefull="Organization";
                        						}

                        						if($activate=="0"){
                        								$status="Inactive";
                        						}
                        						else if($activate=="1"){
                        								$status="Active";
                        						}
                        					echo "<tr>
                        						<td>
                        							$username
                        						</td>
                        						<td>
                        							$email
                        						</td>
                        						<td>
                        							$firstname
                        						</td>
                        						<td>
                        							$lastname
                        						</td>
                        						<td>
                        							$typefull
                        						</td>

                        							<td>
                        							<a href='view.profile.php?id=$id' >View Profile</a>
                        						</td>

                        						<td>
                        							<a href='index.php?status=$status&id=$id&email=$email' >$status</a>
                        						</td>

                        					</tr>";
                        					}
                        				?>

                        		</table>

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
