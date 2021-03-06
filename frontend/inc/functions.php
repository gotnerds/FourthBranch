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
        if ($stmt->num_rows == 1) {
            $password2 = hash('sha512', $password . $salt);
            // If the user exists we check if the account is locked
            // from too many login attempts 
            if (checkbrute($user_id, $mysqli) == true) {
                // Account is locked 
                // Send an email to user saying their account is locked
                return false;
            } else {
                // Check if the password in the database matches
                // the password the user submitted.
                if ($db_password == $password2) {
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
                    $_SESSION['userType'] = 'individual';
                    $_SESSION['login_string'] = hash('sha512', 
                              $password2 . $user_browser);
                    // Login successful.
                    return true;
                } else {
                    $_SESSION['error_msg'] = 'Sorry. The provided password and username don\'t match';
                }
            }
        } elseif ($stmt = $mysqli->prepare("SELECT id, name, password, salt, verified 
        FROM organizations WHERE email = ? LIMIT 1")) {
            $stmt->bind_param('s', $email);  // Bind "$email" to parameter.   
            $stmt->execute();    // Execute the prepared query.
            $stmt->store_result();
            // get variables from result.
            $stmt->bind_result($user_id, $username, $db_password, $salt, $verified);
            $stmt->fetch();
            // hash the password with the unique salt.
            if ($stmt->num_rows == 1) {
                $password3 = hash('sha512', $password . $salt);
                // If the user exists we check if the account is locked
                // from too many login attempts 
                if (checkbrute($user_id, $mysqli) == true) {
                    // Account is locked 
                    // Send an email to user saying their account is locked
                    return false;
                } else {
                    // Check if the password in the database matches
                    // the password the user submitted.
                    if ($db_password == $password3) {
                        if ($verified == '1') {
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
                            $_SESSION['userType'] = 'organization';
                            $_SESSION['login_string'] = hash('sha512', 
                                      $password3 . $user_browser);
                            // Login successful.
                            return true;
                        } else {
                            $_SESSION['error_msg'] = 'The Fourth Branch Team has not verified your account yet. Please wait or email us for more information.';
                            return false;
                        }
                    } else {
                        // Password is not correct
                        // We record this attempt in the database
                        $now = time();
                        $mysqli->query("INSERT INTO login_attempts(user_id, time)
                                        VALUES ('$user_id', '$now')");
                        $_SESSION['error_msg'] = 'Sorry the username and password does not match.';
                        return false;
                    }
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
        $stmt->bind_param('s', $user_id);
 
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
    if (isset($_SESSION['userType'])) {
        $userType = $_SESSION['userType'];
        if ($userType == "individual") {
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
                    }
                }
            } else {
                // Not logged in 
                return false;
            }
        }elseif ($userType == "organization") {
            if (isset($_SESSION['user_id'], 
                $_SESSION['username'], 
                $_SESSION['login_string'])) {
                    $user_id = $_SESSION['user_id'];
                    $login_string = $_SESSION['login_string'];
                    $username = $_SESSION['username'];
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                if ($stmt = $mysqli->prepare("SELECT password 
                                              FROM organizations 
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
                    }
                }
            } else {
                // Not logged in 
                return false;
            }
        }
    }

}
function checkUserVote($user_id, $billId) {
     if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            // Get the user-agent string of the user.
            $user_browser = $_SERVER['HTTP_USER_AGENT'];
        if ($stmt = $mysqli->prepare("SELECT vote 
                                      FROM user_votes 
                                      WHERE user = ? LIMIT 1")) {
            // Bind "$user_id" to parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($userVote);
                $stmt->fetch();
                    return $userVote;
            } else {
                echo "not in registry";
                // Not logged in 
                return false;
            }
        }
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

function url(){
  return sprintf(
    "%s://%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME']
  );
}
    function sortList($arrayToSort) {

        $collections = array();   
        $i = 0; 
        foreach($arrayToSort as $product){
            if(!isset($collections[$product['grouped_cat']])){
                $collections[$product['grouped_cat']] = array(
                    array(
                        'title' => $product['title'],
                        'news_url' => $product['news_url'],
                        'photo' => $product['photo'],
                        'category' => $product['category']
                    )                                             
                ); 
            }else{
                array_push($collections[$product['grouped_cat']],
                    array(
                        'title' => $product["title"],
                        'news_url' => $product["news_url"],
                        'photo' => $product['photo'],
                        'category' => $product['category']
                    )            
                );       
            }
            $i++;
        }
    return $collections;
    }
?>