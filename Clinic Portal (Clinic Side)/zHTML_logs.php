<?php
require 'disable-paste.js.php';
require 'staff-data.js.php';
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="Capstone_Staff.css" />
    <link rel="stylesheet" href="Capstone_ClinicAboutUs copy.css">

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

    <?php require 'alert-notif-function.php'; ?>
    <!--=====Change name mo na lang====-->
    <title>Doc Lenon Veterinary Clinic | Staffs</title>
    <link rel="icon" type="image/x-icon" href=".vscode\Doc Lenon Logo.png">

    <?php require 'timezone.php'; ?>
</head>

<body>
    <!--=====Navigation Bar====-->
    <?php require 'nav-bar.html.php'; ?>

    <script>
        $("#act").css("color", "#5a81fa");
        $("#logs").css("color", "#5a81fa");
    </script>

    <!--=====Pinaka taas/ title ganon====-->
    <section class="Contents">
        <div class="top">
            <i class="sidebar-toggle"><span class="material-symbols-outlined"> menu </span></i>
            <div class="title">
                <span class="text">Activity Logs</span>
                <?php require 'alert-notif.php'; ?>
                <input type="text" placeholder="for show" id="forShow" style="display: none;">
            </div>
        </div>

        <div class="web-content">
            <div class="overview">
                <div class="menu">
                    <div class="search-box">
                        <input type="text" id="search" placeholder="Search here..." autocomplete="off" oninput="filterTable()" />
                    </div>
                    <div class="bttn">
                        <?php require 'staff-auto-gen-id.js.php'; ?>
                    </div>
                </div>

                <div class="staff-table" id="refresh">
                    <table width=100% id="staffTable">
                        <thead>
                            <tr>
                                <th scope="col" width=5%>Date</th>
                                <th scope="col" width=5%>Time</th>
                                <th scope="col" width=5%>Role</th>
                                <th scope="col" width=15%>Account</th>
                                <th scope="col" width=20%>Action</th>
                            </tr>
                        </thead>
                        <tbody id="table-body"></tbody>
                        <?php require 'logs-fetch-data.php'; ?>
                    </table>
                </div>
            </div>

            <div id="pagination-container" class="pagination"></div>

            <script>
                var rowsPerPage = 17; // Adjust this to your desired number of rows per page
                var currentPage = 1;

                function showPage(pageNumber) {
                    var startIndex = (pageNumber - 1) * rowsPerPage;
                    var endIndex = startIndex + rowsPerPage;

                    var rows = document.getElementById('staffTable').rows;

                    for (var i = 1; i < rows.length; i++) {
                        rows[i].style.display = (i > startIndex && i <= endIndex) ? '' : 'none';
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
                    var pageCount = Math.ceil((document.getElementById('staffTable').rows.length - 1) / rowsPerPage);

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
                    var pageCount = Math.ceil((document.getElementById('staffTable').rows.length - 1) / rowsPerPage);
                    if (currentPage < pageCount) {
                        showPage(currentPage + 1);
                    }
                }

                function filterTable() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("search");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("staffTable");
                    tr = table.getElementsByTagName("tr");

                    if (filter === "") {
                        showPage(1);
                        return;
                    }

                    for (i = 1; i < tr.length; i++) {
                        var visible = false;
                        for (var j = 0; j < tr[i].cells.length; j++) {
                            td = tr[i].cells[j];
                            if (td) {
                                txtValue = td.textContent || td.innerText;
                                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                    visible = true;
                                    break;
                                }
                            }
                        }
                        tr[i].style.display = visible ? "" : "none";
                    }
                }

                generatePaginationControls();
                showPage(1);
            </script>
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

        function deleteId(rowId, name) {
            document.getElementById("editId").value = rowId;
            document.getElementById("forShow").value = name;
        }

        function getRowID(rowId, rowName, rowRole, rowContact, rowEmail, rowPassword) {
            document.getElementById("editId").value = rowId;
            document.getElementById("editName").value = rowName;
            document.getElementById("editRole").value = rowRole;
            document.getElementById("editContact").value = rowContact;
            document.getElementById("editEmail").value = rowEmail;
            document.getElementById("editPassword").value = rowPassword;

            var role = document.getElementById("editRole");
            var email = document.getElementById("editEmail");
            var password = document.getElementById("editPassword");
            var emailTxt = document.getElementById("editEmailtxt");
            var passTxt = document.getElementById("editPasstxt");

            if (rowRole == "Groomer" || rowRole == "Assistant") {
                email.style.display = "none";
                password.style.display = "none";
                emailTxt.style.display = "none";
                passTxt.style.display = "none";
            } else {
                email.style.display = "block";
                password.style.display = "block";
                emailTxt.style.display = "block";
                passTxt.style.display = "block";
            }
        }

        document.getElementById('editRole').addEventListener('change', function() {
            var selectedValue = this.value;

            var role = document.getElementById("editRole");
            var email = document.getElementById("editEmail");
            var password = document.getElementById("editPassword");
            var emailTxt = document.getElementById("editEmailtxt");
            var passTxt = document.getElementById("editPasstxt");

            if (selectedValue == "Admin" || selectedValue == "Secretary" || selectedValue == "Veterinarian") {
                email.style.display = "block";
                password.style.display = "block";
                emailTxt.style.display = "block";
                passTxt.style.display = "block";

                email.disabled = false;
                email.value = "";
                password.value = "";
            } else {
                email.style.display = "none";
                password.style.display = "none";
                emailTxt.style.display = "none";
                passTxt.style.display = "none";

                email.disabled = true;
                email.value = "--------";
                password.value = "--------";
            }
        });

        function clearForm() {
            document.getElementById("id").value = "";
            document.getElementById("name").value = "";
            document.getElementById("contact").value = "";
            document.getElementById("email").value = "";
            document.getElementById("password").value = "";
        }

        function openForm() {
            document.getElementById("myForm").style.display = "block";
        }

        function closeForm() {
            document.getElementById("myForm").style.display = "none";
        }

        function openFormEdit() {
            document.getElementById("myForm-edit").style.display = "block";
        }

        function closeFormEdit() {
            document.getElementById("myForm-edit").style.display = "none";
        }

        function openFormDelete() {
            document.getElementById("myForm-delete").style.display = "block";
        }

        function closeFormDelete() {
            document.getElementById("myForm-delete").style.display = "none";
        }
    </script>
</body>

</html>