<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="Capstone_Login.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet" />

  <?php require 'alert-notif-function.php'; ?>
  <title>Doc Lenon Veterinary Clinic | Login</title>
  <link rel="icon" type="image/x-icon" href=".vscode\Doc Lenon Logo.png">
</head>

<body>
  <?php
  require 'database-conn.php';

  $query = "SELECT * FROM aboutus WHERE id = '1'";
  $result = mysqli_query($conn, $query);

  while ($row = mysqli_fetch_assoc($result)) {
    $imageName = $row['imagename'];
    $imageType = $row['imagetype'];
    $imageData = $row['imagedata'];

    $title = $row['title'];
    $address = $row['address'];
    $intro = $row['intro'];
    $about = $row['about'];
  }

  $imageScr = "data:" . $imageType . ";base64," . base64_encode($imageData);
  ?>
  <section class="side">
    <img src="<?php echo $imageScr; ?>" alt="" />
    <div class="separator-vertical"></div>
  </section>

  <section class="main">
    <div class="login-container">
      <p class="title"><?php echo $title; ?></p>
      <p class="system-title">Vet Portal</p>

      <p class="welcome-message" id="loginTitle">LOGIN</p>

      <form class="login-form" method="post" id=login>
        <div class="form-control">
          <input type="text" placeholder="Email" id="username" autocomplete="off" />
          <i><span class="material-symbols-outlined">person</span></i>
        </div>
        <div class="form-control">
          <input type="password" placeholder="Password" id="password" />
          <i><span class="material-symbols-outlined">lock</span></i>
        </div>
        <div class="form-password">
        </div>

        <div class="form-control" style="text-align: center;">
          <button type="button" class="submit" onclick="login('checker');">Login</button>
          <div class="form-control" style="color:#024062; text-align: center;">
            <a onclick="hideLogin();">Forgot Password</a>
          </div>
        </div>
      </form>

      <!-- forgot password -->
      <form class="login-form" method="post" id="forgotPass" style="display: none;">
        <div class="form-control">
          <input type="text" placeholder="Enter your email" id="forgotEmail" autocomplete="off" />
          <i><span class="material-symbols-outlined">person</span></i>
        </div>
        <div class="form-control">
          <input type="text" placeholder="Enter your contact number" id="forgotPassword" />
          <i><span class="material-symbols-outlined">
              contacts
            </span></i>
        </div>

        <div class="form-password">
        </div>
        <div class="form-control" style="text-align: center;">
          <button type="button" class="submit" onclick="login('forgot');">Submit</button>
          <div class="form-control" style="color:#024062; text-align: center;">
            <a onclick="showLogin();">Back to Login</a>
          </div>
        </div>
      </form>

      <?php require 'alert-notif.php'; ?>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js">
      </script>
      <script>
        function hideLogin() {
          document.getElementById("login").style.display = "none";
          document.getElementById("forgotPass").style.display = "block";
          document.getElementById("loginTitle").innerHTML = "Forgot Password";
        }

        function showLogin() {
          document.getElementById("login").style.display = "block";
          document.getElementById("forgotPass").style.display = "none";
          document.getElementById("loginTitle").innerHTML = "Login";
        }

        function login(action) {
          $(document).ready(function() {
            var data = {
              action: action,
              id: $("#id").val(),
              username: $("#username").val(),
              password: $("#password").val(),

              email: $("#forgotEmail").val(),
              contact: $("#forgotPassword").val(),
            }

            $.ajax({
              url: 'login-function.php',
              type: 'post',
              data: data,

              success: function(response) {
                //alert(response);
                //let username = $_SESSION['username'];
                if (response == "admin") {
                  successAlert("Welcome Admin");
                  location.replace("zHTML_dashboard.php");
                } else if (response == "secretary") {
                  successAlert("Welcome Secretary");
                  location.replace("zStaff_dashboard.php");
                } else if (response == "veterinarian") {
                  successAlert("Welcome Veterinarian");
                  location.replace("zStaff_dashboard.php");
                } else if (response == "User not found!") {
                  successAlert("User not found!");
                } else if (response == "Invalid email!") {
                  successAlert("Invalid email!");
                } else if (response == "Invalid password!") {
                  successAlert("Invalid password!");
                } else if (response == "Invalid email or password!") {
                  successAlert("Invalid email or password!");
                } else if (response == "Invalid email or contact!") {
                  successAlert("Invalid email or contact!");
                } else if (response == "Contact must be an 11-digit number!") {
                  successAlert("Contact must be an 11-digit number!");
                } else {
                  successAlert("Your request has been submitted. An SMS with your new password will be sent to your contact number. Please wait a few minutes.");
                  forgotPass($("#forgotEmail").val(), response);
                }
              }
            });
          });
        }

        //         //forgot password
        //         function forgotPass(email, pass) {

        //           const message = `Hello,

        // We hope you're having a great day! As a friendly reminder, here is your account information:

        // Email: ${email}
        // Password: ${pass}

        // Please be mindful to keep your password secure. If you ever forget it, you can use our "Forgot Password" feature on the login page to reset it.

        // Have a wonderful day!

        // Best regards,
        // Doc Lenon Vet Clinic`;

        //           var settings = {
        //             "url": "https://8g4r63.api.infobip.com/sms/2/text/advanced",
        //             "method": "POST",
        //             "timeout": 0,
        //             "headers": {
        //               "Authorization": "App 18d4be336e5a3405bcb923d9b274cd3d-78e18f47-e4f2-4d38-ae7a-6db6601c2d33",
        //               "Content-Type": "application/json",
        //               "Accept": "application/json"
        //             },
        //             "data": JSON.stringify({
        //               "messages": [{
        //                 "destinations": [{
        //                   "to": "639694903757"
        //                 }],
        //                 "from": "InfoSMS",
        //                 "text": message
        //               }]
        //             }),
        //           };

        //           $.ajax(settings).done(function(response) {
        //             console.log(response);
        //           });
        //         }

        //forgot password (new account)
        function forgotPass(email, pass) {

          const message = `Hello,

We hope you're having a great day! As a friendly reminder, here is your account information:

Email: ${email}
Password: ${pass}

Please be mindful to keep your password secure. If you ever forget it, you can use our "Forgot Password" feature on the login page to reset it.

Have a wonderful day!

Best regards,
Doc Lenon Vet Clinic`;

          var settings = {
            "url": "https://n8pmd8.api.infobip.com/sms/2/text/advanced",
            "method": "POST",
            "timeout": 0,
            "headers": {
              "Authorization": "App b0c05124d8fd2f2abda7233584db174d-27d722c3-8a58-4aa2-addf-cd0b5fa9a9de",
              "Content-Type": "application/json",
              "Accept": "application/json"
            },
            "data": JSON.stringify({
              "messages": [{
                "destinations": [{
                  "to": "639217105499"
                }],
                "from": "InfoSMS",
                "text": message
              }]
            }),
          };

          $.ajax(settings).done(function(response) {
            console.log(response);
          });
        }
      </script>
    </div>
  </section>
</body>

</html>