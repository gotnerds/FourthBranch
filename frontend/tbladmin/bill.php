
<?php
include("../inc/db_conx.php");
$con = $db_conx;
$billid=$_GET['id'];

if(isset($billid)){

}
if(isset($_POST['billId'])){
    #var_dump($_POST);
    $alive_date = "'".$_POST['alive_date']."'";
    $sql="SELECT * FROM summaries_bill_of_the_day";
    $result=mysqli_query($con,$sql);
    $selected_summary_id = mysqli_num_rows($result);
    $selected_summary_id++;
    $billid = $_POST['billId'];
    $sql="SELECT * FROM bill_of_the_day";
    $results=mysqli_query($con,$sql);
    $bill_of_the_day_id = mysqli_num_rows($results);
    $bill_of_the_day_id++;
    $submitted_summary = "'".$_POST['submitted_summary']."'";
    $user = 1;
    $date = "'".date("Y-m-d")."'";
    #print_r($alive_date.", ".$selected_summary_id.", ".$billid.", ".$bill_of_the_day_id.", ".$submitted_summary.", ".$user.", ".$date);
	$sqlbod = "INSERT INTO bill_of_the_day (`alive_date`, `selected_summary`, `bill_id`) values($alive_date, $selected_summary_id, $billid)";
    $sqlsummary = "INSERT INTO summaries_bill_of_the_day (`bill_of_the_day`, `submitted_summary`, `user`, `date`) VALUES ($bill_of_the_day_id, $submitted_summary, $user, $date)";
    $query13 = mysqli_query($con,$sqlbod);
    $query12= mysqli_query($con,$sqlsummary);
    if(!$query12 && !$query13){
    	echo "NOt Working".mysqli_error($con);

    } else{
    echo " <script>alert('Updated Bill Of The Day !'); </script>";
    }
}

# Search function of the Bill
if(isset($_POST['keyword'])){
    $q = '';
    $q = $_POST['keyword'];
    if(is_numeric($q)){
        
        $sql="select * from bills WHERE code = ".$q." order by id desc";
        $query=mysqli_query($con,$sql);
    }else{
        
        $sql="SELECT * from bills WHERE title LIKE '%".$q."%' ORDER BY id DESC LIMIT 100";
        $query=mysqli_query($con,$sql);
    }
}else{
    $sql="select * from bills order by id desc limit 100";
    $query=mysqli_query($con,$sql);
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
<!--<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>-->
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
<style>

	#bod{
	font-weight:bold;
}
	#bod:hover{
	color:red
}

</style>

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
            <form action="bill.php" method="post" class="searchbar">
                <input type="text" name="keyword" id="searchkeyword" placeholder="To search type and hit enter..." />
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
                        
                        
                        
                        
                        <div class="row-fluid">

                        		<table class="table">
                        		<tr>
                        			<th> Bill Code </th>
                        			<th> Bill Subject </th>
                        			<th> Bill Title </th>
                        			
                        			<th> View </th>
                        			<th> Status </th>
									<th>Bill Of The Day</th>
                        		</tr>
                        		
                        			
                        				<?php
                                            if (isset($query) && !empty($query)) {
                        					   while($res=mysqli_fetch_assoc($query)){
                                                $id=$res['id'];
                        						$billcode=$res['code'];
                        						$billtype=$res['billType'];
                                                $billsubject=$res['subject'];
                        						$title=$res['title'];
                        						$status = $res['status'];

                        						
                        					echo "<tr>
                        						<td>
                        							$billcode
                        						</td>
                        						<td>
                        							$billsubject
                        						</td>
                        						<td>
                        							$title
                        						</td>

                        							<td>
                        							<a href='view.bill.php?id=$id' >View </a>
                        						</td>

                        						<td>
                        							<a href='edit.bill.php?id=$id' >Edit</a>
                        						</td>
										        <td>
                                                    <a href='#myModal".$id."' class='modalLink' data-toggle='modal' style='display:none;'>bod</a>
                                                    <span class='btn btn-primary bodModal' data-billId='".$id."'>BOD</span>  
                                                </td>

                        					</tr>";
                        					}
                                        }else{
                                                echo '<tr><td colspan="6">Sorry, there are no Records Found...</td></tr>';
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
<a href='bill.php?id=$id' id='bod' title='Bill Of The Day' >BOD</a>

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
