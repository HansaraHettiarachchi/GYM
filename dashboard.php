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
    <title>Country Fitness Gymnasium | Dashboard</title>
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
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Dashboard</h4>
                    </div>

                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Three charts -->
                <!-- ============================================================== -->
                <div class="row justify-content-center">
                    <?php
                    $rs3 = Database::search("SELECT * FROM `members`; ");
                    $rs_num3 = $rs3->num_rows;
                    ?>
                    <div class="col-lg-4 col-md-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">Total Members</h3>
                            <ul class="list-inline two-part d-flex align-items-center mb-0">
                                <li>
                                    <div id="sparklinedash"><canvas width="67" height="30" style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                                    </div>
                                </li>
                                <li class="ms-auto"><span class="counter text-success"><?php echo $rs_num3; ?></span></li>
                            </ul>
                        </div>
                    </div>

                    <?php

                    $rs = Database::search("SELECT * FROM `members` INNER JOIN `membership` ON `members`.membership_m_id = `membership`.mS_id;");
                    $rs_num = $rs->num_rows;
                    $aboutToEx = 0;
                    for ($i = 0; $i < $rs_num; $i++) {

                        $rs_data = $rs->fetch_assoc();
                        $rs1 = Database::search("SELECT * FROM `memberpaymenthistory` WHERE `members_id` = '" . $rs_data['id'] . "' ORDER BY `DAT` DESC LIMIT 1;  ");
                        $rs_num1 = $rs1->num_rows;

                        if ($rs_num1 == 1 && $rs_data['status_id'] == 1) {
                            $rs_data1 = $rs1->fetch_assoc();
                            $date = $rs_data1['DAT'];

                            if ($rs_data['membership_m_id'] === '1' || $rs_data['membership_m_id'] === '4' || $rs_data['membership_m_id'] === "10" || $rs_data['membership_m_id'] === "9") {
                                $nPaymentD = date('Y-m-d', strtotime($date . "+1 months +6 days"));
                                $dueDate = date('Y-m-d', strtotime($date . "+1 months "));
                            } elseif ($rs_data['membership_m_id'] === "2" || $rs_data['membership_m_id'] === "5") {
                                $nPaymentD = date('Y-m-d', strtotime($date . "+6 months +6 days"));
                                $dueDate = date('Y-m-d', strtotime($date . "+6 months"));
                            } elseif ($rs_data['membership_m_id'] === "3" || $rs_data['membership_m_id'] === "6") {
                                $nPaymentD = date('Y-m-d', strtotime($date . "+12 months +6 days"));
                                $dueDate = date('Y-m-d', strtotime($date . "+12 months"));
                            } elseif ($rs_data['membership_m_id'] === "7" || $rs_data['membership_m_id'] === "8") {
                                $nPaymentD = date('Y-m-d', strtotime($date . "+4 months +6 days"));
                                $dueDate = date('Y-m-d', strtotime($date . "+4 months"));
                            }

                            $d13 = new DateTime();
                            $tz13 = new DateTimeZone('Asia/Colombo');
                            $d13->setTimezone($tz13);
                            $cDate = $d13->format('Y-m-d');

                            if ($cDate >= $dueDate && $cDate <= $nPaymentD) {
                                $aboutToEx++;
                            }
                        }
                    }
                    ?>

                    <div class="col-lg-4 col-md-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">About to Disable</h3>
                            <ul class="list-inline two-part d-flex align-items-center mb-0">
                                <li>
                                    <div id="sparklinedash2"><canvas width="67" height="30" style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                                    </div>
                                </li>
                                <li class="ms-auto"><span class="counter text-purple"><?php echo $aboutToEx; ?></span></li>
                            </ul>
                        </div>
                    </div>

                    <?php
                    $rs4 = Database::search("SELECT * FROM `members` WHERE `status_id` ='2'; ");
                    $rs_num4 = $rs4->num_rows;
                    ?>
                    <div class="col-lg-4 col-md-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">Disabled Members</h3>
                            <ul class="list-inline two-part d-flex align-items-center mb-0">
                                <li>
                                    <div id="sparklinedash3"><canvas width="67" height="30" style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                                    </div>
                                </li>
                                <li class="ms-auto"><span class="counter text-info"><?php echo $rs_num4; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="white-box">
                            <div class="d-md-flex mb-3">
                                <h3 class="box-title mb-0">Members Who Has Payment.</h3>
                                <!-- <div class="col-md-3 col-sm-4 col-xs-6 ms-auto">
                                    <select class="form-select shadow-none row border-top">
                                        <option>March 2021</option>
                                        <option>April 2021</option>
                                        <option>May 2021</option>
                                        <option>June 2021</option>
                                        <option>July 2021</option>
                                    </select>
                                </div> -->
                            </div>
                            <div class="table-responsive">
                                <table class="table no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0"></th>
                                            <th class="border-top-0">Name</th>
                                            <th class="border-top-0">Membership</th>
                                            <th class="border-top-0">Due Date</th>
                                            <th class="border-top-0">Expires On</th>
                                            <th class="border-top-0">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $rs = Database::search("SELECT * FROM `members` INNER JOIN `membership` ON `members`.membership_m_id = `membership`.mS_id;");
                                        $rs_num = $rs->num_rows;
                                        $count = 0;

                                        for ($x = 0; $x < $rs_num; $x++) {

                                            $rs_data = $rs->fetch_assoc();
                                            $rs1 = Database::search("SELECT * FROM `memberpaymenthistory` WHERE `members_id` = '" . $rs_data['id'] . "' ORDER BY `DAT` DESC LIMIT 1;  ");
                                            $rs_num1 = $rs1->num_rows;

                                            if ($rs_num1 == 1 && $rs_data['status_id'] == 1) {
                                                $rs_data1 = $rs1->fetch_assoc();
                                                $date = $rs_data1['DAT'];

                                                if ($rs_data['membership_m_id'] === '1' || $rs_data['membership_m_id'] === '4' || $rs_data['membership_m_id'] === "10" || $rs_data['membership_m_id'] === "9") {
                                                    $nPaymentD = date('Y-m-d', strtotime($date . "+1 months +6 days"));
                                                    $dueDate = date('Y-m-d', strtotime($date . "+1 months "));
                                                } elseif ($rs_data['membership_m_id'] === "2" || $rs_data['membership_m_id'] === "5") {
                                                    $nPaymentD = date('Y-m-d', strtotime($date . "+6 months +6 days"));
                                                    $dueDate = date('Y-m-d', strtotime($date . "+6 months"));
                                                } elseif ($rs_data['membership_m_id'] === "3" || $rs_data['membership_m_id'] === "6") {
                                                    $nPaymentD = date('Y-m-d', strtotime($date . "+12 months +6 days"));
                                                    $dueDate = date('Y-m-d', strtotime($date . "+12 months"));
                                                } elseif ($rs_data['membership_m_id'] === "7" || $rs_data['membership_m_id'] === "8") {
                                                    $nPaymentD = date('Y-m-d', strtotime($date . "+4 months +6 days"));
                                                    $dueDate = date('Y-m-d', strtotime($date . "+4 months"));
                                                }

                                                $d13 = new DateTime('2024-07-21');
                                                $tz13 = new DateTimeZone('Asia/Colombo');
                                                $d13->setTimezone($tz13);
                                                $cDate = $d13->format('Y-m-d');

                                                if ($cDate >= $dueDate && $cDate <= $nPaymentD) {
                                                    $count++;
                                        ?>
                                                    <tr>
                                                        <td><?php echo $count; ?></td>
                                                        <td class="txt-oflo"><?php echo $rs_data['m_name']; ?></td>
                                                        <td><?php echo $rs_data['mS_name']; ?></td>
                                                        <td class="txt-oflo"><?php echo date('F \'d, Y', strtotime($dueDate)); ?></td>
                                                        <td class="txt-oflo"><?php echo date('F \'d, Y', strtotime($nPaymentD)); ?></td>
                                                        <td><span class="text-success">Rs. <?php echo $rs_data['price']; ?>.00</span></td>
                                                    </tr>
                                        <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
                <?php
                if ($user_data['worker_type_w_t_id'] === 1) {
                    $rs = Database::search("SELECT * FROM `disabledmrecode`;");
                    $rs_num = $rs->num_rows;
                    $count = 0;

                    if ($rs_num > 0) {
                ?>
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12">
                                <div class="white-box">
                                    <div class="d-md-flex mb-3">
                                        <h3 class="box-title mb-0">Members Who Has Disabled.</h3>

                                    </div>
                                    <div class="table-responsive col-12 col-md-8 mx-auto mb-3">
                                        <table class="table no-wrap">
                                            <thead>
                                                <tr>
                                                    <th class="border-top-0"></th>
                                                    <th class="border-top-0">Member Name</th>
                                                    <th class="border-top-0">Member id</th>
                                                    <th class="border-top-0">Disabled Date and Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                for ($x = 0; $x < $rs_num; $x++) {
                                                    $rs_data = $rs->fetch_assoc();

                                                ?>
                                                    <tr>
                                                        <td><?php echo $rs_data['dMR_id']; ?></td>
                                                        <td class="txt-oflo"><?php echo $rs_data['dMR_m_name']; ?></td>
                                                        <td><?php echo $rs_data['dMR_m_id']; ?></td>
                                                        <td class="txt-oflo"><?php echo $rs_data['d_date']; ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="row justify-content-center">
                                        <button class="btn btn-success text-light" style="font-weight: 500; width: 200px;">All Check and Disabled <i class="bi bi-check-circle-fill ms-2"></i></button>

                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                    <!-- ============================================================== -->
                    <!-- Recent Comments -->

                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-12" style="cursor: pointer;">
                            <div class="white-box analytics-info text-center" onclick="expensesH3();">
                                <h3 class="box-title">Expenses</h3>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12" style="cursor: pointer;">
                            <div class="white-box analytics-info text-center" onclick="workList();">
                                <h3 class="box-title">Workers</h3>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12" style="cursor: pointer;">
                            <div class="white-box analytics-info text-center" onclick="reportsH3();">
                                <h3 class="box-title">Reports</h3>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================================== -->

            </div>
        <?php
                }
        ?>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->

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