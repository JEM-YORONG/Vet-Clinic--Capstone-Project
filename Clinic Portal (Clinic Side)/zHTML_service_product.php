<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!----======== CSS ======== -->
  <link rel="stylesheet" href="Capstone_ClinicServNProd.css" />

  <!----======== CSS ======== -->
  <link rel="stylesheet" href="Capstone_CustNPetRecords.css" />
  <link rel="stylesheet" href="Capstone_ClinicAboutUs copy.css">
  <link rel="stylesheet" href="Capstone_Staff.css">

  <!----===== Icons ===== -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

  <!----===== Icons ===== -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

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

  <style>
    .box {
      display: block;
    }
  </style>

  <?php require 'alert-notif-function.php'; ?>
  <!--=====Change name mo na lang====-->
  <title>Doc Lenon Veterinary Clinic | Services and Products</title>
  <link rel="icon" type="image/x-icon" href=".vscode\Doc Lenon Logo.png">
</head>

<body>
  <!--=====Navigation Bar====-->
  <?php require 'nav-bar.html.php'; ?>

  <script>
        $("#ser").css("color", "#5a81fa");
        $("#vice").css("color", "#5a81fa");
    </script>

  <!--=====Pinaka taas/ title ganon====-->
  <section class="dashboard">
    <div class="top">
      <i class="sidebar-toggle"><span class="material-symbols-outlined"> menu </span></i>
      <div class="title">
        <span class="text">Clinic Service and Product</span>
        <?php require 'alert-notif.php'; ?>
      </div>
    </div>

    <!---->
    <div class="web-content">
      <div class="ss-menu">
        <div class="bttn">
          <button class="viewAll-button" id="viewAll" onclick="clearRadio(); filterContent('');">View All</button>
          <button class="services-button" id="service" onclick="serviceOnly(); filterContent('Services');">Services Only</button>
          <button class="product-button" id="product" onclick="displayFilter(); filterContent('Products')">Products Only</button>

          <select class="product-dropdown" id="categoryDropdown" onchange="displayDropdownValue()" style="display: none;">
            <option value="Pet Food">Pet Food</option>
            <option value="Bath Products">Bath Products</option>
            <option value="Accessories">Accessories</option>
            <option value="Others">Others</option>
          </select>

          <button class="add-button1" onclick="openAddServProd()">Add New</button>
          <input type="text" id="filterValue" oninput="filterTable()" style="display: none;">

          <input type="text" id="id" style="display: none;">
        </div>
      </div>

      <div class="boxes-overview" id="refresh">
        <!-- product boxes -->
        <?php require 'service-product-fetch-data.php'; ?>
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

        function filterContent(filterCategory) {
          handleFilter(filterCategory);
        }

        function handleFilter(filterCategory) {
          var container = document.getElementById("refresh");
          var boxes = container.querySelectorAll('.box');

          if (!filterCategory) {
            generatePaginationControls();
            showPage(1);
            return;
          }

          boxes.forEach(function(box) {
            var category = box.querySelector('h6').innerText.trim();
            var isVisible = category.toUpperCase().includes(filterCategory.toUpperCase());

            box.style.display = isVisible ? 'block' : 'none';

            category.style.textAlign = 'center';
          });
        }

        generatePaginationControls();
        showPage(1);
      </script>

      <!--Add Data-->
      <div class="form-popup-servprod" id="myForm-servprod">
        <form action="" class="form-container-servprod" method="post" enctype="multipart/form-data">
          <div class="title">
            Upload Service or Product
          </div>

          <div class="form">
            <div class="inputfield-image">
              <img id="preview" src=".vscode/Images/didunkow.jpg" alt="Image Preview" width="600" height="400" style="object-fit: cover;">
              <input type="file" id="addImage" accept="image/*">
            </div>
            <div class="inputfield">
              <label>Title</label>
              <input type="text" class="input" id="addTitle" />
            </div>
            <div class="inputfield">
              <label>Categories</label>
              <div class="custom_select">
                <select id="addCategories">
                  <option value="">SELECT</option>
                  <option value="Services">Services</option>
                  <option value="Pet Foods">Pet Foods</option>
                  <option value="Bath Products">Bath Products</option>
                  <option value="Accessories">Accessories</option>
                  <option value="Others">Others</option>
                </select>
              </div>
            </div>
            <div class="inputfield">
              <label>Description</label>
              <textarea type="text" id="addDescription" class="input" rows="5" cols="110" resize="none" placeholder="Type here..."></textarea>
            </div>

            <div class="inputfield">
              <input type="button" value="Upload" class="btn-send" onclick="submitData('Add');" />
              <?php require 'service-product-data.js.php'; ?>
            </div>
            <input type="button" value="Close" class="btn-cancel" onclick="closeAddServProd()" />
          </div>
        </form>
      </div>

      <!--Edit-->
      <div class="form-popup-servprod" id="myForm-Editservprod">
        <form action="" class="form-container-servprod" method="post" enctype="multipart/form-data">
          <div class="title">
            Upload Service or Product
          </div>

          <div class="form">
            <div class="inputfield-image">
              <img id="editPreview" src=".vscode/Images/didunkow.jpg" alt="Image Preview">
              <input type="file" id="editImage" accept="image/*">
              <input type="text" value="" id="id" style="display: none;" disabled>
            </div>
            <div class="inputfield">
              <label>Title</label>
              <input type="text" class="input" id="editTitle" />
            </div>
            <div class="inputfield">
              <label>Categories</label>
              <div class="custom_select">
                <select id="editCategories">
                  <option value="Services">Services</option>
                  <option value="Pet Foods">Pet Foods</option>
                  <option value="Bath Products">Bath Products</option>
                  <option value="Accessories">Accessories</option>
                  <option value="Others">Others</option>
                </select>
                </select>
              </div>
            </div>
            <div class="inputfield">
              <label>Description</label>
              <textarea type="text" id="editDescription" class="input" rows="5" cols="110" resize="none" placeholder="Type here..."></textarea>
            </div>

            <div class="inputfield">
              <input type="button" value="Upload" class="btn-send" onclick="submitData('Edit');" />
              <?php require 'service-product-data.js.php'; ?>
            </div>
            <input type="button" value="Close" class="btn-cancel" onclick="closeEditServProd()" />
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

    function displayDropdownValue() {
      var selectedValue = document.getElementById('categoryDropdown').value;
      document.getElementById("filterValue").value = selectedValue;
      filterContent(selectedValue);
    }

    function openFormDelete() {
      document.getElementById("myForm-delete").style.display = "block";
    }

    function closeFormDelete() {
      document.getElementById("myForm-delete").style.display = "none";
    }

    function serviceOnly() {
      document.getElementById("filterValue").value = "Services";
      document.getElementById("categoryDropdown").style.display = "none";

      document.getElementById("viewAll").style.backgroundColor = "#f1f1f1";
      document.getElementById("service").style.backgroundColor = "#5782fa";
      document.getElementById("product").style.backgroundColor = "#f1f1f1";

      document.getElementById("viewAll").style.color = "#062b98";
      document.getElementById("service").style.color = "#ffffff";
      document.getElementById("product").style.color = "#062b98";
    }

    function productOnly() {
      document.getElementById("filterValue").value = "Product";
    
    }

    function displayFilter() {
      document.getElementById("filterValue").value = "Product";
      document.getElementById("categoryDropdown").style.display = "block";

      document.getElementById("viewAll").style.backgroundColor = "#f1f1f1";
      document.getElementById("service").style.backgroundColor = "#f1f1f1";
      document.getElementById("product").style.backgroundColor = "#5782fa";

      document.getElementById("viewAll").style.color = "#062b98";
      document.getElementById("service").style.color = "#062b98";
      document.getElementById("product").style.color = "#ffffff";
    }

    function clearRadio() {
      document.getElementById("filterValue").value = "";
      document.getElementById("categoryDropdown").style.display = "none";

      document.getElementById("viewAll").style.backgroundColor = "#5782fa";
      document.getElementById("service").style.backgroundColor = "#f1f1f1";
      document.getElementById("product").style.backgroundColor = "#f1f1f1";

      document.getElementById("viewAll").style.color = "#ffffff";
      document.getElementById("service").style.color = "#062b98";
      document.getElementById("product").style.color = "#062b98";
    }

    function getInfo(imageName, imageSrc, title, categories, description, id) {
      const fileInput = document.getElementById("editImage");
      const blob = dataURItoBlob(imageSrc); // Convert the data URI to a Blob
      const file = new File([blob], imageName); // Create a File with the Blob and filename
      const dataTransfer = new DataTransfer();
      dataTransfer.items.add(file);
      fileInput.files = dataTransfer.files;

      document.getElementById("id").value = id;
      document.getElementById("editPreview").src = imageSrc;
      document.getElementById("editTitle").value = title;
      document.getElementById("editCategories").value = categories;
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

    function openAddServProd() {
      document.getElementById("myForm-servprod").style.display = "block";
    }

    function closeAddServProd() {
      document.getElementById("myForm-servprod").style.display = "none";
    }

    function getRow(rowId) {
      document.getElementById("editTitle").value = rowId;
    }

    function openEditServProd() {
      document.getElementById("myForm-Editservprod").style.display = "block";
    }

    function closeEditServProd() {
      document.getElementById("myForm-Editservprod").style.display = "none";
    }

    function closeFormServProd() {
      document.getElementById("myForm-sms").style.display = "none";
    }

    function openFormFilter() {
      document.getElementById("myForm-filter").style.display = "block";
    }

    function closeFormFilter() {
      document.getElementById("myForm-filter").style.display = "none";
    }
  </script>
</body>

</html>