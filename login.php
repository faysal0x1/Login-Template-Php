<?php
// Db connection
include "./conf/db_con.php";
require_once "./conf/auth_session.php";
include_once 'Notify.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
    // Validate Data
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $email = validate($_POST['email']);
    $pass = validate($_POST['password']);

    if (empty($email) && empty($pass)) {
        header("Location: index.php?error=User Name and Password is required");
        exit();
    } else {

        // Sanitation Email
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            header("Location: index.php?error=Email is not valid");
            exit();
        }

        // Password length is minimum 6
        if (strlen($pass) < 6) {
            header("Location: index.php?error=Password must be at least 6 characters");
            exit();
        }
        try {
            $sql = "SELECT * FROM users WHERE email='$email' ";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) === 1) {

                $row = mysqli_fetch_assoc($result);

                if (password_verify($pass, $row['password'])) {

                    if ($row['twofactor'] == 1) {

                        AuthSession::init();
                        AuthSession::set('id', $row['id']);
                        AuthSession::set('name', $row['name']);
                        AuthSession::set('email', $row['email']);
                        AuthSession::set('token',  md5(uniqid()));

                        // Calling Notify Class

                        $row = mysqli_fetch_assoc($result);
                        $dbHost = "localhost";
                        $dbUser = "root";
                        $dbPassword = "";
                        $dbName = "php_login";
                        $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);


                        // $user = new User($row['id'], $row['name'], $row['email']);
                        // $notify = new Notify($db);

                        // var_dump($row);


                        $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);

                        $user = new User($row['id'], $row['name'], $row['email'],  password_hash($row['password'], PASSWORD_BCRYPT));
                        // var_dump($user);
                        $notify = new Notify($db);

                        var_dump($notify);
                        // Session
                        AuthSession::init();
                        AuthSession::set('email', $email);

                        $notify->sendTwoFAOtpEmail($user, $email);



                        header("Location: twofactor.php");
                    } else {
                        AuthSession::init();
                        AuthSession::set('id', $row['id']);
                        AuthSession::set('name', $row['name']);
                        AuthSession::set('email', $row['email']);
                        AuthSession::set('token',  md5(uniqid()));
                        header("Location: home.php");
                        exit();
                    }
                } else {
                    header("Location: index.php?error=Incorect User name or password");
                    exit();
                }
            } else {
                header("Location: index.php?error=Incorect User name or password");
                exit();
            }
        } catch (\Throwable $th) {
            header("Location: index.php?error=Incorect User name or password");
        }
    }
} else {

    header("Location: index.php");

    exit();
}
