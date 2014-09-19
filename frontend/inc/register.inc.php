<?php
include_once 'db_connect.php';
include_once 'psl-config.php';
 
$error_msg = "";
 
if (isset($_POST['pseudonym'], $_POST['email'], $_POST['p'])) {
    // Sanitize and validate the data passed in
    $first_name = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
    $last_name = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'pseudonym', FILTER_SANITIZE_STRING);
    $birthdate = filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_STRING);
    $gender = $_POST['g'][0];
    $gender = filter_var($gender, FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
    $zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_STRING);
    $political_affiliation = $_POST['party'][0];
    $political_affiliation = filter_var($political_affiliation, FILTER_SANITIZE_STRING);
    $activated = 0;
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= '<p class="error">The email address you entered is not valid</p>';
    }
 
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
    }
 
    // Username validity and password validity have been checked client side.
    // This should should be adequate as nobody gains any advantage from
    // breaking these rules.
    //
 
    $prep_stmt = "SELECT id FROM individuals WHERE email = ? LIMIT 1 union all SELECT id FROM organizations WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
 
   // check existing email  
    if ($stmt) {
        $stmt->bind_param('ss', $email, $email);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows == 1) {
            // A user with this email address already exists
            $error_msg .= '<p class="error">A user with this email address already exists.</p>';
        }
                $stmt->close();
    } else {
        $error_msg .= '<p class="error">Database error Line 39</p>';
                $stmt->close();
    }
 
    // check existing username
    $prep_stmt = "SELECT id FROM individuals WHERE username = ? LIMIT 1 union all SELECT id FROM organizations WHERE name = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
    if ($stmt) {
        $stmt->bind_param('ss', $username, $name);
        $stmt->execute();
        $stmt->store_result();
 
                if ($stmt->num_rows == 1) {
                        // A user with this username already exists
                        $error_msg .= '<p class="error">A user with this username already exists</p>';
                }
                $stmt->close();
        } else {
                $error_msg .= '<p class="error">Database error line 55</p>';
                $stmt->close();
        }
 
    // TODO: 
    // We'll also have to account for the situation where the user doesn't have
    // rights to do registration, by checking what type of user is attempting to
    // perform the operation.
    if (empty($error_msg)) {
        // Create a random salt
        //$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE)); // Did not work
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
 
        // Create salted password 
        $password = hash('sha512', $password . $random_salt);
        if (isset($_POST['pseudonym'])) {
            // Insert the new user into the database 
            if ($insert_stmt = $mysqli->prepare("INSERT INTO individuals (first_name, last_name, username, birthdate, gender, address, city, state, zip, email, password, political_affiliation, activated, salt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
                $insert_stmt->bind_param('ssssssssssssss', $first_name, $last_name, $username, $birthdate, $gender, $address, $city, $state, $zip, $email, $password, $political_affiliation, $activated, $random_salt);
                // Execute the prepared query.
                if (! $insert_stmt->execute()) {
                    echo $gender;
                    echo "error inserting individual";
                    #header('Location: ../error.php?err=Registration failure: INSERT');
                }
            }
            #header('Location: ./index.php');
        } elseif (isset($_POST['addOrganization-button'])) {
            # code...
        }
    }
}