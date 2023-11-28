<?php
include "./conf/auth_session.php";

session_start();

include "./conf/db_con.php";


if($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = $_POST["password"];


  $sql = "INSERT INTO users (name, email, password,created_at) VALUES ('$username', '$email', '$password',now())";

  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    var_dump("Error: " . $sql . "<br>" . $conn->error);
  }
  }

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Login 04</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6 text-center mb-5">
            <h2 class="heading-section">Registration</h2>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-12 col-lg-10">
            <div class="wrap d-md-flex flex-md-row-reverse">
                 <!-- Imaage -->
              <div class="login-img order-2 order-md-1" >
                <img style="margin-top: 20%;" src="./img/login-img.png" alt="" />
              </div>
              <!-- Content -->
              <div class="login-wrap p-4 p-md-5 order-1 order-md-2">
                <div class="d-flex">
                  <div class="w-100">
                    <h3 class="mb-4">Registration</h3>
                  </div>

                </div>
                <form action="registration.php" method="post" class="signin-form">

                <br>
                  <div class="form-group mb-3">
                    <label class="label" for="name">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Name" required />
                  </div>

                  <div class="form-group mb-3">
                    <label class="label" for="name">Email</label>
                    <input type="text" name="email" class="form-control" placeholder="demo@mail.com" required />
                  </div>

                  <div class="form-group mb-3">
                    <label class="label" for="password">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required />
                  </div>

                  <div class="form-group mb-3">
                    <label class="label" for="password">Confirm Password</label>
                    <input type="password" name="cPassword" class="form-control" placeholder="Confirm Password" required />
                  </div>

                  <div class="form-group">
                    <button type="submit" name="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
                  </div>
                </form>
                <p class="text-center">Already have a account ? <a href="index.php">Sign In</a></p>
              </div>


            </div>
          </div>
        </div>
      </div>
    </section>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
