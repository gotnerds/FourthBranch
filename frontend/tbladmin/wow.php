

<?php



include("include/dbcon.php");



if(isset($_POST['sbt'])){



    foreach($_POST as $key=>$val)

	$$key=get_magic_quotes_gpc()?$val:addslashes($val);

    

    if(isset($_FILES['photo1']['name'])){

        $file = $_FILES['photo1']['name'];

        $temp = $_FILES['photo1']['tmp_name'];    

        $fullpath = "photos/".$file;

    }else{

        $fullpath = '';

    }

 

 $sqlphoto="insert into wow set `name`='$name',`dream`='$dream',`wish`='$wish',`state`='$state',`photo`='$fullpath',`dateSubmitted`=now()";

 $query=mysqli_query($con,$sqlphoto) or die(mysqli_error($con));

 if($query && !empty($fullpath)){

     $moveResult = move_uploaded_file($temp, $fullpath);

     if ($moveResult == true) {

    echo"<script>alert('Done !');</script>";

} else {

   echo"<script>alert('Data Not Updated !');</script>";

}

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

                <center>

               <h2>Wishes Page</h2>

              <form method="post" enctype="multipart/form-data">

             Username: <input type="text" name="name">

              dream:<input type="text" name="dream">

              wish:<input type="text" name="wish">

               State:<input type="text" name="state">

              Image:<input type="file" name="photo1">

              <input type="submit" name="sbt" value="ADD">

              

              

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

