<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Country Fitness Gymnasium | Sign Up</title>
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
  <?php include "connection.php" ?>

  <div class="container " style="margin-top: 100px;">
    <div class="row d-flex justify-content-center ">
      <div class="col-lg-6 ">
        <div class="card p-4 border shadow-lg border-0 rounded-0">

          <img src="plugins/images/GYM.png" class="mx-auto img-fluid" style="width: 200px;" alt="" srcset="">
          <p class="text-center mt-2 mb-4 fs-4 text-uppercase" style='font-family: "Play", sans-serif; font-weight: 400;'>Worker Registation</p>

          <div class="">
            <form class="row g-4 ">
              <div class="col-12 d-none" id="msgdiv1">
                <div class="alert alert-danger" role="alert" id="msg1">

                </div>
              </div>

              <div class="col-md">

                <input type='text' id='aRfname' placeholder='First Name' style="height: 50px;" class='form-control rounded-0'>
              </div>

              <div class="col-md">

                <input type='text' id='aRlname' placeholder='Last name' style="height: 50px;" class='form-control rounded-0'>
              </div>
              <div class="col-12">

                <input type='email' id='aRemail' placeholder='Email' style="height: 50px;" class='form-control rounded-0'>
              </div>
              <div class="col-md-6">

                <input type='text' id='aRmobileN' placeholder='Mobile Number' style="height: 50px;" class='form-control rounded-0'>
              </div>

              <div class="col-md">

                <input type='text' id='aRnic' placeholder='NIC Number' style="height: 50px;" class='form-control rounded-0'>
              </div>


              <div class="col-md-8">
                <div class="input-group mb-3">
                  <input type="password" id="rRpassword" class="form-control rounded-0" placeholder="Password" aria-label="Password" aria-describedby="ps">

                  <span class="input-group-text rounded-0 " id="password" onclick="showPassword();">
                    <i class="bi bi-eye" style="cursor: pointer;" id="ngnfd"></i>
                  </span>
                </div>
              </div>
              <div class="col-md-4">
                <select id="gender" class="form-select rounded-0">
                  <option class="rounded-0" selected>Gender</option>
                  <?php
                  $gender_rs = Database::search("SELECT * FROM `gender`;");
                  $gender_num = $gender_rs->num_rows;
                  for ($i = 0; $i < $gender_num; $i++) {
                    $gender_data = $gender_rs->fetch_assoc();
                  ?>
                    <option class="rounded-0" value="<?php echo $gender_data['g_id']; ?>"><?php echo $gender_data['gender']; ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="form-check mt-1 mb-3">
                <!-- onclick="checkbox();" -->
                <input class="form-check-input rounded-0" style="margin-left: 0px;" type="checkbox" value="" id="aRrememberMe">
                <label class="form-check-label fs-6 ms-2 text-dark " style="font-weight: 500;" for="rememberMe">
                  Agree to terms and conditions.
                </label>
              </div>
              <div class="col-12 mt-4">
                <center><button type="button" class="btn btn-dark rounded-0 col-12 col-md-4" style="height: 50px;" id="aURSignInBtn">Sign in</button></center>
              </div>


            </form>
          </div>

          <div class="text-center">
            <p class="mt-4">Already have an account? </p>
            <p><a href="login.php" class="text-decoration-none fs-6 text-dark fw-bolder">Login</a></p>
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