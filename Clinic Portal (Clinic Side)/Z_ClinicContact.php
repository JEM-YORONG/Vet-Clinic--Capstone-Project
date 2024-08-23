<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!----======== CSS ======== -->
  <link rel="stylesheet" href="Capstone_ClinicContact.css" />
  <link rel="stylesheet" href="Capstone_ClinicAboutUs.css">

  <!----===== Icons ===== -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

  <?php require 'alert-notif-function.php'; ?>
  <!--=====Change name mo na lang====-->
  <title>Doc Lenon Veterinary Clinic | Contact</title>
  <link rel="icon" type="image/x-icon" href=".vscode\Doc Lenon Logo.png">

  <?php require 'timezone.php'; ?>
</head>

<body>
  <!--=====Navigation Bar====-->
  <?php require 'nav-bar.html.php'; ?>

  <script>
        $("#con").css("color", "#5a81fa");
        $("#tact").css("color", "#5a81fa");
    </script>

  <!--=====Pinaka taas/ title ganon====-->
  <section class="dashboard">
    <div class="top">
      <i class="sidebar-toggle"><span class="material-symbols-outlined"> menu </span></i>
      <div class="title">
        <span class="text">Clinic Contacts</span>
        <?php require 'alert-notif.php'; ?>
      </div>
    </div>
    <!--=====Info====-->

    <div class="web-content">
    </div>

    <div class="about-clinic">
    <div style="   
        float: right;
        margin: 60px 20px 20px 20px;
        ">
      <div class="button-wrap" style="display: block;" id="divUpdate">
        <label class="button" onclick="showC();" style="width: 200px; text-align: center;">
          <span class="material-symbols-outlined">
            edit
          </span>
        </label>
      </div>
      <div  style="display: none;" id="divConfirm">
        <div class="button-wrap" style="padding: 10px;">
          <label class="button" onclick="submitData('addContact');" style="width: 500px; text-align: center;">Ok</label>
          <?php require 'clinic-contact.js.php'; ?>
        </div>
        <div class="button-wrap" style="padding: 10px;">
          <label class="button" onclick="hideC();" style="width: 500px; text-align: center;">Cancel</label>
        </div>
      </div>
    </div>
      <div style="   
        margin-top: 50px;
        display: flex;
        align-self: center;
        justify-content: center;
        ">
        <?php
        require 'database-conn.php';

        $query = "SELECT * FROM cliniccontact WHERE id = '1'";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
          $c1 = $row['contact1'];
          $c2 = $row['contact2'];
          $e = $row['email'];
          $s1 = $row['social1'];
          $s2 = $row['social2'];
          $s3 = $row['social3'];
        }
        ?>
        <div class="contact-container">
          <br />
          <label>Contact Number</label>
          <br />
          <div class="cnumber-div">
            <input type="" class="input" placeholder="09*********" id="contact1" maxlength="11" onkeydown="return /[0-9\s/b]/i.test(event.key)" value="<?php echo $c1; ?>" disabled/>
            <input type="" class="input" placeholder="09*********" id="contact2" maxlength="11" onkeydown="return /[0-9\s/b]/i.test(event.key)" value="<?php echo $c2; ?>" disabled/>
          </div>
          <label>Email</label>
          <br />
          <input type="text" placeholder="Email" class="email-input" id="email" disabled autocomplete="off" value="<?php echo $e; ?>">
          <br />
          <label>Social Media Accounts</label>
          <br />
          <input type="text" placeholder="Facebook Link" class="socmed-input" id="social1" disabled autocomplete="off" value="<?php echo $s1; ?>">
          <input type="text" placeholder="Instagram Link" class="socmed-input" id="social2" disabled autocomplete="off" value="<?php echo $s2; ?>">
          <input type="text" placeholder="Tiktok Link" class="socmed-input" id="social3" disabled autocomplete="off" value="<?php echo $s3; ?>">
        </div>
      </div>
    </div>

    <!-- buttons -->

  </section>

  <script>
    const body = document.querySelector("body"),
      modeToggle = body.querySelector(".mode-toggle");
    sidebar = body.querySelector("nav");
    sidebarToggle = body.querySelector(".sidebar-toggle");

    sidebarToggle.addEventListener("click", () => {
      sidebar.classList.toggle("close");
      if (sidebar.classList.contains("close")) {
        localStorage.setItem("status", "close");
      } else {
        localStorage.setItem("status", "open");
      }
    });

    function showC() {
      document.getElementById("divConfirm").style.display = "block";
      document.getElementById("divUpdate").style.display = "none";

      document.getElementById("contact1").disabled = false;
      document.getElementById("contact2").disabled = false;
      document.getElementById("email").disabled = false;
      document.getElementById("social1").disabled = false;
      document.getElementById("social2").disabled = false;
      document.getElementById("social3").disabled = false;
    }

    function hideC() {
      document.getElementById("divConfirm").style.display = "none";
      document.getElementById("divUpdate").style.display = "block";

      document.getElementById("contact1").disabled = true;
      document.getElementById("contact2").disabled = true;
      document.getElementById("email").disabled = true;
      document.getElementById("social1").disabled = true;
      document.getElementById("social2").disabled = true;
      document.getElementById("social3").disabled = true;
    }
  </script>
</body>

</html>