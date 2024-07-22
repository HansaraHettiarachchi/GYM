<?php
include "connection.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="robots" content="noindex,nofollow">
    <title>Country Fitness Gymnasium | Members</title>
    <link rel="icon" type="image/png" sizes="20x20" href="plugins/images/GYMIcon.png">
    <!-- Custom CSS -->
    <link href="plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
    <link rel="stylesheet" href="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css">
    <!-- Custom CSS -->
    <link href="css/style.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">

        <header class="topbar" data-navbarbg="skin5">
            <?php include "userNav.php"; ?>
        </header>

        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <?php include "sideBarNav.php"; ?>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <div class="page-wrapper">
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4 class="page-title fs-6"><span class="fas fa-users mx-2"></span> New Member Registation </h4>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 col-md-12 mx-lg-auto">
                        <div class="card">
                            <div class="card-body">

                                <form class="form-horizontal form-material mx-2">
                                    <div class="form-group mb-4 mt-3">
                                        <label class="col-md-12 p-0">Full Name</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" placeholder="Kasuna Kalhara Withana Gamage" class="form-control p-0 border-0 ps-3" id="nameIn">
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0">NIC Number</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" placeholder="2153xxxxxxxx" class="form-control p-0 border-0 ps-3" id="nic">
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="example-email" class="col-md-12 p-0">Email</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="email" placeholder="johnathan@admin.com(Optional)" class="form-control p-0 border-0 ps-3" name="example-email" id="email">
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0">Mobile Number</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" placeholder="0754896542" class="form-control p-0 border-0 ps-3" id="mobileNum">
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0">Date of birth</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" placeholder="2024-12-05" class="form-control p-0 border-0 ps-3" id="dob">
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0">Address</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" placeholder="Mr. S. David Brown 63, East Drive Lane Colombo - 00600." class="form-control p-0 border-0 ps-3" id="address">
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0">Membership</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <select class="form-select ps-3 no-border" aria-label="Default select example" id="mShipSelection">
                                                <option selected>Select Membership</option>
                                                <?php
                                                $mShip_rs = Database::search("SELECT * FROM `membership`;");
                                                $mShip_num = $mShip_rs->num_rows;

                                                for ($x = 0; $x < $mShip_num; $x++) {
                                                    $mShip_data = $mShip_rs->fetch_assoc();

                                                ?>
                                                    <option value="<?php echo $mShip_data['mS_id']; ?>"><?php echo $mShip_data['mS_name']; ?>: Rs. <?php echo $mShip_data['price']; ?>.00</option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0">Occupation and Place of Employment</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" placeholder="Doctor (Ruhunu Hospital)" class="form-control p-0 border-0 ps-3" id="occupationInput">
                                        </div>
                                    </div>
                                    <div class="form-group mb-4 border-bottom border-bottom-1">
                                        <label class="col-md-12 p-0">Select Gender</label><br>
                                        <div class="form-check-inline ms-4">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="maleCheckBoc" value="male">
                                            <label class="form-check-label mb-4" for="flexRadioDefault1">
                                                Male
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="femaleCheckBoc" value="female">
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                Female
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4 border-bottom border-bottom-1">
                                        <label class="col-md-12 p-0">Coaching Advice</label><br>
                                        <div class="form-check-inline ms-4">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault1" id="yesCA" checked value="yes">
                                            <label class="form-check-label mb-3" for="yesCA">
                                                Yes, I need Coaching Advice.
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault1" id="noCA" value="no">
                                            <label class="form-check-label" for="noCA">
                                                No, I don't need Coaching Advice.
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <a class="col-md-12 p-0" style="cursor: pointer; font-weight: 500;">Terms and Conditions</a>
                                        <div class="form-check mt-2 ms-3">
                                            <input class="form-check-input" type="checkbox" value="agree" id="agreeTrems">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                I carefully read and agree to Trems and Conditions.
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success" id="registerBtn" type="button">Register</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <footer class="footer text-center"> 2024 © Designed & Developed by Hansara Hettiarachchi.</footer>

        </div>

    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/app-style-switcher.js"></script>
    <script src="plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.js"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="plugins/bower_components/chartist/dist/chartist.min.js"></script>
    <script src="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="js/pages/dashboards/dashboard1.js"></script>

    <script src="script.js"></script>
</body>

</html>