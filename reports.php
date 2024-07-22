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
    <title>Country Fitness Gymnasium | Reports</title>
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
                        <h4 class="page-title fs-6"><span class="fas fa-users mx-2"></span> Monthly Transaction Details. </h4>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class=" col-12 mx-lg-auto">
                        <div class="card">
                            <div class="card-body">

                                <h3 class="text-center text-danger fw-bold my-4">Transaction Details (Categorised According to Month)</h3>

                                <div class="col-12 row">
                                    <div class="col-9 mx-auto">
                                        <?php

                                        $dates = [];
                                        $q = Database::search("SELECT * FROM `transactiondetails`;");
                                        $q_num = $q->num_rows;

                                        for ($i = 0; $i < $q_num; $i++) {
                                            $rs_data = $q->fetch_assoc();
                                            $dates[$i] = $rs_data['DAT'];
                                        }
                                        rsort($dates);
                                        $uniqueMonths = [];
                                        $e = 0;
                                        foreach ($dates as $i => $date) {
                                            $timestamp = strtotime($date);
                                            $monthYear = date('Y F', $timestamp);

                                            // echo ($e);
                                            if (!in_array($monthYear, $uniqueMonths)) {
                                                $uniqueMonths[$e] = $monthYear;
                                        ?>
                                                <button class="offset-2 btn btn-primary fw-bold fs-6 col-8 mb-3" onclick="showTDT('tableData<?php echo $i; ?>');"><?php echo $monthYear; ?></button>
                                                <div class="d-none" id="tableData<?php echo $i; ?>">
                                                    <div class="col-12 shadow-lg p-5">
                                                        <div class="table-responsive " id="printRepeort<?php echo $i; ?>">

                                                            <img src="plugins/images/GYMReportHeader.png" style="width: 600px;" class="mx-auto d-block mb-2" alt="">

                                                            <h4 class="text-center h3 text-dark fw-bold my-3"><?php echo $monthYear; ?></h4>

                                                            <table class="table table-borderless border border-2 border-dark repotTable">
                                                                <thead style="background-color: rgba(207, 207, 207, 0.64);">
                                                                    <tr class="border border-2 border-dark">
                                                                        <th scope="col" class="border-end border-end-1 border-dark">Date</th>
                                                                        <th scope="col" class="border-end border-end-1 border-dark">Description</th>
                                                                        <th scope="col">Income/Expense (Rs. )</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $tot = 0;
                                                                    $memPTot = 0;
                                                                    $incomeTot = 0;
                                                                    $expencesTot = 0;
                                                                    $query = "SELECT * FROM `transactiondetails` WHERE `DAT` LIKE ? ;";
                                                                    $type = "s";

                                                                    $d = new DateTime($date);
                                                                    $tz = new DateTimeZone("Asia/Colombo");
                                                                    $d->setTimezone($tz);
                                                                    $m = $d->format('Y-m');
                                                                    $m = $m . "%";
                                                                    $query1 = "SELECT * FROM `memberpaymenthistory` 
                                                                                INNER JOIN `members` ON `memberpaymenthistory`.`members_id` = `members`.`id` 
                                                                                INNER JOIN `membership` ON `members`.membership_m_id = `membership`.mS_id WHERE  `paidDate` LIKE ? ;";
                                                                    $type1 = "s";

                                                                    $rs1 = Database::searchPrepared($query1, $type1, $m);
                                                                    $rs_num1 = $rs1->num_rows;

                                                                    for ($x = 0; $x < $rs_num1; $x++) {
                                                                        $rs_data1 = $rs1->fetch_assoc();
                                                                        $d1 = new DateTime($rs_data1['paidDate']);
                                                                        $date1 = $d1->format('Y-m-d');
                                                                        $memPTot = $memPTot + $rs_data1['Amount'];
                                                                    ?>
                                                                        <tr>
                                                                            <th scope="row" class="border-end border-end-1 border-dark"><?php echo $date1 ?></th>
                                                                            <td class="border-end border-end-1 border-dark">[00<?php echo $rs_data1['id']; ?>] <?php echo $rs_data1['mS_name']; ?> </td>
                                                                            <td class="border-end border-end-1 border-dark text-end"><?php echo $rs_data1['Amount']; ?>.00 CR</td>
                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <tr class="border border-secondary border-end-3"></tr>
                                                                    <?php
                                                                    $rs = Database::searchPrepared($query, $type, $m);
                                                                    $rs_num = $rs->num_rows;

                                                                    for ($x = 0; $x < $rs_num; $x++) {
                                                                        $rs_data = $rs->fetch_assoc();

                                                                    ?>
                                                                        <tr>
                                                                            <th scope="row" class="border-end border-end-1 border-dark"><?php echo $rs_data['DAT']; ?></th>
                                                                            <td class="border-end border-end-1 border-dark"><?php echo $rs_data['desc']; ?> </td>
                                                                            <td class="border-end border-end-1 border-dark text-end"><?php echo $rs_data['cost']; ?>.00
                                                                                <?php
                                                                                if ($rs_data["paymentType_pay_type_id"] == 2) {
                                                                                    echo "CR";
                                                                                    $incomeTot = $incomeTot + $rs_data['cost'];
                                                                                } else {
                                                                                    $expencesTot = $expencesTot - $rs_data['cost'];
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                        </tr>

                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </tbody>

                                                            </table>

                                                            <div class="col-12 row justify-content-end mb-2">

                                                                <div class="col-6">
                                                                    <div class="row justify-content-between ">
                                                                        <div class="col">
                                                                            <h4>Member Payment Total</h4>
                                                                        </div>
                                                                        <div class="" style="width: 150px;">
                                                                            <h4>: Rs. <?php echo $memPTot; ?>.00</h4>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row justify-content-between ">
                                                                        <div class="col">
                                                                            <h4>Total Income</h4>
                                                                        </div>
                                                                        <div class="" style="width: 150px;">
                                                                            <h4>: Rs.
                                                                                <?php
                                                                                $incomeTot = $incomeTot + $memPTot;
                                                                                echo $incomeTot;
                                                                                ?>
                                                                                .00</h4>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row justify-content-between ">
                                                                        <div class="col">
                                                                            <h4>Total Expenses</h4>
                                                                        </div>
                                                                        <div class="" style="width: 150px;">
                                                                            <h4>: Rs. <?php echo -$expencesTot; ?>.00</h4>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row justify-content-between mt-2">
                                                                        <div class="col">
                                                                            <h3 class="fw-bolder" style="font-size: 20px;">This Month
                                                                                <?php
                                                                                $tot = $incomeTot + $expencesTot;
                                                                                if ($tot >= 0) {
                                                                                    echo "Profit";
                                                                                } else {
                                                                                    echo "Loss";
                                                                                    $tot = -$tot;
                                                                                }

                                                                                ?>
                                                                            </h3>
                                                                        </div>
                                                                        <div class="" style="width: 170px;">
                                                                            <h3 class="fw-bolder" style="font-size: 20px;">: Rs.
                                                                                <?php
                                                                                echo $tot;
                                                                                ?>
                                                                                .00
                                                                            </h3>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <p class="text-start">[Genarated Date :
                                                                    <?php
                                                                    $gDAT = new DateTime();
                                                                    $gDAT_tz = new DateTimeZone("Asia/Colombo");
                                                                    $gDAT->setTimezone($gDAT_tz);
                                                                    $gDateAT = $gDAT->format("Y-m-d H:i:s");
                                                                    echo $gDateAT;
                                                                    ?>
                                                                    ]</p>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-outline-success col-2 ms-3 fs-3 mb-4 float-end" onclick="printDiv('printRepeort<?php echo $i; ?>');">Print</button>
                                                    </div>
                                                </div>
                                        <?php
                                                $e++;
                                            }
                                        }
                                        ?>


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