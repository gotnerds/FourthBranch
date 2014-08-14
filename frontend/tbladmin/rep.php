<?php

include("include/dbcon.php");
$id=$_GET['id'];

if( isset($_POST['billid']) && !empty($_POST['billid'])){
	if($_POST['type']=='add'){
		$sname1 = mysqli_real_escape_string($con,$_POST['sname1']);
		$agree = mysqli_real_escape_string($con,$_POST['agree']);
		$sname2 = mysqli_real_escape_string($con,$_POST['sname2']);
		$agree2 = mysqli_real_escape_string($con,$_POST['agree2']);
		$rname1 = mysqli_real_escape_string($con,$_POST['rname1']);
		$ragree1 = mysqli_real_escape_string($con,$_POST['ragree1']);
		$billid = mysqli_real_escape_string($con,$_POST['billid']);
		
		$sphoto1 = $_FILES["sphoto1"]["name"];
		$sphoto2 = $_FILES["sphoto2"]["name"];
		$rphoto1 = $_FILES["rphoto1"]["name"];
		
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		
		
		if(!empty($sphoto1)){
			$stemp1 = explode(".", $sphoto1);
			$sextension1 = end($stemp1);
			
			if( in_array($sextension1, $allowedExts) ){
				if ($_FILES["sphoto1"]["error"] > 0){
					echo "Return Code: " . $_FILES["sphoto1"]["error"] . "<br>";
				}else{
				  move_uploaded_file($_FILES["sphoto1"]["tmp_name"], "../senator/" . $_FILES["sphoto1"]["name"]);
				}	
			}
		}
		
		if(!empty($sphoto2)){
			$stemp2 = explode(".", $sphoto2);
			$sextension2 = end($stemp2);
			
			if( in_array($sextension2, $allowedExts) ){
				if ($_FILES["sphoto2"]["error"] > 0){
					echo "Return Code: " . $_FILES["sphoto2"]["error"] . "<br>";
				}else{
				  move_uploaded_file($_FILES["sphoto2"]["tmp_name"], "../senator/" . $_FILES["sphoto2"]["name"]);
				}	
			}
		}
		
		if(!empty($rphoto1)){
			$rtemp1 = explode(".", $rphoto1);
			$rextension1 = end($rtemp1);
			
			if( in_array($rextension1, $allowedExts) ){
				if ($_FILES["rphoto1"]["error"] > 0){
					echo "Return Code: " . $_FILES["rphoto1"]["error"] . "<br>";
				}else{
				  move_uploaded_file($_FILES["rphoto1"]["tmp_name"], "../senator/" . $_FILES["rphoto1"]["name"]);
				}	
			}
		}
		
		
		$sql = "INSERT INTO `rep_new` (`rId`, `billid`, `sname1`, `agree`, `sphoto1`, `sname2`, `agree2`, `sphoto2`, `rname1`, `ragree1`, `rphoto1`, `dateSubmitted`) VALUES ('', '$billid', '$sname1', '$agree', '$sphoto1', '$sname2', '$agree2', '$sphoto2', '$rname1', '$ragree1', '$rphoto1', now() )";
		
		if (mysqli_query($con,$sql)){
			$message = 'Content Added Successfully';
		}
	}else if($_POST['type']=='edit'){
		$sname1 = mysqli_real_escape_string($con,$_POST['sname1']);
		$agree = mysqli_real_escape_string($con,$_POST['agree']);
		$sname2 = mysqli_real_escape_string($con,$_POST['sname2']);
		$agree2 = mysqli_real_escape_string($con,$_POST['agree2']);
		$rname1 = mysqli_real_escape_string($con,$_POST['rname1']);
		$ragree1 = mysqli_real_escape_string($con,$_POST['ragree1']);
		$billid = mysqli_real_escape_string($con,$_POST['billid']);
		
		$sql = "Update rep_new set `sname1`='$sname1', `agree`='$agree', `sname2`='$sname2',`agree2`='$agree2', `rname1`= '$rname1', `ragree1`='$ragree1' where billid=$billid";
		if (mysqli_query($con,$sql)){
			$message = 'Content Updated Successfully';
		}
	}
}

if(!empty($id)){
	$sql="select * from rep_new where billid=$id";
	$query=mysqli_query($con,$sql);
	
	while($res=mysqli_fetch_assoc($query)){
		$sname1 = $res['sname1'];
		$agree = $res['agree'];
		$sname2 = $res['sname2'];
		$agree2 = $res['agree2'];
		$rname1 = $res['rname1'];
		$ragree1 = $res['ragree1'];
	}
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
                
                <?php if(!empty($message)){echo $message;}?>
                
                <center>
               <h2>Add Senators and House of Representatives</h2>
               <form action="rep.php?id=<?php echo $id;?>" method="post" enctype="multipart/form-data">
                    <table  class="table" style="width:50%" >
                    <tr>
                    <th></th>
                    <th></th>
                    </tr>
                    <tr>
                    <td style="font-weight:bold">1st Senator Name: </td>
                    <td>
                        <input type="text" name="sname1" value="<?php echo $sname1;?>" class="input-medium">

                    </td>
                    
                    </tr>


                    <tr>
                    <td style="font-weight:bold">1st Senator Image: </td>
                    <td>
                        <input type="file" class="input-medium" name="sphoto1">

                    </td>
                    
                    </tr>


                    <tr>
                    <td style="font-weight:bold">Agree or Disagree</td>
                    <td>
                         <input type="radio" name="agree" value="Agree" <?php if($agree=='Agree'){echo 'checked="checked"';}?> />&nbsp;&nbsp;Agree &nbsp;&nbsp;&nbsp;
						 <input type="radio" name="agree" value="Disagree" <?php if($agree=='Disagree'){echo 'checked="checked"';}?>/>&nbsp;&nbsp;Disagree
                        
                    </td>
                    
                    </tr>
                    
                    <tr>
                    <td style="font-weight:bold">2nd Senator Name: </td>
                    <td>
                        <input type="text" name="sname2" value="<?php echo $sname2;?>" class="input-medium">

                    </td>
                    
                    </tr>


                    <tr>
                    <td style="font-weight:bold">1st Senator Image: </td>
                    <td>
                        <input type="file" class="input-medium" name="sphoto2">

                    </td>
                    
                    </tr>


                    <tr>
                    <td style="font-weight:bold">Agree or Disagree</td>
                    <td>
                         <input type="radio" name="agree2" value="Agree" <?php if($agree2=='Agree'){echo 'checked="checked"';}?>/>&nbsp;&nbsp;Agree &nbsp;&nbsp;&nbsp;
						 <input type="radio" name="agree2" value="Disagree" <?php if($agree2=='Disagree'){echo 'checked="checked"';}?>/>&nbsp;&nbsp;Disagree
                        
                    </td>
                    
                    </tr>
                    
					
                    <tr>
                    <td style="font-weight:bold">Representative Name: </td>
                    <td>
                        <input type="text" name="rname1" value="<?php echo $rname1;?>" class="input-medium">

                    </td>
                    
                    </tr>


                    <tr>
                    <td style="font-weight:bold">Representative Image: </td>
                    <td>
                        <input type="file" class="input-medium" name="rphoto1">

                    </td>
                    
                    </tr>


                    <tr>
                    <td style="font-weight:bold">Agree or Disagree</td>
                    <td>
                         <input type="radio" name="ragree1" value="Agree" <?php if($ragree1=='Agree'){echo 'checked="checked"';}?>/>&nbsp;&nbsp;Agree &nbsp;&nbsp;&nbsp;
						 <input type="radio" name="ragree1" value="Disagree" <?php if($ragree1=='Disagree'){echo 'checked="checked"';}?>/>&nbsp;&nbsp;Disagree
                        
                    </td>
                    
                    </tr>
                    

                    <tr>
                   
                    <td colspan=2 >
                      
                      <?php if(!empty($sname1)){?>
                      	<input type="hidden" name="type" value="edit" />
                      <?php }else{?>
                      	<input type="hidden" name="type" value="add" />
                      <?php } ?>
                      <input type="hidden" name="billid" value="<?php echo $id; ?>" />
            <center><input type="submit" name="sbt" class="btn btn-info alertinfo" value="Update"></center>

                    </td>
                    
                    </tr>




                    </table>
                    </form>
                 </center>   
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

</html>
