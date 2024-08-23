<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!----======== CSS ======== -->
  <link rel="stylesheet" href="0_Capstone_WebSite_Services.css" />

  <!----===== Icons ===== -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <!--=====Change name mo na lang====-->

  <style>

  </style>
  <title>Doc Lenon Veterinary | Services</title>
  <link rel="icon" type="image/x-icon" href=".vscode\Doc Lenon Logo.png">
</head>

<body>
  <nav class="nav">
    <div class="container">
      <div class="logo">
        <?php require 'title.php'; ?>
      </div>
      <div id="mainListDiv" class="main_list">
        <ul class="navlinks">
          <li><a href="website.php">About</a></li>
          <li><a href="services.php">Services</a></li>
          <li><a href="products.php">Products</a></li>
        </ul>
      </div>
      <span class="navTrigger">
        <i></i>
        <i></i>
        <i></i>
      </span>
    </div>
    </div>
  </nav>
  <!--top-->
  <section class="home">
    <div class="clinic-name">
      <a>Our Services</a>
    </div>
  </section>

  <!--Services-->
  <h1>Services</h1>
  <div class="clinic-services">
    <?php
    require 'database-conn.php';
    slider_services();
    function slider_services()
    {
      global $conn;
      $category = "Services";

      $query = "SELECT * FROM serviceandproduct WHERE categories = '$category'";
      $result = mysqli_query($conn, $query);

      if (!$result) {
        die("Query failed: " . mysqli_error($conn));
      }

      foreach ($result as $row) {
        $imageName = $row['imagename'];
        $imageType = $row['imagetype'];
        $imageData = $row['imagedata'];

        $imageScr = "data:" . $imageType . ";base64," . base64_encode($imageData);
        $name = $row['title'];
        $description = $row['description'];
    ?>
        <div class="services">
          <div class="services-image">
            <img src="<?php echo $imageScr; ?>" />
          </div>
          <div class="services-contents">
            <h2><?php echo $name; ?></h2>
            <p><?php echo $description; ?></p>
          </div>
        </div>
    <?php
      }
    }
    ?>
  </div>


  <div class="footer" style="
  display: flex;
  justify-content: center;
  align-items: center;
  ">
    <?php
    require 'database-conn.php';

    $query1 = "SELECT * FROM cliniccontact WHERE id = '1'";
    $result1 = mysqli_query($conn, $query1);
    $row1 = mysqli_fetch_assoc($result1);

    $email = $row1['email'];
    $social1 = $row1['social1'];
    $social2 = $row1['social2'];
    $social3 = $row1['social3'];
    ?>
    <br>
    <div class="media-links">
      <div style="margin-right: 5px;"><img src=".vscode\icons8-email-50.png" alt="Email" />
      <a href="https://mail.google.com/" style="text-decoration: none; color:#94cdf9;">
            <h3><?php echo $email; ?></h3></div>
      <div style="margin-right: 5px;">
      <img src=".vscode\icons8-facebook-50.png" alt="Facebook" />
      <a href="https://www.facebook.com/profile.php?id=61551675606645" style="text-decoration: none; color:#94cdf9;">
            <h3><?php echo $social1; ?></h3>
      </div>
      <div style="margin-right: 5px;">
      <img src=".vscode\icons8-ig-50.png" alt="Instagram" />
      <a href="https://www.instagram.com/" style="text-decoration: none; color:#94cdf9;">
            <h3><?php echo $social2; ?></h3>
      </div>
      <div style="margin-right: 5px;">
      <img src=".vscode\icons8-tiktok-50.png" alt="Tiktok" />
      <a href="https://www.tiktok.com/" style="text-decoration: none; color:#94cdf9;">
            <h3><?php echo $social3; ?></h3>
      </div>
    </div>
  </div>
  <div class="footer">
    <!-- <p>est. 2015</p> -->
  </div>
</body>

</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


<!-- Function used to shrink nav bar removing paddings and adding black background -->
<script>
  $(window).scroll(function() {
    if ($(document).scrollTop() > 50) {
      $(".nav").addClass("affix");
      console.log("OK");
    } else {
      $(".nav").removeClass("affix");
    }
  });

  $(".navTrigger").click(function() {
    $(this).toggleClass("active");
    console.log("Clicked menu");
    $("#mainListDiv").toggleClass("show_list");
    $("#mainListDiv").fadeIn();
  });
</script>