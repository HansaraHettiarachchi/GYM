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
    <title>Country Fitness Gymnasium | Error:404</title>
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
                                <div class="row ">
                                    <div class="mx-auto col-10">
                                        <div class="input-group  mb-3">
                                            <input id="eDesc" type="text" class="border border-1 border-secondary col-12 col-md-6 col-lg-7 p-2" placeholder="Transaction Description" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                            <input id="eCost" type="text" class="border border-1 border-secondary col-6 col-md-3 col-lg-3 p-2" placeholder="Cost" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                            <select class="border border-1 border-secondary rounded-0 col-6 col-md-1" id="tType" name="transaction-type">
                                                <option value="1">Expense</option>
                                                <option value="2">Income</option>
                                            </select>
                                            <button class="col-12 col-md-2 col-lg-1 input-group-text text-light btn btn-primary" id="currentDetailsAdd">+ Add</button>
                                        </div>
                                        <br>
                                        <div class="mx-auto border border-2 rounded-1 col-md-6 col-sm-8 col-12 col-lg-3 p-3 text-center d-none" id="currentExpenseDetails">

                                        </div>
                                    </div>
                                </div>
                                <h3 class="text-center text-danger fw-bold my-4">This Month Transaction Details</h3>
                                <div class="col-12 row">
                                    <div class="col-8 mx-auto">
                                        <div class="table-responsive">
                                            <table class="table table-borderless border border-2 border-dark">
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
                                                    $query = "SELECT * FROM `transactiondetails` WHERE `DAT` LIKE ? ;";
                                                    $type = "s";

                                                    $d = new DateTime();
                                                    $tz = new DateTimeZone("Asia/Colombo");
                                                    $d->setTimezone($tz);
                                                    $m = $d->format('Y-m');
                                                    $m = $m ."%";
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
                                                        $tot = $tot + $rs_data1['Amount'];
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
                                                                    $tot = $tot + $rs_data['cost'];
                                                                } else {
                                                                    $tot = $tot - $rs_data['cost'];
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>

                                                    <?php
                                                    }
                                                    ?>
                                                    <tr class="border border-top-3 border-secondary" style="background-color: rgba(147, 181, 163, 0.65);">
                                                        <td colspan="2" class="h4 text-primary ps-5"><b> Total Profit or Loss :</b></td>
                                                        <td class="h4 text-primary ms-5 fw-bold">Rs. <?php echo $tot; ?>.00</td>
                                                    </tr>
                                                </tbody>

                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <button type="button" class="mx-auto btn btn-success col-12 col-md-3 fw-bold fs-3 text-light" id="transUpdateBtn1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        Update
                                    </button>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Please Confirm Before Update</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                This data can't be edit or remove. Therefore please double check and confirm the data is correct.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" id="transUpdateBtn">Confirm</button>
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