<?php


include "./conf/db_con.php";
require_once 'conf/auth_session.php';


$session = new AuthSession();

// $session->checkLoginStatus();


// if ($session->get('loggedToken') == null) {
//    header('location:index.php');
// }else{
//    $session->checkLoginStatus();
// }
// AuthSession::checkLoginStatus();


// $session->checkLoginStatus();

echo $session->get('email');
echo "<br>";
echo "<br>";
echo $session->get('name');
echo "<br>";
echo "<br>";
echo $session->get('id');
echo "<br>";
echo "<br>";
echo $session->get('loggedToken');
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