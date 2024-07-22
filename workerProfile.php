<?php
include "connection.php";
session_start();
if (isset($_GET['id']) && !empty($_GET['id']) && ctype_digit($_GET["id"])) {
    $id = $_GET["id"];

    $sanitized_id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

    $q = "SELECT * FROM `worker` INNER JOIN `gender` ON `worker`.`gender_g_id` = `gender`.`g_id` 
            INNER JOIN `worker_prof_img` ON `worker`.`worker_prof_img_w_p_img_id` = `worker_prof_img`.`w_p_img_id` WHERE `worker`.`w_id` =?;";

    $types = "i";

    $rs = Database::searchPrepared($q, $types, $sanitized_id);
    if ($rs->num_rows == 1 && $sanitized_id !== "1") {
        $rs_data = $rs->fetch_assoc();

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d ");

?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <!-- Tell the browser to be responsive to screen width -->
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <meta name="robots" content="noindex,nofollow">
            <title>Country Fitness Gymnasium | Staff Profile</title>
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
                        <nav class="sidebar-nav">
                            <ul id="sidebarnav">
                                <!-- User Profile-->
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="manageMembers.php" aria-expanded="false">
                                        <i class="fas fa-user-plus" aria-hidden="true"></i>
                                        <span class="hide-menu">Add New Member</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="memberPayment.php" aria-expanded="false">
                                        <i class="bi bi-credit-card-2-back-fill" aria-hidden="true"></i>
                                        <span class="hide-menu">Member Payments</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="workerExpenses.php" aria-expanded="false">
                                        <i class="bi bi-calendar-day-fill" aria-hidden="true"></i>
                                        <span class="hide-menu">Daily Expenses</span>
                                    </a>
                                </li>
                                <?php
                                if ($user_data['worker_type_w_t_id'] === 1) {
                                ?>
                                    <li class="sidebar-item pt-2">
                                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="dashboard.php" aria-expanded="false">
                                            <i class="far fa-clock" aria-hidden="true"></i>
                                            <span class="hide-menu">Dashboard</span>
                                        </a>
                                    </li>
                                <?php
                                }
                                ?>
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="index.php" aria-expanded="false">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        <span class="hide-menu">Manage Members</span>
                                    </a>
                                </li>

                            </ul>

                        </nav>
                        <!-- End Sidebar navigation -->
                    </div>
                    <!-- End Sidebar scroll-->
                </aside>
                <div class="page-wrapper">
                    <div class="page-breadcrumb bg-white">
                        <div class="row align-items-center">
                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <h4 class="page-title"><i class="bi bi-buildings-fill me-2"></i> Gym Staff Profile</h4>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <!-- Column -->
                            <div class="col-lg-4 col-xlg-3 col-md-12 " id="prifleImgDiv">
                                <div class="white-box">
                                    <div class="user-bg">
                                        <img width="100%" alt="user" src="plugins/images/large/img1.jpg">
                                        <div class="overlay-box">
                                            <div class="user-content" id="profileBgImgDiv">
                                                <a href="javascript:void(0)"><img id="profileImg" src="<?php echo $rs_data['location']; ?>" class="thumb-lg img-circle" style="width: 135px; height: 135px;" alt="img"></a>
                                                <h4 class="text-white mt-3"><?php echo $rs_data['fname']; ?> <?php echo $rs_data['lname']; ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="user-btm-box mt-5 d-md-flex">
                                        <div class="col-12 text-center">
                                            <h1 class="h1" id="getWid">00<?php echo $rs_data['w_id']; ?></h1>
                                        </div>

                                    </div>
                                </div>
                                <div class="row mx-2 mb-3">
                                    <?php
                                    if ($user_data['worker_type_w_t_id'] !== 1) {
                                    ?>
                                        <button type="button" class="btn btn-outline-success " id="advanceR" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="bi bi-alipay me-2"></i></i>Request For Advance</button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered p-2 shadow">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5 fw-bold text-primary" id="staticBackdropLabel">Request For Advance (Rs. )</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-3 border border-3">
                                                        <input type="text" id="wAdvanceAmount" placeholder="Enter Amount" class="col-12 col-md-6 offset-0 offset-md-3 ps-2" style="height: 35px;"></input>
                                                        <div class="spinner-border text-info border-5 mx-auto m-3 d-none" id="adRSpinner" style="width: 40px; height: 40px;" role="status">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn " data-bs-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-warning" id="rAdvance">Confirm</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="d-none">
                                    <input type="file" id="updateProfileImg" accept="image/png, image/jpg, image/jpeg">
                                </div>
                            </div>

                            <div class="col-lg-8 col-xlg-9 col-md-12" id="cardImgTog">
                                <div class="card">
                                    <div class="card-body">

                                        <div id="profileDetails" class="carousel carousel-dark slide" data-interval="false" data-keyboard="false">
                                            <div class="carousel-indicators" style="margin-top: 10px;">
                                                <button type="button" data-bs-target="#profileDetails" data-bs-slide-to="0" class="active me-2" aria-label="Slide 1" style="width: 30px; background-color: black;" id="formBtn"></button>
                                                <button type="button" data-bs-target="#profileDetails" data-bs-slide-to="1" aria-label="Slide 2" style="width: 30px; height: 6px; background-color: black;" id="tableBtn"></button>
                                            </div>
                                            <div class="carousel-inner mb-3 ">
                                                <div class="carousel-item active" data-bs-interval="10000">

                                                    <form class="form-horizontal form-material ">
                                                        <div class="form-group mb-4 mt-3">
                                                            <label class="col-md-12 p-0">Name</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" disabled placeholder="Kasuna Kalhara Withana Gamage" class="form-control p-0 border-0 ps-3" id="nameIn" value="<?php echo $rs_data['fname']; ?> <?php echo $rs_data['lname']; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0"> NIC Number</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" disabled placeholder="2153xxxxxxxx" class="form-control p-0 border-0 ps-3" id="wnic" value="<?php echo $rs_data['nic']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0">Email</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="email" placeholder="johnathan@admin.com(Optional)" class="form-control p-0 border-0 ps-3" name="example-email" id="wEmail" value="<?php echo $rs_data['email']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Mobile Number</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" class="form-control p-0 border-0 ps-3" id="wMobileNum" value="<?php echo $rs_data['m_number']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Joined Date</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" disabled class="form-control p-0 border-0 ps-3" id="dob" value="<?php echo $rs_data['joined_date']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Address</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" class="form-control p-0 border-0 ps-3" id="wAddress" value="<?php echo $rs_data['address']; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Salary (Rs. )</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" <?php
                                                                                    if ($user_data['worker_type_w_t_id'] !== 1) {
                                                                                    ?> disabled <?php
                                                                                            }
                                                                                                ?> class="disabled form-control p-0 border-0 ps-3" id="wSalary" value="<?php echo $rs_data['salary']; ?>">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="carousel-item" data-bs-interval="20000">

                                                    <div class="form-group mb-4">
                                                        <label class="col-md-12 p-0">Gender</label>
                                                        <div class="col-md-12 border-bottom p-0">
                                                            <input type="text" class="form-control p-0 border-0 ps-3" readonly id="pGender" value="<?php echo $rs_data['gender']; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <h4 class="text-center text-primary ">Salary Payment History</h4>

                                                        <table class="table table-borderless border border-2 border-dark">
                                                            <thead style="background-color: rgba(207, 207, 207, 0.64);">
                                                                <tr class="border border-2 border-dark">
                                                                    <th scope="col" class="border-end border-end-1 border-dark">Date</th>
                                                                    <th scope="col" class="border-end border-end-1 border-dark">Description</th>
                                                                    <th scope="col">Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $nic = $rs_data['nic'];
                                                                $rs_q = Database::search("SELECT * FROM `transactiondetails` WHERE `desc` LIKE '%$nic%' ORDER BY `DAT` DESC; ");
                                                                $rs_q_num = $rs_q->num_rows;

                                                                for ($y = 0; $y < $rs_q_num; $y++) {
                                                                    $rs_q_data = $rs_q->fetch_assoc();

                                                                ?>
                                                                    <tr>
                                                                        <th scope="row" class="border-end border-end-1 border-dark"><?php echo $rs_q_data['DAT']; ?></th>
                                                                        <td class="border-end border-end-1 border-dark"><?php echo $rs_q_data['desc']; ?></td>
                                                                        <td class="border-end border-end-1 border-dark text-end">Rs. <?php echo $rs_q_data['cost']; ?>.00</td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>

                                                        </table>
                                                    </div>
                                                    <?php
                                                    if ($user_data['worker_type_w_t_id'] === 1) {
                                                    ?>
                                                        <div class="p-3 mb-3 d-flex justify-content-end">
                                                            <?php
                                                            if ($rs_data['status_id'] === 2) {
                                                            ?>
                                                                <button class="btn btn-primary text-light" style="margin-right: 10px;" id="disableWorker"><i class="bi bi-slash-circle me-2"></i>Enable</button>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <button class="btn btn-danger text-light" style="margin-right: 10px;" id="disableWorker"><i class="bi bi-slash-circle me-2"></i>Disable</button>
                                                            <?php
                                                            }
                                                            ?>
                                                            <!-- <button class="btn btn-danger text-light" id="dropUserBtn">Drop Worker<i class="bi bi-trash3-fill ms-2"></i></button> -->
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>


                                            </div>

                                        </div>
                                        <div class="form-group mb-4">
                                            <div class="col-sm-12">
                                                <button class="btn btn-success text-white" id="wUpdateProfileBtn">Update Profile</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>

                    </div>

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
<?php
    } else {
        header("Location:404.php");
    }
} else {
    header("Location:index.php");
}

?>