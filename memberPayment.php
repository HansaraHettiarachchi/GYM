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
    <title>Country Fitness Gymnasium | Member Payemnt</title>
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
                        <h4 class="page-title fs-6"><span class="bi bi-credit-card-2-back-fill mx-2"></span> Member Payment </h4>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class=" col-12 mx-lg-auto">
                        <div class="card">
                            <div class="card-body">
                                <div class="">
                                    <div class="shadow col-12 col-md-10 row mx-auto">
                                        <div class="col-12 col-sm-6 mx-auto my-4 border border-2 p-1 p-sm-3">

                                            <div class="input-group  p-3 p-sm-0">
                                                <input type="text" class="form-control" id="paymentIdCheck" placeholder="Enter Id...">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" id="paymentIdCheckBtn"><span class="spinner-border spinner-border-sm me-2 d-none" id="btnCheckLoading"></span>Check</button>
                                                </div>
                                            </div>

                                            <div class="mt-3 p-3 d-none" id="payMemberDetails">
                                                <div class="row justify-content-between ">
                                                    <div class="col-sm">
                                                        <h4 id>ID </h4>
                                                    </div>
                                                    <div class="col-sm ">
                                                        <h4 id="payMemId"></h4>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <div class="col">
                                                        <h4>Name </h4>
                                                    </div>
                                                    <div class="col">
                                                        <h4 id="payMemName"></h4>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <div class="col">
                                                        <h4>Membership </h4>
                                                    </div>
                                                    <div class="col">
                                                        <h4 id="payMembership"></h4>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <div class="col">
                                                        <h4>Next Payment Date </h4>
                                                    </div>
                                                    <div class="col">
                                                        <h4 id="payMemNPD"></h4>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <div class="col">
                                                        <h4>Payment Amount </h4>
                                                    </div>
                                                    <div class="col">
                                                        <h4 id="payMemPayAmout"></h4>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center mt-3">
                                                    <div class="text-center">
                                                        <a id="checkpaymentHistoryBtn" class="fs-4 text-info fw-bold" style="cursor: pointer;"><i class="bi bi-clock-history me-2"></i>Payment History </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        if (isset($_GET['id'])) {
                                            $cid = $_GET['id'];

                                            if (empty($cid)) {
                                                header("Location: memberPayment.php");
                                                exit;
                                            } elseif (!ctype_digit($cid)) {
                                                header("Location: memberPayment.php");
                                                exit;
                                            } else {
                                                $id = htmlspecialchars($cid, ENT_QUOTES, 'UTF-8');

                                                $q = "SELECT * FROM `memberpaymenthistory` WHERE `members_id` = ? ORDER BY `pay_h_id` DESC;";
                                                $types = "i";
                                                $rs = Database::searchPrepared($q, $types, $id);
                                                $rs_num = $rs->num_rows;


                                        ?>
                                                <div class="row mx-auto col-10 ">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col"></th>
                                                                <th scope="col">Due Date</th>
                                                                <th scope="col">Paid Date</th>
                                                                <th scope="col">Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            for ($i = 0; $i < $rs_num; $i++) {
                                                                $rs_data = $rs->fetch_assoc();
                                                            ?>
                                                                <tr>
                                                                    <th scope="row"><?php echo $i + 1; ?></th>
                                                                    <td><?php echo $rs_data['DAT']; ?></td>
                                                                    <td><?php echo $rs_data['paidDate']; ?></td>
                                                                    <td>Rs. <?php echo $rs_data['Amount']; ?>.00</td>
                                                                </tr>
                                                    <?php
                                                            }
                                                        }
                                                    } 
                                                    ?>

                                                        </tbody>
                                                    </table>
                                                    <div class="col-12 row justify-content-center">
                                                        <button type="button" id="confirmPaymentBtn" class="btn btn-warning fs-4 text-light my-4 d-none" style="width: 400px;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                            Confirm the Member Payment
                                                        </button>

                                                    </div>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Please Enter Your 6-digit Pin to Confirm the Payment</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body p-3 border border-3">
                                                                    <Input type="text" id="payComfirmPassW" placeholder="6 - Digit Pin" class="col-12 col-md-6 offset-0 offset-md-3 ps-2" style="height: 35px;"></Input>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn btn-primary" id="paymentConBtn">Confirm</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                    </div>
                                </div>

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