<?php
require_once "./conf/auth_session.php";

include "./conf/db_con.php";
AuthSession::init();

AuthSession::checkLoginStatus();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login 04</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="stylesheet" href="css/fontawesome.css">
  <link rel="stylesheet" href="css/bootstrap5.css">
  <style>
    .error-message {
      color: red;
      font-weight: bold;
      margin-top: 10px;
    }
  </style>
</head>

<body>
  <section class="ftco-section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 text-center mb-5">
          <img src="./img/logo.svg" style="width: 44px" alt="" />
          <h2 class="heading-section">Welcome to the site</h2>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10">
          <div class="wrap d-md-flex">
            <!-- Imaage -->
            <div class="login-img" style="width: 90%;
    margin-top: 2rem;">
              <img src="./img/spoongle_logo_1.jpg" alt="" />
            </div>
            <!-- Content -->
            <div class="login-wrap p-4 p-md-5">
              <div class="d-flex">
                <div class="w-100">
                  <h3 class="mb-4">Sign In</h3>
                </div>
              </div>

              <form action="login.php" method="post" class="signin-form">
                <div class="form-group mb-3">
                  <label class="label" for="name">Emai;</label>
                  <input type="email" name="email" class="form-control" placeholder="Email" />
                </div>
                <div class="form-group mb-3">
                  <label class="label" for="password">Password</label>
                  <input type="password" name="password" class="form-control" placeholder="Password" required />
                </div>
                <div class="form-group">
                  <button type="submit" name="login" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
                </div>
                <div class="form-group d-md-flex">
                  <div class="w-50 text-left">
                    <label class="checkbox-wrap checkbox-primary mb-0">Remember Me
                      <input type="checkbox" checked />
                      <span class="checkmark"></span>
                    </label>
                  </div>
                  <div class="w-50 text-md-right">
                    <a href="forgetpass.php">
                      Forget Pass</a>

                  </div>
                </div>
              </form>

              <p class="text-center">Not a member? <a href="registration.php">Sign Up</a></p>
              <p> <a href="logout.php">Logout</a></p>
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