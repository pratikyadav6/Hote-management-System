<?php
include './include/config.php';
session_start();
if (!isset($_SESSION['first_name'])) {
    // If the session variable 'first_name' is not set, redirect to login page
    header('Location: ./login.php');
    exit(); // Stop further script execution
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Pass</title>
    <link href="./vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link href="./css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php include './include/navbar.php' ?>


                <div class="container-fluid">

                    <div class=" col-12 col-md-6 bsb-tpl-bg-lotion">
                        <div class="p-3 p-md-4 p-xl-5">

                            <form action="" method="post" onsubmit="return validatePassword()">
                                <div class="d-flex p-2 bd-highlight">
                                    <div class="col-12">
                                        <label for="oldPassword" class="form-label">Enter Old Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="oldPassword" id="oldPassword" placeholder="Old Password" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="newPassword" class="form-label">Enter New Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="New Password" required>
                                    </div>
                                </div>
                                <div class="d-flex p-2 bd-highlight">
                                    <div class="col-12">
                                        <label for="confirmPassword" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="confirmPassword" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="email" value="<?php echo $_SESSION['email'] ?>" id="email" placeholder="Email" readonly>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn bsb-btn-xl btn-success" name="submit" type="submit">Update Password</button>
                                    </div>
                                </div>
                            </form>

                            <script>
                                function validatePassword() {
                                    const newPassword = document.getElementById("newPassword").value;
                                    const confirmPassword = document.getElementById("confirmPassword").value;

                                    if (newPassword !== confirmPassword) {
                                        alert("New Password and Confirm Password do not match.");
                                        return false;
                                    }
                                    return true;
                                }
                            </script>


                        </div>
                    </div>

                </div>




            </div>

        </div>

    </div>



    <script src="./vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <script src="./vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="./js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="./vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="./js/demo/chart-area-demo.js"></script>
    <script src="./js/demo/chart-pie-demo.js"></script>
</body>

</html>
<?php
if (isset($_POST['submit'])) {
    $id = $_SESSION['id']; 
    $oldPassword = md5($_POST['oldPassword']);
    $newPassword = $_POST['confirmPassword'];

    $sql = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    $pass = $user['password'];

    if ($oldPassword==$pass) {
        $newPasswordHash = md5($newPassword);

        $updateSql = "UPDATE users SET password = '$newPasswordHash' WHERE id = '$id'";
        if (mysqli_query($conn, $updateSql)) {
            echo '<script>alert("Password updated successfully!");</script>';
            echo "<script>window.location.href='logout.php'</script>";
            exit(); 
        } else {
            echo '<script>alert("Failed to update password. Please try again.");</script>';
        }
    } else {
        echo '<script>alert("Old password is incorrect.");</script>';
    }
}
?>