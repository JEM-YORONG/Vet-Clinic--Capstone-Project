<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!----======== CSS ======== -->
  <link rel="stylesheet" href="Capstone_ClinicAnnouncement.css" />
  <link rel="stylesheet" href="Capstone_ClinicServNProd.css">
  <link rel="stylesheet" href="Capstone_ClinicAboutUs copy.css">
  <link rel="stylesheet" href="Capstone_Staff.css">
  <!----======== CSS ======== -->
  <link rel="stylesheet" href="Capstone_CustNPetRecords.css" />

  <!----===== Icons ===== -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <?php require 'alert-notif-function.php'; ?>

  <!-- pagenation design -->
  <style>
    .pagination-container {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 20px;
    }

    .pagination-button {
      background-color: #ffffff;
      border: 1px solid #5a81fa;
      border-radius: 8px;
      box-sizing: border-box;
      color: #5a81fa;
      cursor: pointer;
      font-size: 13px;
      line-height: 29px;
      padding: 0 10px;
      margin: 0 5px;
      margin-top: 10px;
    }

    .pagination-button.active {
      background-color: #5a81fa;
      color: #ffffff;
    }
  </style>

  <!--=====Change name mo na lang====-->
  <title>Doc Lenon Veterinary Clinic | Announcement</title>
  <link rel="icon" type="image/x-icon" href=".vscode\Doc Lenon Logo.png">

  <?php require 'timezone.php'; ?>
</head>

<body>
  <!--=====Navigation Bar====-->
  <?php require 'nav-bar.html.php'; ?>

  <script>
    $("#ann").css("color", "#5a81fa");
    $("#ment").css("color", "#5a81fa");
  </script>

  <!--=====Pinaka taas/ title ganon====-->
  <section class="dashboard">
    <div class="top">
      <i class="sidebar-toggle"><span class="material-symbols-outlined"> menu </span></i>
      <div class="title">
        <span class="text">Clinic Announcement</span>
        <?php require 'alert-notif.php'; ?>
        <input type="text" id="deleteTitle" placeholder="for title" style="display: none;">
      </div>
    </div>

    <!---->
    <div class="web-content">
      <div style="padding-left: 80%;">
        <input type="text" id="id" style="display: none;">
        <div style="padding-top: 10px;">
          <button class="add-button-ann" onclick="openAnnouncement()" style="
              background-color: #5a81fa;
    border: 1px solid #21305d00;
    border-radius: 8px;
    box-sizing: border-box;
    color: #ffffff;
    cursor: pointer;
    font-size: 13px;
    line-height: 29px;
    padding: 0 10px 0 11px;
    font-weight: bold;
          ">Add New</button>
        </div>
      </div>

      <div class="boxes-overview" id="refresh">
        <!-- product boxes -->
        <?php require 'announcement-fetch-data.php'; ?>
        <!--End of display-->
      </div>

      <div id="pagination-container" class="pagination"></div>

      <script>
        var rowsPerPage = 12; // Adjust this to your desired number of rows per page
        var currentPage = 1;

        function showPage(pageNumber) {
          var startIndex = (pageNumber - 1) * rowsPerPage;
          var endIndex = startIndex + rowsPerPage;

          var rows = document.getElementById('refresh').querySelectorAll('.box');

          for (var i = 0; i < rows.length; i++) {
            rows[i].style.display = (i >= startIndex && i < endIndex) ? '' : 'none';
          }

          updatePaginationButtons(pageNumber);
          currentPage = pageNumber;
        }

        function updatePaginationButtons(activePage) {
          var buttons = document.getElementsByClassName('pagination-button');

          for (var i = 0; i < buttons.length; i++) {
            buttons[i].classList.remove('active');
          }

          var activeButton = document.getElementById('pageBtn' + activePage);

          if (activeButton) {
            activeButton.classList.add('active');
          }
        }

        function generatePaginationControls() {
          var paginationContainer = document.getElementById('pagination-container');
          var rowCount = document.getElementById('refresh').querySelectorAll('.box').length;
          var pageCount = Math.ceil(rowCount / rowsPerPage);

          var paginationHtml = '<button class="pagination-button" onclick="previousPage()">Previous</button>';

          for (var i = 1; i <= pageCount; i++) {
            paginationHtml += '<button id="pageBtn' + i + '" class="pagination-button ' + (i === currentPage ? 'active' : '') + '" onclick="showPage(' + i + ')">' + i + '</button>';
          }

          paginationHtml += '<button class="pagination-button" onclick="nextPage()">Next</button>';

          paginationContainer.innerHTML = paginationHtml;
        }

        function previousPage() {
          if (currentPage > 1) {
            showPage(currentPage - 1);
          }
        }

        function nextPage() {
          var rowCount = document.getElementById('refresh').querySelectorAll('.box').length;
          var pageCount = Math.ceil(rowCount / rowsPerPage);

          if (currentPage < pageCount) {
            showPage(currentPage + 1);
          }
        }

        function filterTable() {
          var input, filter, table, divs, i, txtValue;
          input = document.getElementById("search");
          filter = input.value.toUpperCase();
          table = document.getElementById("refresh");
          divs = table.querySelectorAll('.box');

          if (filter === "") {
            showPage(1);
            return;
          }

          for (i = 0; i < divs.length; i++) {
            var visible = false;
            txtValue = divs[i].textContent || divs[i].innerText;

            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              visible = true;
            }

            divs[i].style.display = visible ? "" : "none";
          }

          // After filtering, reset to the first page
          showPage(1);
        }

        generatePaginationControls();
        showPage(1);
      </script>

      <!--Add Announcement-->
      <div class="form-popup-servprod" id="myForm-announcement">
        <form action="" class="form-container-servprod" method="post" enctype="multipart/form-data">
          <div class="title">
            Upload Announcement
          </div>
          <div class="form">
            <div class="inputfield-image">
              <img id="preview" src=".vscode/Images/didunkow.jpg" alt="Image Preview" width="600" height="400" style="object-fit: cover;">
              <input type="file" id="addImage" accept="image/*" value="Upload Image">
            </div>
            <div class="inputfield">
              <label>Title</label>
              <input type="text" class="input" id="addTitle" />
            </div>
            <div class="inputfield">
              <label>Description</label>
              <textarea type="text" id="addDescription" class="input" rows="5" cols="110" resize="none" placeholder="Type here..."></textarea>
            </div>

            <div class="inputfield">
              <?php require 'announcement-data.js.php'; ?>
              <input type="button" value="Upload" class="btn-send" onclick="submitData('Add');" />
            </div>
            <input type="button" value="Close" class="btn-cancel" onclick="closeFormAnnouncement()" />
          </div>
        </form>
      </div>

      <!--Delete-->
      <div class="form-popup-delete" id="myForm-delete" style="display: none;">
        <form action="/action_page.php" class="form-container-delete">
          <div class="title">Are you sure?</div>
          <div class="form-delete">
            <label>This will be permanently deleted</label>
            <div class="inputfield">
              <input type="button" value="Cancel" class="btn-cancel" onclick="closeFormDelete()" />
              <input type="button" value="Delete" class="btn-delete" onclick="submitData('Delete');" />
            </div>
          </div>
        </form>
      </div>

      <!--Edit Announcement-->
      <div class="form-popup-servprod" id="myForm-Editannouncement">
        <form action="" class="form-container-servprod" method="post" enctype="multipart/form-data">
          <div class="title">
            Upload Announcement
          </div>
          <div class="form">
            <div class="inputfield-image">
              <img id="editPreview" src=".vscode/Images/didunkow.jpg" alt="Image Preview" width="600" height="400" style="object-fit: cover;">
              <input type="file" id="editImage" accept="image/*" value="Upload Image">
            </div>
            <div class="inputfield">
              <label>Title</label>
              <input type="text" class="input" id="editTitle" />
            </div>
            <div class="inputfield">
              <label>Description</label>
              <textarea type="text" id="editDescription" class="input" rows="5" cols="110" resize="none" placeholder="Type here..."></textarea>
            </div>

            <div class="inputfield">
              <?php require 'announcement-data.js.php'; ?>
              <input type="button" value="Upload" class="btn-send" onclick="submitData('Edit');" />
            </div>
            <input type="button" value="Close" class="btn-cancel" onclick="closeEditFormAnnouncement(); clearId();" />
          </div>
        </form>
      </div>
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

    function getInfo(imageName, imageSrc, title, description, id) {
      const fileInput = document.getElementById("editImage");
      const blob = dataURItoBlob(imageSrc); // Convert the data URI to a Blob
      const file = new File([blob], imageName); // Create a File with the Blob and filename
      const dataTransfer = new DataTransfer();
      dataTransfer.items.add(file);
      fileInput.files = dataTransfer.files;

      document.getElementById("id").value = id;
      document.getElementById("editPreview").src = imageSrc;
      document.getElementById("editTitle").value = title;
      document.getElementById("editDescription").value = description;
    }

    function dataURItoBlob(dataURI) {
      // Convert a data URI to a Blob
      const byteString = atob(dataURI.split(',')[1]);
      const mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
      const ab = new ArrayBuffer(byteString.length);
      const ia = new Uint8Array(ab);
      for (let i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
      }
      return new Blob([ab], {
        type: mimeString
      });
    }

    function openFormDelete() {
      document.getElementById("myForm-delete").style.display = "block";
    }

    function closeFormDelete() {
      document.getElementById("myForm-delete").style.display = "none";
    }

    function getRow(rowId, title) {
      document.getElementById("editTitle").value = rowId;
      document.getElementById("deleteTitle").value = title;
    }


    function clearId() {
      document.getElementById("id").value = "";
    }

    function openAnnouncement() {
      document.getElementById("myForm-announcement").style.display = "block";
    }

    function closeFormAnnouncement() {
      document.getElementById("myForm-announcement").style.display = "none";
    }

    function openEditAnnouncement() {
      document.getElementById("myForm-Editannouncement").style.display = "block";
    }

    function closeEditFormAnnouncement() {
      document.getElementById("myForm-Editannouncement").style.display = "none";
    }

    //load image add
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          document.getElementById('preview').src = e.target.result;
        }

        reader.readAsDataURL(input.files[0]);
      }
    }

    document.getElementById('addImage').addEventListener('change', function() {
      readURL(this);
    });

    //load image edit
    function readURLEdit(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          document.getElementById('editPreview').src = e.target.result;
        }

        reader.readAsDataURL(input.files[0]);
      }
    }

    document.getElementById('editImage').addEventListener('change', function() {
      readURLEdit(this);
    });
  </script>
</body>

</html>