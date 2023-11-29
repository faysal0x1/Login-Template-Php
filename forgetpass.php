<html>
  <head>
    <title>Forgot Password Form</title>
    <link rel="stylesheet" href="css/style.css" />
    <style>
      hr {
        background: #4bc970;
        height: 1px;
        border: 0;
        border-top: 1px solid #ccc;
        padding: 0;
        text-align: right;
        width: 5%;
        float: center;
      }
      span {
        color: red;
      }
      label {
        padding-top: 15px;
        font-weight: bold;
      }

      body {
        font-size: 13px;
        font-family: "Nunito", sans-serif;
        color: #384047;
      }

      form {
        font-size: 16px;
        max-width: 300px;
        margin: 10px auto;
        padding: 10px 20px;
        background: #f4f7f8;
        border-radius: 0px;
      }

      h1 {
        padding-top: 2em;
        font-size: 32px;
        text-align: center;
      }

      h3 {
        padding-top: 1em;
        font-size: 20px;
        text-align: center;
      }

      button {
        padding: 12px 39px 13px 39px;
        color: #fff;
        background-color: #e3b04b;
        font-size: 18px;
        text-align: center;
        font-style: normal;
        border: 1px solid #3ac162;
        /* //border-width: 1px 1px 3px; */
        margin-bottom: 10px;
        overflow: hidden;
      }

      label {
        display: block;
        margin-bottom: 8px;
      }
      .custom-gradient {
  background-image: linear-gradient(to right, #f00 0%, #00f 50%, #f00 100%);
}


      @media screen and (min-width: 480px) {
        form {
          max-width: 480px;
        }
      }
    </style>
  </head>

  <body>


   <div style="margin-top: 155px;" class=" bg-">
    <h3>Enter your email address to reset your password</h3>

    <form action="forget.php" method="post" class="border border-black p-5  bg-gradient">
      <label for="mail">Email</label>
      <input type="email" id="name" name="name" class="form-control" placeholder="Enter your email address" required onblur="validateName(name)" />
      <br />
      <button type="submit" class=" ">Submit</button>
      <span id="nameError" style="display: none">There was an error with your email</span>
    </form>

   </div>

    <script>
      function validateName(x) {
        var re = /[A-Za-z@0-9.]/;
        if (re.test(document.getElementById(x).value)) {
          return true;
        } else {
          // document.getElementById(x ).style.background ='#e35152';
          document.getElementById(x + "Error").style.display = "block";
          return false;
        }
      }
    </script>
  </body>
</html>
