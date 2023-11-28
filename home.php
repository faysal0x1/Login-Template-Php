<?php
echo "<h1>Hello</h1>";

session_start();

if (isset($_SESSION['email'])) {
   echo $_SESSION['email'];
}
