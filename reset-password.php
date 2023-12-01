<?php

include_once "conf/db_con.php";
include "Notify.php";
include_once "conf/auth_session.php";

$session = new AuthSession();
$session->init();

$dbHost = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "php_login";




if (isset($_GET['token']) || isset($_SESSION['token'])) {

    if (isset($_GET['token'])) {
        $_SESSION['token'] = $_GET['token'];
        $_SESSION['email'] = $_GET['email'];
        $token = $_SESSION['token'];
        $email = $_SESSION['email'];
    } else {
        $token = $_SESSION['token'];
        $email = $_SESSION['email'];
    }
} else {
    // var_dump($_SESSION['token']);
    echo "Token not provided.";
    exit;
}

$db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);

$notify = new Notify($db);

$userId = $notify->getUserId($email);

$error = "";

$data = $notify->getUser($email);
// var_dump($data);

if (isset($userId)) {
   
    if ($notify->isValidTokenForOtp($userId, $token)) {
        if (isset($_POST['password']) && isset($_POST['cPassword'])) {
            $password = $_POST['password'];
            $cPassword = $_POST['cPassword'];
            if ($password == $cPassword) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $token = md5(uniqid(rand(), true));

                if ($notify->updateUserPassword($hashedPassword, $token, $userId)) {

                    $data = $notify->getUser($email);

                    // AuthSession::destroy();
              
                    header("Location: index.php");
                    exit();
                } else {
                    $error = "Update Issue";
                }
            } else {
                $error = "Passwords don't match!";
              
            }
        }
    } else {
        var_dump($token);
    }
} else {
    var_dump($userId);
}



if (isset($_POST['password']) && isset($_POST['cPassword'])) {

    $password = $_POST['password'];
    $cPassword = $_POST['cPassword'];
}


?>



<html>

<head>
    <title>Forgot Password Form</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/reset.css">
</head>

<body>
    <div class="mainDiv">
        <div class="cardStyle">
            <form method="POST" action="reset-password.php" name="signupForm" id="signupForm">

                <img src="" id="signupLogo" />

                <h2 class="formTitle">
                    Login to your account
                </h2>

                <div class="inputDiv">
                    <label class="inputLabel" for="password">New Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="inputDiv">
                    <label class="inputLabel" for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="cPassword">
                </div>
                <label class="error text-center mx-auto" for="" class="error">
                    <?php
                    if (isset($error)) {
                        echo $error;
                    }
                  
                    ?>
                </label>

                <div class="buttonWrapper">
                    <button type="submit" id="submitButton" onclick="validateSignupForm()" class="submitButton pure-button pure-button-primary">
                        <span>Continue</span>
                        <span id="loader"></span>
                    </button>
                </div>

            </form>


        </div>
    </div>

    <script>
        var password = document.getElementById("password");
        var confirm_password = document.getElementById("confirmPassword");

        document.getElementById('signupLogo').src = "https://s3-us-west-2.amazonaws.com/shipsy-public-assets/shipsy/SHIPSY_LOGO_BIRD_BLUE.png";
        enableSubmitButton();

        function validatePassword() {
            if (password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Passwords Don't Match");
                return false;
            } else {
                confirm_password.setCustomValidity('');
                return true;
            }
        }

        password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;

        function enableSubmitButton() {
            document.getElementById('submitButton').disabled = false;
            document.getElementById('loader').style.display = 'none';
        }

        function disableSubmitButton() {
            document.getElementById('submitButton').disabled = true;
            document.getElementById('loader').style.display = 'unset';
        }

        function validateSignupForm() {
            var form = document.getElementById('signupForm');

            for (var i = 0; i < form.elements.length; i++) {
                if (form.elements[i].value === '' && form.elements[i].hasAttribute('required')) {
                    console.log('There are some required fields!');
                    return false;
                }
            }

            if (!validatePassword()) {
                return false;
            } else {

            }

            // onSignup();
            enableSubmitButton();
        }

        function onSignup() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {

                disableSubmitButton();

                if (this.readyState == 4 && this.status == 200) {
                    enableSubmitButton();
                } else {
                    console.log('AJAX call failed!');
                    setTimeout(function() {
                        enableSubmitButton();
                    }, 1000);
                }

            };

            xhttp.open("GET", "ajax_info.txt", true);
            xhttp.send();
        }
    </script>
</body>

</html>