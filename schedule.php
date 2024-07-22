<?php
include "connection.php";
session_start();
if (isset($_GET['id']) && !empty($_GET['id']) && ctype_digit($_GET["id"])) {
    $id = $_GET["id"];

    $sanitized_id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

    $q = "SELECT * FROM `members` INNER JOIN `profileimg`ON members.profileImg_p_id=profileimg.p_id WHERE `id` =?;";
    $types = "i";

    $rs = Database::searchPrepared($q, $types, $sanitized_id);
    if ($rs->num_rows == 1) {
        $rs_data = $rs->fetch_assoc();
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <!-- Tell the browser to be responsive to screen width -->
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <meta name="robots" content="noindex,nofollow">
            <title>Ample Admin Lite Template by WrapPixel</title>
            <!-- Favicon icon -->
            <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
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
                                <h4 class="page-title">Member Profile</h4>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 col-md-12" id="cardImgTog">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-12 " id="schedules">

                                            <a class="float-end" id="profileBtn" onclick="backToProfile(<?php echo $sanitized_id; ?>);" style="cursor: pointer;"><i class="bi bi-caret-left-fill me-2"></i>Go Back</a>
                                            <h4 class="page-title text-primary mb-3 h3" style="cursor: default;">Schedules</h4>

                                            <input class="d-none" id="getMId1" contenteditable="false" value="<?php echo $sanitized_id; ?>">
                                            <div class="row justify-content-center mt-4 " id="cuS">
                                                <a class="mb-3 float-end text-danger ms-5" style="cursor: pointer; font-size: large;" id="addNewS"><i class="bi bi-folder-plus me-2"></i>Add new schedule</a>

                                                <?php
                                                $page = 0;
                                                if (isset($_GET['p']) && ctype_digit($_GET['p'])) {

                                                    $page = $_GET['p'];
                                                } else {
                                                    $page = 0;
                                                }


                                                $schedule_rs = Database::search("SELECT * FROM `schedule` WHERE `members_id` = '" . $sanitized_id . "' AND `s_id` IN 
                                                (SELECT DISTINCT `s_id` FROM `schedule` WHERE `addedDate` = (SELECT DISTINCT `addedDate` FROM `schedule` WHERE `members_id` = '" . $sanitized_id . "' ORDER BY `addedDate` DESC LIMIT " . $page . ", 1));");

                                                $schedule_num = $schedule_rs->num_rows;

                                                for ($i = 0; $i < $schedule_num; $i++) {
                                                    $schedule_data = $schedule_rs->fetch_assoc();
                                                    $workouts_rs = Database::search("SELECT * FROM `workouts` WHERE `workouts`.`schedule_s_id` = '" . $schedule_data['s_id'] . "';");
                                                    $workouts_rs1 = Database::search("SELECT * FROM `workouts` WHERE `workouts`.`schedule_s_id` = '" . $schedule_data['s_id'] . "';");
                                                    $workouts_num = $workouts_rs->num_rows;

                                                ?>
                                                    <a class="btn btn-info text-light mb-2 col-7 h4 mt-3" id="s1" onclick="showSchedule(<?php echo $i; ?>);"><?php echo $schedule_data['sName']; ?></a>

                                                    <div class="row justify-content-center mt-4 col-10 shadow-lg d-none" id="pS<?php echo $i; ?>">

                                                        <div class="justify-content-center mt-4 col-10" id="print-schedule<?php echo $i; ?>" style="padding: 0.5in;">

                                                            <div class="col-10 mx-auto">

                                                                <div class="row justify-content-center">
                                                                    <img src="plugins/images/users/workoutHeader-02.png" class=" " style="width: 1000px; " alt="">
                                                                </div>

                                                                <table class="table table-borderless table text-dark border border-3 border-dark">
                                                                    <thead>
                                                                        <tr class="border border-3 border-dark">

                                                                            <th scope="col" class="border-start border-start-3 border-dark text-center text-dark" style="font-size: 22px; font-weight: bold;">Workout</th>
                                                                            <th scope="col" class="border-start border-start-3 border-dark text-center text-dark" style="font-size: 22px;">Details</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="border-bottom border-bottom-3 border-dark text-dark">
                                                                        <?php


                                                                        for ($c = 0; $c < $workouts_num; $c++) {
                                                                            $workouts_data1 = $workouts_rs1->fetch_assoc();

                                                                        ?>
                                                                            <tr>
                                                                                <td style="font-size: 20px; font-weight: 700;" class="ps-4 border-start border-start-3 border-end border-end-3 border-dark"><?php echo $workouts_data1['workout'] ?></td>
                                                                                <td style="font-size: 20px; font-weight: 700;" class="ps-4 border-start border-start-3 border-end border-end-3 border-dark"><?php echo $workouts_data1['details'] ?></td>
                                                                            </tr>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>

                                                                <div class="col-12" id="sTableData">

                                                                    <div class=" offset-4 offset-sm-8 offset-lg-9  col-12">
                                                                        <h5 class="" style="font-size: 20px; font-weight: 600;">ID : 00<?php echo $sanitized_id; ?></h5>
                                                                        <h5 class="" style="font-size: 20px; font-weight: 600;">Name : <?php echo $rs_data['m_name']; ?></h5>
                                                                        <h5 class="" style="font-size: 20px; font-weight: 600;">Date of Renewal : <?php echo $schedule_data['dateOfRenewal'] ?></h5>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>
                                                        <div class="row justify-content-center justify-content-md-between my-4 ">
                                                            <button class="btn btn-dark" style="width: 200px;" onclick="printDiv('print-schedule<?php echo $i; ?>');" id="pSchedule<?php echo $i; ?>"><i class="bi bi-printer-fill me-2"></i> Print Schedule</button>
                                                            <button class="btn btn-danger " style="width: 200px;" onclick="deleteSchedule(<?php echo $schedule_data['s_id'] ?>);" id="deleteSchedule<?php echo $i; ?>"><i class="bi bi-trash3 me-2"></i> Delete Schedule</button>

                                                        </div>
                                                    </div>


                                                <?php
                                                }
                                                ?>


                                                <nav aria-label="">
                                                    <ul class="pagination pagination-md justify-content-center mt-4">
                                                        <?php
                                                        $schedulePI_rs = Database::search("SELECT DISTINCT `addedDate` FROM schedule WHERE `members_id`='" . $sanitized_id . "' ORDER BY addedDate DESC;");
                                                        $schedulePI_num = $schedulePI_rs->num_rows;

                                                        for ($x = 0; $x < $schedulePI_num; $x++) {
                                                            if ($x == 0) {
                                                                if ($page == 0) {
                                                        ?>
                                                                    <li class="page-item active"><a class="page-link" href="?id=<?php echo $sanitized_id; ?>&p=0">Current</a></li>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <li class="page-item"><a class="page-link" href="?id=<?php echo $sanitized_id; ?>&p=0">Current</a></li>
                                                                <?php
                                                                }
                                                            } else {

                                                                if ($page == $x) {
                                                                ?>
                                                                    <li class="page-item active"><a class="page-link" href="?id=<?php echo $sanitized_id; ?>&p=<?php echo $x; ?>"><?php echo $x; ?></a></li>

                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <li class="page-item"><a class="page-link" href="?id=<?php echo $sanitized_id; ?>&p=<?php echo $x; ?>"><?php echo $x; ?></a></li>

                                                        <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </nav>
                                            </div>
                                            <!-- add new schedule column  -->
                                            <div class="row justify-content-center mt-4 d-none" id="aNSchedule">

                                                <a class="mb-3 text-danger text-end me-5" style="cursor: pointer; font-size: medium;" id="aNSGoBack"><i class="bi bi-caret-left-fill me-2"></i>Go Back</a>
                                                <h3 class="mb-1 text-center" style="cursor: default;">Workout Schedule</h3>



                                                <div class="my-4 col-10 ">
                                                    <div class=" mb-4 mt-1">
                                                        <label class="col-md-12 p-0 fs-5" for="scheduleName">Schedule Name :</label>
                                                        <div class="col-md-12 border-bottom p-0">
                                                            <input type="text" placeholder="Schedule : 01 " class="col-12 p-0 h5 border-0 ps-3" id="scheduleName">
                                                        </div>
                                                    </div>

                                                    <table class="table table-bordered border-primary" id="addScheduleTable">
                                                        <thead class="">
                                                            <tr class="">
                                                                <th scope="col" class="text-center " style="cursor: pointer;"><i class="bi bi-recycle"></i></th>
                                                                <th scope="col" class="text-center text-dark" style="font-size: large;cursor: default;">Workout</th>
                                                                <th scope="col" class="text-center text-dark" style="font-size: large;cursor: default;">Details</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="" id="addScheduleTbody">
                                                            <tr class="">
                                                                <th scope="row" class="text-center">1</th>
                                                                <td id="w0" contenteditable="true">Cycle</td>
                                                                <td id="d0" contenteditable="true">15 min</td>
                                                            </tr>
                                                            <tr class="">
                                                                <th scope="row" class="text-center">2</th>
                                                                <td contenteditable="true">Treadmill</td>
                                                                <td contenteditable="true">15 min</td>
                                                            </tr>
                                                            <tr class="">
                                                                <th scope="row" class="text-center">3</th>
                                                                <td contenteditable="true">Machine Leg Press</td>
                                                                <td contenteditable="true">15-30 reps 3-5 sets</td>
                                                            </tr>
                                                            <tr class="">
                                                                <th scope="row" class="text-center">4</th>
                                                                <td contenteditable="true">Squats-Stepper</td>
                                                                <td contenteditable="true">12-20 reps 4 sets or 5min</td>
                                                            </tr>
                                                            <tr class="">
                                                                <th scope="row" class="text-center">5</th>
                                                                <td contenteditable="true">Pull Over</td>
                                                                <td contenteditable="true">15-30 reps 3-5 sets</td>
                                                            </tr>
                                                            <tr class="">
                                                                <th scope="row" class="text-center">6</th>
                                                                <td contenteditable="true">Chest Press</td>
                                                                <td contenteditable="true">15-30 reps 3-5 sets</td>
                                                            </tr>
                                                            <tr class="">
                                                                <th scope="row" class="text-center">7</th>
                                                                <td contenteditable="true">(Hammer) Incline Press</td>
                                                                <td contenteditable="true">15-30 reps 3-5 sets</td>
                                                            </tr>
                                                            <tr class="">
                                                                <th scope="row" class="text-center">8</th>
                                                                <td contenteditable="true">(D/B) Front Press</td>
                                                                <td contenteditable="true">15-30 reps 3-5 sets</td>
                                                            </tr>
                                                            <tr class="">
                                                                <th scope="row" class="text-center">9</th>
                                                                <td contenteditable="true">(Machine) Shoulder Press</td>
                                                                <td contenteditable="true">15-30 reps 3-5 sets</td>
                                                            </tr>
                                                            <tr class="">
                                                                <th scope="row" class="text-center">10</th>
                                                                <td contenteditable="true">Cable Pull Down</td>
                                                                <td contenteditable="true">15-30 reps 3-5 sets</td>
                                                            </tr>
                                                            <tr class="">
                                                                <th scope="row" class="text-center">11</th>
                                                                <td contenteditable="true">Lat Pull Down</td>
                                                                <td contenteditable="true">15-30 reps 3-5 sets</td>
                                                            </tr>
                                                            <tr class="">
                                                                <th scope="row" class="text-center">12</th>
                                                                <td contenteditable="true">( ) Curl</td>
                                                                <td contenteditable="true">15-30 reps 3-5 sets</td>
                                                            </tr>
                                                            <tr class="">
                                                                <th scope="row" class="text-center">13</th>
                                                                <td contenteditable="true">Cable Triceps</td>
                                                                <td contenteditable="true">15-30 reps 3-5 sets</td>
                                                            </tr>
                                                            <tr class="">
                                                                <th scope="row" class="text-center">14</th>
                                                                <td contenteditable="true">Abs:Hanging Leg Raise</td>
                                                                <td contenteditable="true">3xMAX</td>
                                                            </tr>
                                                            <tr class="">
                                                                <th scope="row" class="text-center">15</th>
                                                                <td contenteditable="true">Abs:Hanging Leg Raise</td>
                                                                <td contenteditable="true">3xMAX</td>
                                                            </tr>
                                                            <tr class="">
                                                                <th scope="row" class="text-center">16</th>
                                                                <td contenteditable="true">Abs:Hanging Leg Raise</td>
                                                                <td contenteditable="true">3xMAX</td>
                                                            </tr>
                                                        </tbody>

                                                    </table>
                                                    <div class="col-12">
                                                        <div class="offset-4 offset-sm-8 offset-lg-9  col-12">
                                                            <h5 class="">Data Inserted by : <?php echo $user_data['fname']; ?> <?php echo $user_data['lname']; ?></h5>
                                                            <?php
                                                            $d = new DateTime();
                                                            $tz = new DateTimeZone("Asia/Colombo");
                                                            $d->setTimezone($tz);
                                                            $d->modify('+1 month');
                                                            $date = $d->format("Y-m-d");
                                                            ?>
                                                            <h5 class="">Date of Renewal : <b contenteditable="true" id="renewalDate"><?php echo $date; ?></b></h5>
                                                        </div>
                                                    </div>
                                                    <button id="aSCBtn" class="btn btn-primary  text-light"><i class="bi bi-check-square me-2"></i> Confirm</button>

                                                </div>


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