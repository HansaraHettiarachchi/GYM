<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Country Fitness Gymnasium | Forget Password</title>
    <link rel="icon" type="image/png" sizes="20x20" href="plugins/images/GYMIcon.png">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Protest+Revolution&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>
    <?php include "connection.php" ?>

    <div class="container " style="margin-top: 100px;">
        <div class="row d-flex justify-content-center ">
            <div class="col-lg-6 ">
                <div class="card p-4 shadow-lg border-1 rounded-0">

                    <img src="plugins/images/GYM.png" class="mx-auto img-fluid" style="width: 200px;" alt="" srcset="">
                    <p class="text-center mt-2 mb-1 fs-4 text-uppercase" style='font-family: "Play", sans-serif; font-weight: 400;'>WELCOME BACK</p>

                    <div class="text-secondary mt-1 ms-4 me-4 mb-5 " id="FPMSdiv">
                        <p class="mt-4">Please enter the email address for your account. A verification code will be sent to you.
                            Once you have received the verification code, you will be able to choose a new password for your account.</p>

                        <input type='email' id='FPemail' placeholder='Enter your email address' style="height: 45px;" class='border-1 border-secondary text-start col-12 rounded-0 mb-1 mt-3 p-3'>

                        <div class="col-12 d-none mt-1" id="msgdiv2">
                            <div class="alert alert-danger rounded-0" role="alert" id="msg2">

                            </div>
                        </div>

                        <center>
                            <button style="background-color: black; font-size: smaller;" class="btn text-white rounded-0 col-6 m-4" onclick="forgetPassowrd();">REQUEST PASSWORD RESET </button>
                        </center>
                        <center>
                            <p class="fs-6" style="color: black; ">Back to <b class="fw-medium" style="cursor: pointer;" onclick="backTologin();">Login</b></p>
                        </center>

                    </div>

                    <div id="loadingDiv" class="d-none">
                        <div class="">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-secondary m-4 d-none" id="FPCPdiv">

                        <div class="row g-4 ">
                            <div class="input-group col-md-12">
                                <input type='text' id='verifyCode' placeholder='Enter Your Verification Code here' style="height: 45px;" class='form-control rounded-0'>
                                <button type="button" id="btnVerify" class="btn btn-secondary col-4 col-sm-2 text-center rounded-0" onclick="verifyCode();">Verify </button>
                            </div>

                            <div class="col-12 d-none g-4" id="msgdiv3">
                                <div class="alert alert-danger rounded-0" role="alert" id="msg3">

                                </div>

                                <div class="alert alert-success rounded-0 fw-medium d-none" id="msg4">
                                    Verified <i class="bi bi-patch-check-fill g-1"></i>
                                </div>
                            </div>

                            <label for="newPassword" class="text-dark fw-medium">New Password</label>
                            <div class="col-md-12 input-group ">
                                <input type='password' disabled id='newPassword' placeholder='New Password' style="height: 45px;" class='form-control rounded-0 ' aria-label="Password" aria-describedby="ps">

                                <span class="input-group-text rounded-0 " id="newPassword" onclick="showPassword1();">
                                    <i class="bi bi-eye" style="cursor: pointer;" id="ngnfd1"></i>
                                </span>
                            </div>

                            <label for="ReNewPassword" class="text-dark fw-medium">Re-Enter New Password</label>
                            <div class="col-12 ">
                                <input type='password' disabled id='ReNewPassword' placeholder='Re-Enter Password' style="height: 45px;" class='form-control rounded-0 '>
                            </div>
                            <div class="d-md-flex justify-content-md-center">
                                <button type="button" class="btn btn-danger rounded-0 col-4 text-white fw-normal fs-6 mt-3 col-12 col-md-4 me-3" onclick="cancel();">Cancel</button>
                                <button type="button" class="btn btn-dark rounded-0 col-4 text-white fw-normal fs-6 mt-3 col-12 col-md-4" onclick="changePassword();">Comfirm</button>
                            </div>
                        </div>

                    </div>

                </div>

            </div>



        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>