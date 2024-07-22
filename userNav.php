<nav class="navbar top-navbar navbar-expand-md navbar-dark">
    <div class="navbar-header" data-logobg="skin6">
        <!-- Logo -->
        <a class="navbar-brand" href="">
            <!-- Logo icon -->
            <b class="logo-icon">
                <!-- Dark Logo icon -->
                <img src="plugins/images/GYMLogoText.png" style="width: 50px;" alt="homepage" />
            </b>
            <!--End Logo icon -->
            <!-- Logo text -->
            <span class="logo-text">
                <!-- dark Logo text -->
                <img src="plugins/images/logo-text.png" alt="homepage" style="width: 150px;" />
            </span>
        </a>
        <!-- End Logo -->
        <!-- toggle and nav items -->
        <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
    </div>
    <!-- End Logo -->
    <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">

        <ul class="navbar-nav ms-auto d-flex align-items-center">

            <li>
                <?php
                $user_data;
                if (isset($_SESSION['user'])) {
                    $user_data = $_SESSION['user'];
                ?>

                    <div class="dropdown">
                        <a class="profile-pic dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="<?php echo $user_data['location']; ?>" alt="user-img" width="36" class="img-circle me-3"><span class="text-white font-medium me-3"><?php echo $user_data['fname']; ?> <?php echo $user_data['lname']; ?></span>
                        </a>
                        <div class="dropdown-menu col-12 row px-4" aria-labelledby="dropdownMenuLink">
                            <p class="mt-4 text-center fs-4"><a class="text-primary" href="workerProfile.php?id=<?php echo $_SESSION['user']['w_id']; ?>">Go to Profile</a></p>
                            <button class="btn btn-outline-danger border-2 mt-1 mx-auto" id="logout" onclick="logout();"><i class="bi bi-box-arrow-left me-2"></i>LOG OUT</button>
                        </div>
                    </div>

                    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                <?php
                } else {
                    header("Location: login.php");
                    exit;
                }
                ?>

            </li>

        </ul>
    </div>
</nav>