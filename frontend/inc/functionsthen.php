<?php

$jsonj = jsonarray($output);
if ($_POST['username']){
    if ($jsonj->successful == 'true'){
            echo "<script>$(document).ready(function(){";
            echo "$('body').addClass('loggedin');";
            echo "});</script>";
            echo "Hello ".$_POST['username'].", you are now logged in!";
        } else {
            echo "<script>$(document).ready(function(){";
            echo "$('body').addClass('overlaid');";
            echo "$('#a').css('display','block').append('<div class=\'left\' style=\'text-align:center; width:100%;\'><p style=\'color:red\'>Invalid login. Please try again.</p></div>');});</script>";    
        }
}
if (isset($_POST['nameOrganization'])){
    if ($jsonj->successful == 'true'){
            //Organization signup worked
             echo "<script>$(document).ready(function(){";
            echo "$('body').addClass('overlaid');";
            echo "$('#confirm2').css('display','block');});</script>";           
        }
        if ($jsonj->name_taken == 'true'){
            echo "<script>$(document).ready(function(){";
            echo "$('body').addClass('overlaid');";
            echo "$('#confirm2').css('display','block');});</script>";
            } else {
            echo "<script>$(document).ready(function(){";
            echo "$('body').addClass('overlaid');";
            echo "$('#organization').css('display','block').append('<div class=\'left\'><p style=\'color:red;text-align:center\'>Sorry, something went wrong. Please try again.</p></div>');});</script>";           
        }
}
if (isset($_POST['addIndividual-button'])){
    if ($jsonj->successful == 'true'){
            //Organization signup worked
            echo "<script>$(document).ready(function(){";
            echo "$('body').addClass('overlaid');";
            echo "$('#confirm').css('display','block');});</script>";           
        } else {
            echo "<script>$(document).ready(function(){";
            echo "$('body').addClass('overlaid');";
            echo "$('#individual').css('display','block').append('<div class='left'><p style='text-align:center;color:red'>Sorry, something went wrong. Please try again.</p></div>';});</script>";           
        }
}
?>