<?php
include "./conf/db_con.php";
require_once "./conf/auth_session.php";
include_once 'Notify.php';

if (isset($_GET['error'])) {
    $error = $_GET['error'];
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Something Went Wrong</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="css/error.css">
</head>

<body>
    <div id='oopss'>
        <div id='error-text'>
            <img src="https://cdn.rawgit.com/ahmedhosna95/upload/1731955f/sad404.svg" alt="404">
            <span>404 PAGE</span>
            <p class="p-a">
                . The page you were looking for could not be found

                <?php if (isset($error)) {
                ?>
                    <span> Error Details
                    <?php
                    echo $error;
                }
                    ?> </span>

            </p>
            <p class="p-b">
                ... Back to previous page
            </p>

            <a href='index.php' class="back">... Back to previous page</a>
        </div>
    </div>
</body>

</html>