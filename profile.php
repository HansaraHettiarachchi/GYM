<?php
include "connection.php";
session_start();
if (isset($_GET['id']) && !empty($_GET['id']) && ctype_digit($_GET["id"])) {
    $id = $_GET["id"];

    $sanitized_id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

    $q = "SELECT * FROM `members` INNER JOIN `gender` ON `members`.`gender_id` = `gender`.`g_id` 
INNER JOIN `profileimg` ON `members`.`profileImg_p_id` = `profileimg`.`p_id` 
INNER JOIN `coachingadvice` ON  `coachingadvice`.`cA_id` = `members`.`coachingAdvice_id` 
INNER JOIN `membership` ON `members`.membership_m_id = `membership`.mS_id WHERE `members`.`id` =?;";

    $types = "i";

    $rs = Database::searchPrepared($q, $types, $sanitized_id);
    if ($rs->num_rows == 1) {
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
            <title>Country Fitness Gymnasium | Profile</title>
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
                                <h4 class="page-title">Member Profile</h4>
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
                                                <a href="javascript:void(0)"><img id="profileImg" src="<?php echo $rs_data['profileImgLocation']; ?>" class="thumb-lg img-circle" style="width: 135px; height: 135px;" alt="img"></a>
                                                <h4 class="text-white mt-3"><?php echo $rs_data['m_name']; ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="user-btm-box mt-5 d-md-flex">
                                        <div class="col-12 text-center">
                                            <h1 class="h1" id="getMId">00<?php echo $rs_data['id']; ?></h1>
                                        </div>

                                    </div>
                                </div>
                                <div class="row mx-2 mb-3">
                                    <button class="btn btn-outline-success " id="schedulesBtn" onclick="goToSchedule(<?php echo $sanitized_id; ?>);"><i class="bi bi-clipboard2-data-fill me-2"></i>Schedules</button>
                                </div>
                                <div class="d-none">

                                    <input type="file" id="updateProfileImg" accept="image/png, image/jpg, image/jpeg">
                                </div>
                            </div>
                            <!-- Column -->

                            <div class="col-lg-8 col-xlg-9 col-md-12" id="cardImgTog">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="container row d-none" style="padding: 0.75in;" id="print-div">
                                            <img src="plugins/images/users/printingHeader.png" class="mx-auto mt-2" style="width: 800px;" alt="">

                                            <h2 class="h4 ">MEMBER ID : <B>00<?php echo $rs_data['id']; ?></B></h2>

                                            <table class=" table-sm table-borderless col-10 offset-1">
                                                <thead>
                                                    <tr>
                                                        <th scope="col"></th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" style="width: 40px;">1</th>
                                                        <td>Full Name : </td>
                                                        <td><?php echo $rs_data['m_name']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="width: 40px;">2</th>
                                                        <td>Address :</td>
                                                        <td><?php echo $rs_data['address']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="width: 40px;">3</th>
                                                        <td>Gender :</td>
                                                        <td><?php echo $rs_data['gender']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="width: 40px;">4</th>
                                                        <td>NIC :</td>
                                                        <td><?php echo $rs_data['nic']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="width: 40px;">5</th>
                                                        <td>E-mail : </td>
                                                        <td><?php echo $rs_data['email']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="width: 40px;">6</th>
                                                        <td>Occupation and Place of Employment :</td>
                                                        <td><?php echo $rs_data['occupation']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="width: 40px;">7</th>
                                                        <td>Date of Birth : </td>
                                                        <td><?php echo $rs_data['dob']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="width: 40px;">8</th>
                                                        <td>Mobile Number : </td>
                                                        <td><?php echo $rs_data['m_number']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="width: 40px;">9</th>
                                                        <td>Coaching Advise : </td>
                                                        <td><?php echo $rs_data['Advice_type']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="width: 40px;">10</th>
                                                        <td>Membership : </td>
                                                        <td><?php echo $rs_data['m_name']; ?>: Rs. <?php echo $rs_data['price']; ?>.00</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="width: 40px;">11</th>
                                                        <td>Personal Goal : </td>
                                                        <td><?php echo $rs_data['pGoal']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="width: 40px;">12</th>
                                                        <td>Physical Condition or any other Remarks : </td>
                                                        <td><?php echo $rs_data['remarks']; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <h5 class="mt-4 col-12 ">I hrerby Declare that the information Given is in this application Ture and correct to the best of my knowledge and belief.</h5>

                                            <div class="row justify-content-between p-4">
                                                <h5 class="mt-3 text-start col">
                                                    <?php
                                                    echo $rs_data['joined_date'];
                                                    ?> <br>
                                                    Date
                                                </h5>
                                                <h5 class="mt-3 text-end col">
                                                    ....................<br>
                                                    Signature
                                                </h5>
                                            </div>
                                        </div>

                                        <div id="profileDetails" class="carousel carousel-dark slide" data-interval="false" data-keyboard="false">
                                            <div class="carousel-indicators" style="margin-top: 10px;">
                                                <button type="button" data-bs-target="#profileDetails" data-bs-slide-to="0" class="active me-2" aria-label="Slide 1" style="width: 30px; background-color: black;" id="formBtn"></button>
                                                <button type="button" data-bs-target="#profileDetails" data-bs-slide-to="1" aria-label="Slide 2" style="width: 30px; height: 6px; background-color: black;" id="tableBtn"></button>
                                            </div>
                                            <div class="carousel-inner mb-3 ">
                                                <div class="carousel-item active" data-bs-interval="10000">

                                                    <form class="form-horizontal form-material ">
                                                        <div class="form-group mb-4 mt-3">
                                                            <label class="col-md-12 p-0">Full Name</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" placeholder="Kasuna Kalhara Withana Gamage" class="form-control p-0 border-0 ps-3" id="nameIn" value="<?php echo $rs_data['m_name']; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">NIC Number</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" placeholder="2153xxxxxxxx" class="form-control p-0 border-0 ps-3" id="nic" value="<?php echo $rs_data['nic']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0">Email</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="email" placeholder="johnathan@admin.com(Optional)" class="form-control p-0 border-0 ps-3" name="example-email" id="email" value="<?php echo $rs_data['email']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Mobile Number</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" class="form-control p-0 border-0 ps-3" id="mobileNum" value="<?php echo $rs_data['m_number']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date of birth</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" class="form-control p-0 border-0 ps-3" id="dob" value="<?php echo $rs_data['dob']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Address</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" class="form-control p-0 border-0 ps-3" id="address" value="<?php echo $rs_data['address']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Membership</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select class="form-select ps-3 no-border" aria-label="Default select example" id="mShipSelection">
                                                                    <?php
                                                                    $mShip_rs = Database::search("SELECT * FROM `membership` WHERE `mS_id` = '" . $rs_data['membership_m_id'] . "' ;");
                                                                    $mShip_num = $mShip_rs->num_rows;
                                                                    $mShip_data = $mShip_rs->fetch_assoc();

                                                                    $mShip_rs = Database::search("SELECT * FROM `membership`;");
                                                                    $mShip_num = $mShip_rs->num_rows;

                                                                    for ($x = 0; $x < $mShip_num; $x++) {
                                                                        $mShip_data = $mShip_rs->fetch_assoc();

                                                                        if ($mShip_data['mS_id'] == $rs_data['membership_m_id']) {
                                                                    ?>
                                                                            <option selected value="<?php echo $mShip_data['mS_id']; ?>"><?php echo $mShip_data['mS_name']; ?>: Rs. <?php echo $mShip_data['price']; ?>.00</option>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <option value="<?php echo $mShip_data['mS_id']; ?>"><?php echo $mShip_data['mS_name']; ?>: Rs. <?php echo $mShip_data['price']; ?>.00</option>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Occupation and Place of Employment</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" class="form-control p-0 border-0 ps-3" id="occupationInput" value="<?php echo $rs_data['occupation']; ?>">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="carousel-item" data-bs-interval="2000">

                                                    <div class="form-group mb-4">
                                                        <label class="col-md-12 p-0">Personal Goal</label>
                                                        <div class="col-md-12 border-bottom p-0">
                                                            <input type="text" class="form-control p-0 border-0 ps-3" id="pGoal" value="<?php echo $rs_data['pGoal']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label class="col-md-12 p-0">Gender</label>
                                                        <div class="col-md-12 border-bottom p-0">
                                                            <input type="text" class="form-control p-0 border-0 ps-3" readonly id="pGender" value="<?php echo $rs_data['gender']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label class="col-md-12 p-0">Coaching Advise</label>
                                                        <div class="col-md-12 border-bottom p-0">
                                                            <input type="text" class="form-control p-0 border-0 ps-3" readonly id="cAadvice" value="<?php echo $rs_data['Advice_type']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label class="col-md-12 p-0">Physical Condition or any other Remarks</label>
                                                        <div class="col-md-12 border-bottom p-0 ">
                                                            <textarea rows="3" id="pCAOR" class="form-control p-0 border-0 ps-3"><?php echo $rs_data['remarks']; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <label class="col-md-12 p-0 text-center h4 fw-bold my-3 text-dark">Mearsurement Chart</label>

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-responsive border-dark " id="mesurmentTableP">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" class="text-danger">Add Date</th>
                                                                    <th scope="col" class="text-primary">Neck</th>
                                                                    <th scope="col" class="text-primary">Chest</th>
                                                                    <th scope="col" class="text-primary">Waist</th>
                                                                    <th scope="col" class="text-primary">L Upper</th>
                                                                    <th scope="col" class="text-primary">R Upper</th>
                                                                    <th scope="col" class="text-primary">L Fore</th>
                                                                    <th scope="col" class="text-primary">R Fore</th>
                                                                    <th scope="col" class="text-primary">Hips</th>
                                                                    <th scope="col" class="text-primary">L Wrist</th>
                                                                    <th scope="col" class="text-primary">R Wrist</th>
                                                                    <th scope="col" class="text-primary">L Thigh</th>
                                                                    <th scope="col" class="text-primary">R Thigh</th>
                                                                    <th scope="col" class="text-primary">L Knee</th>
                                                                    <th scope="col" class="text-primary">R Knee</th>
                                                                    <th scope="col" class="text-primary">L Calf</th>
                                                                    <th scope="col" class="text-primary">R Calf</th>
                                                                    <th scope="col" class="text-primary">L Ankle</th>
                                                                    <th scope="col" class="text-primary">R Ankle</th>
                                                                    <th scope="col" class="text-primary">Height</th>
                                                                    <th scope="col" class="text-primary">Weight</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="tMeasurement">
                                                                <?php
                                                                $tMeaurement_q = "SELECT * FROM `measurment` WHERE `members_id` = ?;";
                                                                $tMeaurement_q_types = "i";

                                                                $tMeaurement_q_rs = Database::searchPrepared($tMeaurement_q, $tMeaurement_q_types, $sanitized_id);
                                                                $tMeaurement_q_num = $tMeaurement_q_rs->num_rows;

                                                                for ($i = 0; $i < $tMeaurement_q_num; $i++) {
                                                                    $tMeaurement_q_data = $tMeaurement_q_rs->fetch_assoc();

                                                                ?>
                                                                    <tr>
                                                                        <th><?php echo $tMeaurement_q_data['added_date']; ?></th>
                                                                        <td><?php echo $tMeaurement_q_data['neck']; ?></td>
                                                                        <td><?php echo $tMeaurement_q_data['chest']; ?></td>
                                                                        <td><?php echo $tMeaurement_q_data['waist']; ?></td>
                                                                        <td><?php echo $tMeaurement_q_data['l_upper']; ?></td>
                                                                        <td><?php echo $tMeaurement_q_data['r_upper']; ?></td>
                                                                        <td><?php echo $tMeaurement_q_data['l_fore']; ?></td>
                                                                        <td><?php echo $tMeaurement_q_data['r_fore']; ?></td>
                                                                        <td><?php echo $tMeaurement_q_data['hips']; ?></td>
                                                                        <td><?php echo $tMeaurement_q_data['l_wrist']; ?></td>
                                                                        <td><?php echo $tMeaurement_q_data['r_wrist']; ?></td>
                                                                        <td><?php echo $tMeaurement_q_data['l_thigh']; ?></td>
                                                                        <td><?php echo $tMeaurement_q_data['r_thigh']; ?></td>
                                                                        <td><?php echo $tMeaurement_q_data['l_knee']; ?></td>
                                                                        <td><?php echo $tMeaurement_q_data['r_knee']; ?></td>
                                                                        <td><?php echo $tMeaurement_q_data['l_calf']; ?></td>
                                                                        <td><?php echo $tMeaurement_q_data['r_calf']; ?></td>
                                                                        <td><?php echo $tMeaurement_q_data['l_ankle']; ?></td>
                                                                        <td><?php echo $tMeaurement_q_data['r_ankle']; ?></td>
                                                                        <td><?php echo $tMeaurement_q_data['height']; ?></td>
                                                                        <td><?php echo $tMeaurement_q_data['weight']; ?></td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>


                                                                <tr class="text-center text-dark d-none" id="addNewMemTr">
                                                                    <th scope="row" class="text-success"><?php echo $date; ?></th>
                                                                    <td contenteditable="true"></td>
                                                                    <td contenteditable="true"></td>
                                                                    <td contenteditable="true"></td>
                                                                    <td contenteditable="true"></td>
                                                                    <td contenteditable="true"></td>
                                                                    <td contenteditable="true"></td>
                                                                    <td contenteditable="true"></td>
                                                                    <td contenteditable="true"></td>
                                                                    <td contenteditable="true"></td>
                                                                    <td contenteditable="true"></td>
                                                                    <td contenteditable="true"></td>
                                                                    <td contenteditable="true"></td>
                                                                    <td contenteditable="true"></td>
                                                                    <td contenteditable="true"></td>
                                                                    <td contenteditable="true"></td>
                                                                    <td contenteditable="true"></td>
                                                                    <td contenteditable="true"></td>
                                                                    <td contenteditable="true"></td>
                                                                    <td contenteditable="true"></td>
                                                                    <td contenteditable="true"></td>

                                                                </tr>


                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="row my-3">
                                                        <button class="btn btn-warning mx-auto mb-3 " style="width: 200px;" id="addtMeasurementBtn"><i class="bi bi-plus-square me-2"></i> Add New Measurement</button>
                                                        <button class="btn btn-danger d-none mb-3 mx-auto text-light h4" style="width: 200px;" id="cancelMeasurementBtn">Cancel Addon <i class="bi bi-x-lg ms-2"></i></button>
                                                    </div>
                                                    <div class="p-3 mb-3 d-flex justify-content-end">
                                                        <button class="btn btn-dark text-light" style="margin-right: 10px;" onclick="printDiv('print-div');" id="printDetailsBtn"><i class="bi bi-printer-fill me-2"></i>Print Details</button>
                                                        <?php
                                                        if ($rs_data['status_id'] === 2) {
                                                        ?>
                                                            <button class="btn btn-primary text-light" style="margin-right: 10px;" id="disableUserBtn"><i class="bi bi-slash-circle me-2"></i>Enable</button>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <button class="btn btn-danger text-light" style="margin-right: 10px;" id="disableUserBtn"><i class="bi bi-slash-circle me-2"></i>Disable</button>
                                                        <?php
                                                        }
                                                        ?>
                                                        <!-- <button class="btn btn-danger text-light" id="dropUserBtn">Drop Member<i class="bi bi-trash3-fill ms-2"></i></button> -->
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="form-group mb-4">
                                            <div class="col-sm-12">
                                                <button class="btn btn-success text-white" id="updateProfileBtn">Update Profile</button>
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