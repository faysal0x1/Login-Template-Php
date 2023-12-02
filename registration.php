<?php
require_once "./conf/auth_session.php";

include "./conf/db_con.php";


AuthSession::checkLoginStatus();

// Define variables and initialize them
$name = $username = $email = $password = $cPassword = "";
$nameErr = $usernameErr = $emailErr = $passwordErr = $cPasswordErr = "";

// Function to sanitize and validate input
function validate($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validate and sanitize input
  $name = validate($_POST["name"]);
  $email = validate($_POST["email"]);
  $password = validate($_POST["password"]);
  $cPassword = validate($_POST["cPassword"]);

  // Validate password length
  if (strlen($password) < 8) {
    $passwordErr = "Password must be at least 8 characters";
  } elseif ($password != $cPassword) {
    $passwordErr = "Passwords do not match";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailErr = "Invalid email format";
  } else {
    // Check if email already exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $emailErr = "Email already exists";
    } else {
      // Hash the password before storing in the database
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      $token = md5(uniqid(rand(), true));

      // Insert user data into the database
      $sql = "INSERT INTO users (name, email, password, created_at, token) VALUES ('$name', '$email', '$hashedPassword', NOW(), '$token')";

      try {
        if ($conn->query($sql) === TRUE) {
          echo "Registration successful. You can now log in.";

          // Redirect to the login page

          AuthSession::set('id', $conn->insert_id);
          AuthSession::set('name', $name);
          AuthSession::set('email', $email);
          AuthSession::set('token', $token);

          header("Location: home.php");
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      } catch (Throwable $th) {
        echo "Error: " . $th->getMessage();
      }
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login 04</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="stylesheet" href="css/fontawesome.css">

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
            <div class="login-img order-2 order-md-1">
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