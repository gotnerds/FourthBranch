<?php
include_once 'psl-config.php';
 
function sec_session_start() {
    $session_name = 'loginSession';   // Set a custom session name
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session 
    session_regenerate_id();    // regenerated the session, delete the old one. 
}

function login($email, $password, $mysqli) {
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT id, username, password, salt 
        FROM individuals
       WHERE email = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
 
        // get variables from result.
        $stmt->bind_result($user_id, $username, $db_password, $salt);
        $stmt->fetch();
 
        // hash the password with the unique salt.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 
            if (checkbrute($user_id, $mysqli) == true) {
                // Account is locked 
                // Send an email to user saying their account is locked
                return false;
            } else {
                // Check if the password in the database matches
                // the password the user submitted.
                if ($db_password == $password) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", 
                                                                "", 
                                                                $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', 
                              $password . $user_browser);
                    // Login successful.
                    return true;
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    $now = time();
                    $mysqli->query("INSERT INTO login_attempts(user_id, time)
                                    VALUES ('$user_id', '$now')");
                    return false;
                }
            }
        } else {
            // No user exists.
            return false;
        }
    }
}

function checkbrute($user_id, $mysqli) {
    // Get timestamp of current time 
    $now = time();
 
    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (2 * 60 * 60);
 
    if ($stmt = $mysqli->prepare("SELECT time 
                             FROM login_attempts 
                             WHERE user_id = ? 
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);
 
        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();
 
        // If there have been more than 5 failed logins 
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}
function login_check($mysqli) {
    // Check if all session variables are set 
    if (isset($_SESSION['user_id'], 
                        $_SESSION['username'], 
                        $_SESSION['login_string'])) {
 
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        if ($stmt = $mysqli->prepare("SELECT password 
                                      FROM individuals 
                                      WHERE id = ? LIMIT 1")) {
            // Bind "$user_id" to parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
                if ($login_check == $login_string) {
                    // Logged In!!!! 
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } else {
                // Not logged in 
                return false;
            }
        } else {
            // Not logged in 
            return false;
        }
    } else {
        // Not logged in 
        return false;
    }
}

function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}
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