<?php


class AuthSession
{

    public function __construct()
    {
        self::init();
    }
    public static function init()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function start()
    {
        session_start();
    }

    public static function destroy()
    {
        self::init();  // Make sure to start the session before destroying it

        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'home.php';

        // Destroy the session
        session_destroy();

        // Redirect to the previous page
        header("Location: $referer");
        exit();
        exit();
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function checkLoginStatus()
    {
        self::init();

        // Check if the required session variables are set
        if (isset($_SESSION['email']) && isset($_SESSION['id']) && isset($_SESSION['name']) && isset($_SESSION['token'])) {
            // Redirect to the home page
            header('Location: home.php');
            exit();
        }
    }

    public static function authenticated()
    {


        $token = self::get('token');
        $email = self::get('email');
        $sql = "SELECT * FROM users WHERE email  = '$email'";

        include "./conf/db_con.php";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {

            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];
            if ($token != $row['token']) {
                header('location:index.php');
            }
        }
    }
}
