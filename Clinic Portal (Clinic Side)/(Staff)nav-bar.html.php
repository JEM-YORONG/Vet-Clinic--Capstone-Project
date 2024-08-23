<nav>
    <!-- logo and name -->
    <div class="logo-name" id="toRefresh">
        <div class="logo-image">
            <img src=".vscode\Doc Lenon Logo.png" alt="" />
        </div>
        <span class="logo_name"><label>Doc Lenon Veterinary Clinic</label> | <br />
            Vet Portal</span>
        <?php require 'reload-logo-name.js.php'; ?>
    </div>
    <!--=====Nav Menus====-->
    <div class="menu-items">
        <ul class="nav-links">
            <li>
                <a href="zHTML_dashboard.php">
                    <i><span class="material-symbols-outlined" id="dash">home</span></i>
                    <span class="link-name" id="board">Dashboard</span>
                </a>
            </li>
            <!--=====Clinic Management Menu====-->
            <ul class="clinic-management-link">
                <div class="page-maintenance" id="menu-maintenance">
                    <li>
                        <a href="">
                            <i><span class="material-symbols-outlined" id="page">help_clinic</span></i>
                            <span class="link-name" id="main">Page Maintenance</span>
                        </a>
                    </li>
                    <div class="page-maintenance-content">
                        <li>
                            <a href="Z_ClinicAboutUs.php">
                                <i><span class="material-symbols-outlined" id="about">info</span></i>
                                <span class="link-name" id="us">&nbsp; About Us</span>
                            </a>
                        </li>
                        <li>
                            <a href="Z_ClinicContact.php">
                                <i><span class="material-symbols-outlined" id="con">call</span></i>
                                <span class="link-name" id="tact">&nbsp; Contacts</span>
                            </a>
                        </li>
                        <li>
                            <a href="Z_ClinicPSched.php">
                                <i><span class="material-symbols-outlined" id="sched">schedule</span></i>
                                <span class="link-name" id="dule">&nbsp; Schedule Page</span>
                            </a>
                        </li>
                        <li>
                            <a href="zHTML_announcement.php">
                                <i><span class="material-symbols-outlined" id="ann">campaign</span></i>
                                <span class="link-name" id="ment">Announcement</span>
                            </a>
                        </li>
                        <li>
                            <a href="zHTML_service_product.php">
                                <i><span class="material-symbols-outlined" id="ser">sell</span></i>
                                <span class="link-name" id="vice">Service and Product</span>
                            </a>
                        </li>
                    </div>
                </div>
            </ul>
            <!--=====Record Menus====-->
            <ul class="record-management-link">
                <li>
                    <a href="zHTML_schedule.php">
                        <i><span class="material-symbols-outlined" id="app">event</span></i>
                        <span class="link-name" id="point">Appointment Schedule</span>
                    </a>
                </li>
                <li>
                    <a href="zHTML_customer.php">
                        <i class="uil uil-share" id="cust"><span class="material-symbols-outlined">groups</span></i>
                        <span class="link-name" id="tomer">Customer</span>
                    </a>
                </li>
                <li>
                    <a href="zHTML_pets.php">
                        <i><span class="material-symbols-outlined" id="pe">pets</span></i>
                        <span class="link-name" id="ts">Pets</span>
                    </a>
                </li>
                <li>
                    <a href="zHTML_report_analytics.php">
                        <i><span class="material-symbols-outlined" id="rep">analytics</span></i>
                        <span class="link-name" id="port">Report Analytics</span>
                    </a>
                </li>
                <li>
                    <a href="zHTML_logs.php">
                        <i><span class="material-symbols-outlined" id="act">
                                history_edu
                            </span></i>
                        <span class="link-name" id="logs">Activity Logs</span>
                    </a>
                </li>
                <li>
                    <a href="logout-function.php" style="position: absolute; bottom: 10px;">
                        <i><span class="material-symbols-outlined"> logout </span></i>
                        <span class="link-name">Logout</span>
                    </a>
                </li>
            </ul>
        </ul>
        <!--=====Logout Menu====-->

    </div>
</nav>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>