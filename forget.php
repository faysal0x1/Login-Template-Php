<?php

include_once './conf/db_con.php';
include_once './conf/auth_session.php';

include_once 'Notify.php';

$dbHost = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "php_login";

if (isset($_POST['email'])) {

    $email = $_POST['email'];

    $sql = "SELECT * FROM users WHERE email = '$email'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);

        $user = new User($row['id'], $row['name'], $row['email'],  password_hash($row['password'], PASSWORD_BCRYPT));

        $notify = new Notify($db);
        // Session
        AuthSession::init();
        AuthSession::set('email', $email);

        $notify->sendOtpEmail($user);
    } else {

        echo 'Email not found';
    }
}
