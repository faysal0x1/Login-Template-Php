<?php
// process_otp.php
include_once "conf/db_con.php";
include "Notify.php";
include_once "conf/auth_session.php";

$dbHost = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "php_login";

if (isset($_GET['otp'])) {


    $otpString = $_GET['otp'];

    $session = new AuthSession();

    $session->init();

    $email = $session->get('email');

    if (empty($email)) {
        echo 'Email not found.';
        exit;
    } else {

        try {
            $sql = "SELECT * FROM users WHERE email  = '$email'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Verify the OTP code
                $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
                var_dump($row);
                $notify = new Notify($db);
                var_dump($notify->isValidOtp($row['id'], $otpString));
                if ($notify->isValidOtp($row['id'], $otpString)) {

                    $resetToken = $notify->generateResetTokenOtp();
                    $notify->saveResetToken($row['id'], $resetToken);
                    // $notify->deleteOtp($row['id'], $otpString);
                    AuthSession::init();

                    AuthSession::set('resetToken', $resetToken);
                    AuthSession::set('test', "test");

                    header("Location: reset-password.php?token=$resetToken&email=$email");
                } else {
                    echo 'OTP is not valid.';
                }
            }
        } catch (Throwable $th) {

            echo $th;
        }
    }

    // Process the OTP string as needed
    // For now, let's just echo it back
    echo 'Received OTP: ' . $otpString;
    echo '<br>';
    echo 'Email: ' . $email;
} else {
    echo 'OTP not provided.';
}
