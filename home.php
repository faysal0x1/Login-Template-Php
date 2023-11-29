<?php


include "./conf/db_con.php";
require_once 'conf/auth_session.php';


$session = new AuthSession();

// $token = $session->get('token');
// $email = $session->get('email');
// $sql = "SELECT * FROM users WHERE email  = '$email'";

// $result = mysqli_query($conn, $sql);

// if (mysqli_num_rows($result) === 1) {

//    $row = mysqli_fetch_assoc($result);
//    $id = $row['id'];
//    if ($token != $row['token']) {
//       header('location:login.php');
//    }
// }

// $session->authenticated();


if ($session->get('token') == null) {
   header('location:index.php');
}
// AuthSession::checkLoginStatus();


// $session->checkLoginStatus();

$session->get('email');
echo "<br>";
echo "<br>";
echo $session->get('id');
echo "<br>";
echo "<br>";
echo $session->get('id');
echo "<br>";
echo "<br>";
echo $session->get('token');
echo "<br>";
echo "<br>";


?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>

<body>


   <p> <a href="logout.php">Logout</a></p>

</body>

</html>