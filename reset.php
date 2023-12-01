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
if (isset($_GET['token'])) {
    $error = "";

    $token = $_GET['token'];

    // var_dump($token);

    if (!isset($_GET['email'])) {
        $error = "Invalid Url";
    } else {
        $email = $_GET['email'];

        var_dump($email);


        $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);

        $notify = new Notify($db);

        $userId = $notify->getUserId($email);

        var_dump($userId);

        if ($userId) {
            if (isset($_POST['password']) && isset($_POST['cPassword'])) {

                $password = $_POST['password'];
                $cPassword = $_POST['cPassword'];

                if ($password == $cPassword) {

                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    if ($notify->updateUserPassword($hashedPassword, $userId)) {
                        AuthSession::init();
                        AuthSession::set('id', $row['id']);
                        AuthSession::set('name', $row['name']);
                        AuthSession::set('email', $row['email']);
                        AuthSession::set('token',  md5(uniqid()));

                        header("Location: home.php");
                        exit();
                    } else {
                        $error = "Update Issue";
                    }
                } else {
                    $error = "Passwords don't match!";
                }
            }
        }
    }
} else {
    $error = "Something went wrong! sfs";

    echo $error;
}
