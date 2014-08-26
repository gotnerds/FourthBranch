<?php
    if (isset($_POST['login-button'])) {
        $output = shell_exec("perl ./cgi-bin/fourthBranch.pl run=loginIndividual email=".$_POST['username']." password=".$_POST['password']);
        $jsonj = jsonarray($output);
        //echo "individual: ";
        //var_dump($jsonj);
        //statement to test for successful.
        if ($jsonj->successful == 'true'){
          session_start();
          $_SESSION['login_user']= $_POST['username']; //Initializing Session with value of PHP Variable
        } else {
        $output = shell_exec("perl ./cgi-bin/fourthBranch.pl run=loginOrganization email=".$_POST['username']." password=".$_POST['password']);
        $jsonj = jsonarray($output);
            //create php user session for organization
          session_start();
          $_SESSION['login_user']= $_POST['username']; //Initializing Session with value of PHP Variable
          echo $_SESSION['login_user'];
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
        $currentDate = htmlspecialchars(date('m-d-Y'));
        $output = shell_exec("perl ./cgi-bin/fourthBranch.pl run=addOrganization name=".$_POST['nameOrganization']." address=".$_POST['addressOrganization']." city=".$_POST['cityOrganization']." state=".$_POST['stateOrganization']." zip=".$_POST['zipOrganization']." phone=".$_POST['phoneOrganization']." legalstatus=".$_POST['legal']." cause=".$_POST['cause']." joinreason=".$_POST['reasons']." individualname=".$_POST['nameI']." titleorganization=".$_POST['titleI']." personalphone=".$_POST['phoneP']." email=".$_POST['emailO']." password=".$_POST['passS']." signupdate=".$currentDate);
        echo "Reason: ".$_POST['reasons']." & ";
        echo "Organization: ".$_POST['nameOrganization'];
        echo " & Date: ".date("m-d-Y");
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
    if (isset($_POST['voteUser'])){
        $_SESSION['voteUser']= $_POST['voteUser'];
        echo $_SESSION['voteUser'];
    }
//var_dump($jsonj);
//print_r($output);
?>