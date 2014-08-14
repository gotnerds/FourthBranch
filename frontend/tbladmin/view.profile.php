
<?php

include("include/dbcon.php");

$id=$_GET['id'];
$sql="select * from users where id=$id";
$query=mysqli_query($con,$sql);

while($res=mysqli_fetch_assoc($query)){

    $firstname=$res['firstName'];
    $lastname=$res['lastName'];
    $username=$res['username'];
    $email=$res['email'];
    $sign=$res['sign_up_date'];
    $activate=$res['activated'];
    $gender=$res['gender'];
    $website=$res['website'];
    $state=$res['state'];
    $usertype=$res['userType'];
    $dob=$res['dob'];
    $addres=$res['adress'];
    $city=$res['city'];
    $zip=$res['zip'];
    $follow=$res['$totalFollowers'];
    $following=$res['totalFollowing'];
    $votecast=$res['votesCast'];
    $comment=$res['commentsPosted'];
    $agree=$res['agreesReceived'];
    $disagree=$res['disagreesReceived'];

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
               <h2><?php echo $firstname;?>'s Profile</h2>
                    <table  class="table" style="width:50%" >
                    <tr>
                    <th></th>
                    <th></th>
                    </tr>
                    <tr>
                    <td style="font-weight:bold">Email :</td>
                    <td></td>
                    
                    </tr>


                    <tr>
                    <td style="font-weight:bold">Sign Up Date :</td>
                    <td>
                       <?php
                        echo $sign;
                       ?> 

                    </td>
                    
                    </tr>


                    <tr>
                    <td style="font-weight:bold">Activated</td>
                    <td>
                        
                        <?php
                        echo $activate;
                        ?>
                    </td>
                    
                    </tr>


                    <tr>
                    <td style="font-weight:bold">Gender</td>
                    <td>
                        <?php
                        echo $gender;
                        ?>

                    </td>
                    
                    </tr>


                      <tr>
                    <td style="font-weight:bold">State</td>
                    <td>
                        <?php
                            echo $state;
                        ?>

                    </td>
                    
                    </tr>


                      <tr>
                    <td style="font-weight:bold">User Type</td>
                    <td>
                        <?php
                        echo $usertype;
                        ?>

                    </td>
                    
                    </tr>



                      <tr>
                    <td style="font-weight:bold">IP</td>
                    <td></td>
                    
                    </tr>


                    <tr>
                    <td style="font-weight:bold">First Name</td>
                    <td>
                        <?php
                            echo $firstname;
                        ?>

                    </td>
                    
                    </tr>



                    <tr>
                    <td style="font-weight:bold">Last Name</td>
                    <td>
                        <?php
                              echo  $lastname;
                        ?>

                    </td>
                    
                    </tr>



                    <tr>
                    <td style="font-weight:bold">Phone #</td>
                    <td></td>
                    
                    </tr>


                     <tr>
                    <td style="font-weight:bold">Date Of Birth</td>
                    <td>
                            <?php
                            echo $dob;
                            ?>

                    </td>
                    
                    </tr>


                     <tr>
                    <td style="font-weight:bold">Adress</td>
                    <td>
                        <?php
                        echo $addres;
                        ?>

                    </td>
                    
                    </tr>


                     <tr>
                    <td style="font-weight:bold">City</td>
                    <td>
                        
                            <?php
                            echo $city;
                            ?>

                    </td>
                    
                    </tr>

                     <tr>
                    <td style="font-weight:bold">ZIP</td>
                    <td>
                        <?php echo $zip ?>

                    </td>
                    
                    </tr>


                     <tr>
                    <td style="font-weight:bold">Total Followers</td>
                    <td>
                        
                            <?php
                                echo $follow;
                            ?>

                    </td>
                    
                    </tr>


                     <tr>
                    <td style="font-weight:bold">Total Following</td>
                    <td>
                        <?php
                        echo $following;
                        ?>

                    </td>
                    
                    </tr>

                    <tr>
                    <td style="font-weight:bold">Vote Cast</td>
                    <td>
                        <?php
                        echo $votecast;
                        ?>

                    </td>
                    
                    </tr>

                     <tr>
                    <td style="font-weight:bold">Comment Posted</td>
                    <td>
                        <?php
                        echo $comment;
                        ?>

                    </td>
                    
                    </tr>
                      <tr>
                    <td style="font-weight:bold">Agree Received </td>
                    <td>
                        <?php
                        echo $agree;
                        ?>

                    </td>
                    
                    </tr>

                      <tr>
                    <td style="font-weight:bold">Disagree Received</td>
                    <td>
                        <?php
                        echo $disagree;
                        ?>

                    </td>
                    
                    </tr>
                        <tr>
                         <td style="font-weight:bold">Proposal Made</td>
                    <td>
                        <?php
                        echo $disagree;
                        ?>

                    </td>
                    
                    </tr>
                    <tr>

                         <td style="font-weight:bold">Report Against</td>
                    <td>
                        <?php
                        echo $disagree;
                        ?>

                    </td>
                    
                    </tr>
   

                          <tr>

                         <td style="font-weight:bold">Pseudonym</td>
                    <td>
                        <?php
                        echo $disagree;
                        ?>

                    </td>
                    
                    </tr>

                    <tr>
                    <td style="font-weight:bold">Company First Name</td>
                    <td></td>
                    
                    </tr>


                    <tr>
                    <td style="font-weight:bold">Company Last Name</td>
                    <td></td>
                    
                    </tr>
                    <tr>
                    <td style="font-weight:bold">Company Email</td>
                    <td></td>
                    
                    </tr>
                     <tr>
                    <td style="font-weight:bold">Company Title</td>
                    <td></td>
                    
                    </tr>

                    </table>
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
   