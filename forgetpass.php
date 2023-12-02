<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password Form</title>
    <link rel="stylesheet" href="css/bootstrap5.css">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
</head>

<body>

    <div class="container">
        <form class="col-md-6 border border-black p-5 " action="forget.php" method="post">
            <h2 class="mb-4">Forget Password</h2>
            <div class="mb-3">
                <label for="inputEmail" class="form-label">Email address</label>
                <input type="email" id="name" name="email" class="form-control" placeholder="Enter your email address" required />
            </div>
            <div class="mb-3">
                <p>Enter the email address associated with your account. We'll send you a link to reset your password.</p>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="js/bootstrap5.js"></script>
</body>

</html>