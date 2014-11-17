<?php
include_once 'db_connect.php';
include_once'db_conx.php';
 
$error_msg = "";

if (isset($_POST['p'])) {

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
    $verification = md5( rand(0,1000) );

    if (isset($_POST['nameOrganization'])) {
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["pic"]["name"]);
        $extension = end($temp);
        if ((($_FILES["pic"]["type"] == "image/gif")
        || ($_FILES["pic"]["type"] == "image/jpeg")
        || ($_FILES["pic"]["type"] == "image/jpg")
        || ($_FILES["pic"]["type"] == "image/pjpeg")
        || ($_FILES["pic"]["type"] == "image/x-png")
        || ($_FILES["pic"]["type"] == "image/png"))
        && ($_FILES["pic"]["size"] < 100000)
        && in_array($extension, $allowedExts)) {
          if ($_FILES["pic"]["error"] > 0) {
            echo "Return Code: " . $_FILES["pic"]["error"] . "<br>";
          } else {
            #echo "Upload: " . $_FILES["pic"]["name"] . "<br>";
            #echo "Type: " . $_FILES["pic"]["type"] . "<br>";
            #echo "Size: " . ($_FILES["pic"]["size"] / 1024) . " kB<br>";
            #echo "Temp file: " . $_FILES["pic"]["tmp_name"] . "<br>";
            if (file_exists("upload/" . $_FILES["pic"]["name"])) {
              echo $_FILES["pic"]["name"] . " already exists. ";
            } else {
              move_uploaded_file($_FILES["pic"]["tmp_name"],
              "userImage/" . $_FILES["pic"]["name"]);
              #echo "Stored in: " . "userImage/" . $_FILES["pic"]["name"];
              $photo = "userImage/".$_FILES["pic"]["name"];
            }
          }
        } else {
         // echo "Invalid file";
        }
        $name = filter_input(INPUT_POST, 'nameOrganization', FILTER_SANITIZE_STRING);
        $addressOrganization = filter_input(INPUT_POST, 'addressOrganization', FILTER_SANITIZE_STRING);
        $cityOrganization = filter_input(INPUT_POST, 'cityOrganization', FILTER_SANITIZE_STRING);
        $stateOrganization = filter_input(INPUT_POST, 'stateOrganization', FILTER_SANITIZE_STRING);
        $phoneOrganization = filter_input(INPUT_POST, 'phoneOrganization', FILTER_SANITIZE_STRING);
        $zipOrganization = filter_input(INPUT_POST, 'zipOrganization', FILTER_SANITIZE_STRING);
        $legal_status = $_POST['legal'][0];
        $legal_status = filter_var($legal_status, FILTER_SANITIZE_STRING);
        $cause_concerns = $_POST['cause'][0];
        $cause_concerns = filter_var($cause_concerns, FILTER_SANITIZE_STRING);
        $imgURL = "userImage/" . $_FILES["pic"]["name"];
        $join_reason = filter_input(INPUT_POST, 'reasons', FILTER_SANITIZE_STRING);
        $individual_name = filter_input(INPUT_POST, 'nameI', FILTER_SANITIZE_STRING);
        $title_in_organization = filter_input(INPUT_POST, 'titleI', FILTER_SANITIZE_STRING);
        $personal_phone = filter_input(INPUT_POST, 'phoneP', FILTER_SANITIZE_STRING);
        $verified = 0;
        if (isset($_POST[emailS])) {
            $email = filter_input(INPUT_POST, 'emailS', FILTER_SANITIZE_STRING);
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        }
        $personal_email = filter_input(INPUT_POST, 'emailO', FILTER_SANITIZE_STRING);
        $signup_date = date("Y-m-d");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= 'The email address you entered is not valid';
    }
 
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= 'Invalid password configuration.';
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
            $error_msg .= 'A user with this email address already exists.';
        }
                $stmt->close();
    } else {
        $error_msg .= 'Database error Line 39';
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
                        $error_msg .= 'A user with this username already exists';
                }
                $stmt->close();
        } else {
                $error_msg .= 'Database error line 55';
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
            $stmt = $pdo->prepare('CALL insertIndividual(:first_name, :last_name, :username, :birthdate, :gender, :address, :city, :state, :zip, :email, :password, :political_affiliation, :activated, :salt, :verification)');
            $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
            $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt->bindParam(':city', $city, PDO::PARAM_STR);
            $stmt->bindParam(':state', $state, PDO::PARAM_STR);
            $stmt->bindParam(':zip', $zip, PDO::PARAM_INT);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':political_affiliation', $political_affiliation, PDO::PARAM_STR);
            $stmt->bindParam(':activated', $activated, PDO::PARAM_INT);
            $stmt->bindParam(':salt', $random_salt, PDO::PARAM_STR);
            $stmt->bindParam(':verification', $verification, PDO::PARAM_STR);
            // Execute the prepared query.
                if ($stmt->execute()) {
                    echo url().'
                    /FourthBranch/FourthBranch/frontend
                    /verify.php?email='.$email.'&hash='.$verification;
                    $to      = $email; // Send email to our user
                    $subject = 'The Fourth Branch Signup | Verification'; // Give the email a subject 
                    $message = '
                     
                    Thanks for signing up!
                    Your account has been created, you can login with your credentials after you have activated your account by pressing the url below.
                     
                    Please click this link to activate your account:
                    '.url().'/inc/verify.php?email='.$email.'&hash='.$verification.'
                     
                    '; // Our message above including the link
                                         
                    $headers = 'From:noreply@yourwebsite.com' . "\r\n"; // Set from headers
                    mail($to, $subject, $message, $headers); // Send our email

                    $error_msg = 'Thank you for signing up. The activation email has been sent.';
                    #header('Location: ../error.php?err=Registration failure: INSERT');
                } else {
                    echo "There was an error signing up. Please try again or contact us.";
                }
            
            #header('Location: ./index.php');
        } elseif (isset($_POST['nameOrganization'])) {
            // Insert the new organization into the database 
            echo $nameOrganization;
            $stmt = $pdo->prepare('CALL insertOrganization(:name, :address, :city, :state, :zip, :phone, :legal_status, :cause_concerns, :join_reason, :individual_name, :title_in_organization, :personal_phone, :email, :password, :salt, :verified, :signup_date, :image, :verification)');
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':address', $addressOrganization, PDO::PARAM_STR);
            $stmt->bindParam(':city', $cityOrganization, PDO::PARAM_STR);
            $stmt->bindParam(':state', $stateOrganization, PDO::PARAM_STR);
            $stmt->bindParam(':zip', $zipOrganization, PDO::PARAM_INT);
            $stmt->bindParam(':phone', $phoneOrganization, PDO::PARAM_STR);
            $stmt->bindParam(':legal_status', $legal_status, PDO::PARAM_STR);
            $stmt->bindParam(':cause_concerns', $cause_concerns, PDO::PARAM_STR);
            $stmt->bindParam(':join_reason', $join_reason, PDO::PARAM_STR);
            $stmt->bindParam(':individual_name', $individual_name, PDO::PARAM_STR);
            $stmt->bindParam(':title_in_organization', $title_in_organization, PDO::PARAM_STR);
            $stmt->bindParam(':personal_phone', $personal_phone, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':salt', $random_salt, PDO::PARAM_STR);
            $stmt->bindValue(':verified', $verified, PDO::PARAM_INT);
            $stmt->bindParam(':signup_date', $signup_date, PDO::PARAM_STR);
            $stmt->bindValue(':image', $photo, PDO::PARAM_STR);
            $stmt->bindParam(':verification', $verification, PDO::PARAM_STR);
                // Execute the prepared query.
                if ($stmt->execute()) {
                    $error_msg = 'Thank you for signing up. The Fourth Branch Team will verify your account soon.';
                    #header('Location: ../error.php?err=Registration failure: INSERT');
                } else {
                    echo $gender;
                    echo "error inserting organization";
                }
            
        }
    }
}