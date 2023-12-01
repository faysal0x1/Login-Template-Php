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
        if (isset($_SESSION['email']) && isset($_SESSION['id']) && isset($_SESSION['name']) && isset($_SESSION['loggedToken'])) {
            // Redirect to the home page
            header('Location: home.php');
            exit();
        }
    }

    public static function isAuthenticated()
    {
        $token = self::get('token');
        $email = self::get('email');

        // Include the database connection file
        include "./conf/db_con.php";

        // Ensure $conn is not null
        if (!$conn) {
            echo 'Error: Database connection not established.';
            exit();
        }

        // Prepare the SQL statement with a parameterized query
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);

        // Bind the parameter
        mysqli_stmt_bind_param($stmt, "s", $email);

        // Execute the query
        mysqli_stmt_execute($stmt);

        // Get the result
        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            // Handle database query error
            echo 'Error: ' . mysqli_error($conn);
            exit();
        }

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if ($row['twofactor'] == 1) {
                $totp_secret = self::get('totp_secret');
                if ($row['totp_secret'] !== $totp_secret) {
                    header('location: index.php');
                    exit();
                }
            }

            if ($token != $row['token']) {
                header('location: index.php');
                exit();
            }
        }

        // Close the prepared statement and the database connection after use
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }



    public static function generateTOTPSecret()
    {
        $secret = bin2hex(openssl_random_pseudo_bytes(10));
        self::set('totp_secret', $secret);
        return $secret;
    }


    public static function isLoggedIn()
    {
        return isset($_SESSION['id']);
    }

    public static function PdoDb()
    {
        $dbHost = "localhost";
        $dbUser = "root";
        $dbPassword = "";
        $dbName = "php_login";
        $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);

        return $db;
    }
}
