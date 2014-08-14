<?php


    if (isset($_POST['login-button'])) {

        $output = shell_exec("perl ./cgi-bin/fourthBranch.pl run=loginIndividual email=".$_POST['username']." password=".$_POST['password']);

        $jsonj = jsonarray($output);

        //echo "individual: ";

        //var_dump($jsonj);

        //statement to test for successful.

        if ($jsonj->successful == 'true'){

            //create php user session for individual

        } else {

        $output = shell_exec("perl ./cgi-bin/fourthBranch.pl run=loginOrganization email=".$_POST['username']." password=".$_POST['password']);

        $jsonj = jsonarray($output);

            //create php user session for organization

        }

    }

    if (isset($_POST['addIndividual-button'])){

        $output = shell_exec("perl ./cgi-bin/fourthBranch.pl run=addIndividual first=".$_POST['fname']." last=".$_POST['lname']." username=".$_POST['pseudonym']." birthdate=".$_POST['dob']." gender=".$_POST['g']." address=".$_POST['address']." city=".$_POST['city']." state=".$_POST['state']." zip=".$_POST['zip']." email=".$_POST['emailI']." password=".$_POST['passI']." affiliation=".$_POST['party']);

        $jsonj = jsonarray($output);

        if ($jsonj->successful == 'true'){
        // send email to verify account (then sign in that account)
            
        //individual sign up worked

            echo $jsonj->successful;

    } else {

            echo $jsonj->successful;        

        }

    }

    if (isset($_POST['nameOrganization'])){

        $output = shell_exec("perl ./cgi-bin/fourthBranch.pl run=addOrganization name=".$_POST['nameOrganization']." address=".$_POST['addressOrganization']." city=".$_POST['cityOrganization']." state=".$_POST['stateOrganization']." zip=".$_POST['zipOrganization']." phone=".$_POST['phoneOrganization']." legalstatus=".$_POST['legal']." cause=".$_POST['cause']." joinreason=".$_POST['reason']." individualname=".$_POST['nameI']." titleorganization=".$_POST['titleI']." personalphone=".$_POST['phoneP']." email=".$_POST['emailO']." password=".$_POST['passS']);

        var_dump($jsonj);

        print_r($output);

        $jsonj = jsonarray($output);

        if ($jsonj->successful == 'true'){

        //organization sign up worked

            echo $jsonj->successful;

    } else {

            echo $jsonj->successful;        

        }

    }
//var_dump($jsonj);
//print_r($output);

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

            echo "$('#organization').css('display','block').append('<div class=\'left\'><p style=\'color:red\'>Sorry, something went wrong. Please try again.</p></div>');});</script>";           

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

            echo "$('#individual').css('display','block').append('<div class='left'><p style='color:red'>Sorry, something went wrong. Please try again.</p></div>';});</script>";           

        }

}



?>