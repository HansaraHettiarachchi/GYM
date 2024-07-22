<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Country Fitness Gymnasium | Sign In</title>
    <link rel="icon" type="image/png" sizes="20x20" href="plugins/images/GYMIcon.png">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Protest+Revolution&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&family=Rowdies:wght@300;400;700&display=swap" rel="stylesheet">

</head>

<body>
    <?php
    include "connection.php";
    include "memberExpire.php";
    include "onload.php";
    ?>

    <div class="container " style="margin-top: 100px;">
        <div class="row d-flex justify-content-center ">
            <div class="col-lg-6 ">
                <div class="card p-4 shadow-lg border-0 rounded-0">

                    <!-- Form Header -->
                    <img src="plugins/images/GYM.png" class="mx-auto img-fluid" style="width: 200px;" alt="" srcset="">
                    <p class="text-center mt-2 mb-4 fs-4 text-uppercase" style='font-family: "Play", sans-serif; font-weight: 400;'>System LOGIN</p>

                    <?php
                    $email = "";
                    $password = "";

                    if (isset($_COOKIE["eOrNic"])) {
                        $email = $_COOKIE["eOrNic"];
                    }

                    if (isset($_COOKIE["ps"])) {
                        $password = $_COOKIE["ps"];
                    }
                    ?>

                    <div class="">
                        <form class="row mx-3 my-1">
                            <div class="col-12 d-none mb-3 rounded-0" id="msgdiv1">
                                <div class="alert alert-danger" role="alert" id="msg1">

                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <input type='email' id='aLemailNIC' placeholder='Email Or NIC' style="height: 50px;" class='form-control rounded-0' value="<?php echo $email ?>">
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="input-group mb-3">
                                    <input type="password" id="aLps" style="height: 50px;" class="form-control rounded-0" placeholder="Password" aria-label="Password" aria-describedby="ps" value="<?php echo $password ?>">

                                    <span class="input-group-text rounded-0 " id="aLps" onclick="showPassword1();">
                                        <i class="bi bi-eye" style="cursor: pointer;" id="ngnfd1"></i>
                                    </span>
                                </div>
                            </div>


                            <div class="form-check mt-1 mb-3">
                                <!-- onclick="checkbox();" -->
                                <input class="form-check-input rounded-0" style="margin-left: 0px;" type="checkbox" checked value="" id="rememberMe">
                                <label class="form-check-label fs-6 ms-1 text-dark fw-bold" for="rememberMe">
                                    Remember me
                                </label>
                            </div>


                            <div class="col-12 mt-4">
                                <center><button type="button" class="btn btn-dark rounded-0 col-12 col-md-4 " style="height: 50px;" id="aRlogInBtn">Log in</button></center>
                            </div>

                        </form>
                    </div>

                    <div class="text-center mt-3">
                        <?php

                        ?>
                        <p>Don't have an account? <a href="signUp.php" class="text-decoration-none fs-6 text-dark fw-bolder">Register</a></p>
                        <p><a href="forgetPassword.php" class="text-decoration-none fs-6 text-dark">Forgot password?</a></p>
                    </div>
                </div>

            </div>



        </div>
    </div>
    </div>
    </div>



    <script src="plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>