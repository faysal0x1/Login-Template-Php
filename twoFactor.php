<?php
require_once 'conf/auth_session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap5.css">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .otp-input {
            width: 3rem;
            /* Adjust the width as needed */
            height: 3rem;
            text-align: center;
            font-size: 1.5rem;
            margin: 0 0.5rem;
        }

        .otp-container {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }
    </style>
    <title>OTP Verification</title>
</head>

<body>
    <?php
    // echo AuthSession::get('email');
    $session = new AuthSession();
    $session->init();
    $email = $session->get('email');
    if (!$email) {
        header('Location: login.php');
        exit;
    }
    ?>
    <div class="container text-center">
        <h2 class="mb-4">Two Step Verification</h2>
        <form action="twoFactor.php" method="post" id="otpForm">
            <div class="otp-container">
                <input type="text" class="form-control otp-input" maxlength="1" pattern="\d" required>
                <input type="text" class="form-control otp-input" maxlength="1" pattern="\d" required>
                <input type="text" class="form-control otp-input" maxlength="1" pattern="\d" required>
                <input type="text" class="form-control otp-input" maxlength="1" pattern="\d" required>
                <input type="text" class="form-control otp-input" maxlength="1" pattern="\d" required>
                <input type="text" class="form-control otp-input" maxlength="1" pattern="\d" required>
            </div>
            <button type="button" class="btn btn-primary mt-3" onclick="submitOtpForm()">Verify OTP</button>
        </form>
    </div>

    <script src="js/bootstrap5.js"></script>
    <script>
        function submitOtpForm() {
            // Get all OTP input values
            var otpValues = document.querySelectorAll('.otp-input');

            // Convert the NodeList to an array and join the values into a single string
            var otpString = Array.from(otpValues).map(input => input.value).join('');
            // Redirect to process_otp.php with the OTP string as a query parameter
            window.location.href = 'twofactor_process.php?otp=' + otpString;
        }

        document.addEventListener("input", function(e) {
            if (e.target.classList.contains("otp-input")) {
                var maxLength = parseInt(e.target.maxLength, 10);
                var currentLength = e.target.value.length;

                if (currentLength === maxLength) {
                    var nextInput = e.target.nextElementSibling;
                    if (nextInput) {
                        nextInput.focus();
                    }
                }
            }
        });

        document.addEventListener("keydown", function(e) {
            if (e.key === "Backspace") {
                var currentInput = document.activeElement;

                if (currentInput.classList.contains("otp-input") && currentInput.value.length === 0) {
                    var previousInput = currentInput.previousElementSibling;

                    if (previousInput) {
                        previousInput.focus();
                    }
                }
            }
        });
    </script>
</body>

</html>