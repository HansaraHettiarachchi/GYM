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
                        <h4 class="page-title fs-6"><span class="fas fa-users mx-2"></span> Members </h4>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class=" col-12 mx-lg-auto">
                        <div class="card">
                            <div class="card-body">

                                <div class="col-12 col-md-5 col-sm-6 mx-auto mb-3 border border-2 p-2">
                                    <div class="search-container ">
                                        <input type="text" class="form-control ps-3" id="memberSearch" placeholder="Search...">
                                        <span class="search-close" id="searchClose"><i class="bi bi-x-lg"></i></span>
                                    </div>
                                </div>
                                <div class="" id="myDiv">
                                    <div class="row">
                                        <?php

                                        $member_rs = Database::search("SELECT * FROM `members` INNER JOIN `profileimg` ON `profileimg`.p_id = `members`.`profileImg_p_id` ORDER BY `id` ASC ;");
                                        $member_num = $member_rs->num_rows;
                                        ?>
                                        <div class="d-none">
                                            <input type="text" id="mNum" value="<?php echo $member_num; ?>">
                                        </div>
                                        <?php

                                        for ($i = 0; $i < $member_num; $i++) {
                                            $member_data = $member_rs->fetch_assoc();

                                        ?>
                                            <div class="card shadow  border border-2 m-2 mx-auto mx-sm-auto p-3" style="width: 16rem;" id="mC<?php echo $i ?>">
                                                <div class=" border border-3" style="cursor: pointer;">
                                                    <img src="<?php echo $member_data['profileImgLocation']; ?>" onclick="goProfile(<?php echo $member_data['id']; ?>);" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <p id="mId<?php echo $i ?>" class="card-text text-danger text-center h3"><?php echo $member_data['id']; ?></p>
                                                        <p id="mName<?php echo $i ?>" class="card-text text-center h3"><?php echo $member_data['m_name']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
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