<?php
session_start();
if (!isset($_SESSION['first_name'])) {
    // If the session variable 'first_name' is not set, redirect to login page
    header('Location: ../login.php');
    exit(); // Stop further script execution
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include '../include/sidebar.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php include '../include/navbar.php' ?>


                <div class="container-fluid">

                    <div class=" col-12 col-md-6 bsb-tpl-bg-lotion">
                        <div class="p-3 p-md-4 p-xl-5">

                            <form action="" method="post">
                                <div class="d-flex p-2 bd-highlight">
                                    <div class="col-12">
                                        <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="firstName" id="firstName" placeholder="First Name" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Last Name" required>
                                    </div>
                                </div>
                                <div class="d-flex p-2 bd-highlight">

                                    <div class="col-12">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="name@gmail.com" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="password" id="password" value="" required>
                                    </div>
                                </div>
                                <div class="d-flex p-2 bd-highlight">

                                    <div class="col-12">
                                        <label for="type" class="form-label">Select Type Of User <span class="text-danger">*</span></label>
                                        <select class="form-select" name="type" aria-label=".form-select-lg example" required>
                                            <option value="">Select Type</option>
                                            <option value="staff">staff</option>
                                            <option value="kitchen_manager">kitchen_manager</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="lastName" class="form-label">Mobile No <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="mobile" id="mobile" placeholder="Mobile" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn bsb-btn-xl btn-primary" name="submit" type="submit">Add User</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>




            </div>

        </div>

    </div>



    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>
</body>

</html>
<?php

include '../include/config.php';

if (isset($_POST['submit'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $mobile = $_POST['mobile'];
    $type = $_POST['type'];

    $sql = "SELECT * FROM users WHERE email = '$email' ";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);


    if ($count == 0) {
        echo '<script>alert(" User Added in system");</script>';
        $sql = "INSERT INTO users (first_name,last_name,email,password,mobile_no,type) values ('$firstName','$lastName','$email','$password','$mobile','$type')";
        $result = mysqli_query($conn, $sql);
    } else {

        echo '<script>alert(" User exist")</script> ';
        // $count = mysqli_num_rows($result1);
    }
}
