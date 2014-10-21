
<?php

include("include/dbcon.php");

$id=$_GET['id'];
if (isset($_GET['status'])){
    $st=$_GET['status'];
    $id=$_GET['id'];
    if($st=="Active"){
        $sql1="update individuals set activated='0' where id=$id";
        $query1=mysqli_query($con,$sql1);
        
    }
     if($st=="Inactive"){
        $sql1="update individuals set activated='1' where id=$id";
        $query1=mysqli_query($con,$sql1);
        
    }
}

$sql="select * from individuals where id=$id";
$query=mysqli_query($con,$sql);
while($res=mysqli_fetch_assoc($query)){
    $info = array();
    $info['id'] = $res['id'];
    $info['first_name']=$res['first_name'];
    $info['last_name']=$res['last_name'];
    $info['username']=$res['username'];
    $info['birthdate']=$res['birthdate'];
    $info['gender']=$res['gender'];
    $info['address']=$res['address'];
    $info['city']=$res['city'];
    $info['state']=$res['state'];
    $info['zip']=$res['zip'];
    $info['email']=$res['email'];
    $info['political_affiliation']=$res['political_affiliation'];
    $info['activated']=$res['activated'];
    $info['photo']=$res['photo'];
    $info['contributed']=$res['contributed'];
    if($info['activated']=="0"){
            $status="Inactive";
    }
    else if($info['activated']=="1"){
            $status="Active";
    }
    /*
    $gender=$res['gender'];
    $website=$res['website'];
    $dob=$res['dob'];
    $follow=$res['$totalFollowers'];
    $following=$res['totalFollowing'];
    $votecast=$res['votesCast'];
    $comment=$res['commentsPosted'];
    $agree=$res['agreesReceived'];
    $disagree=$res['disagreesReceived'];
    */
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
               <h2><?php echo $info['username'];?>'s Profile</h2><br>
                    <table  class="table" style="width:50%" >
                    <tr>
                    <th></th>
                    <th></th>
                    </tr>
                    <?php
                    foreach ($info as $key => $value) {
                        echo '<tr><td style="font-weight:bold">'.str_replace("_", " ", ucwords($key)).':</td>';
                        if ($key == 'photo'){
                            if ($value == ''){
                                echo "<td>No Image Set</td>";
                            } else {
                            echo "<td><img src='../".$value."' /></td>";
                            }
                        }elseif ($key == 'activated') {
                            echo "<td><a href='view.profile.php?status=".$status."&id=".$info['id']."' >".$status."</a></td>";
                        } elseif ($key =='political_affiliation') {
                            switch ($value) {
                                 case 'r':
                                     $politics = 'republican';
                                     break;
                                 case 'd':
                                     $politics = 'democrat';
                                     break;
                                 case 'l':
                                     $politics = 'libertarian';
                                     break;
                                case 'i':
                                    $politics = 'independent';
                                    break;
                                 default:
                                     $politics = 'other';
                                     break;
                             } 
                            echo '<td>'.ucwords($politics).'</td>';
                        } else {
                            echo '<td>'.$value.'</td>';
                        }
                        echo '</tr>';
                    }
                    ?>
                    
                    <!--
                      <tr>
                    <td style="font-weight:bold">IP</td>
                    <td></td>
                    
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
   -->

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
   