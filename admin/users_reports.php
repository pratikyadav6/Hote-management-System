<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Staff-Dashboard</title>

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">


</head>

<body id="page-top">
    <div id="wrapper">
        <?php
        include '../include/sidebar.php'
        ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include '../include/navbar.php' ?>
                <div class="container-fluid">
                    <form action="" method="post">
                    <label for="user" class="form-label">Select User Type<span class="text-danger">*</span></label> <br>
                        <select class="form-select" aria-label="Default select example" name="user" onchange="this.form.submit()" required>
                            <option value="<?php echo isset($_POST['user']) ? htmlspecialchars($_POST['user']) : ''; ?>">
                                <?php echo isset($_POST['user']) ? htmlspecialchars($_POST['user']) : 'Select user Type'; ?>
                            </option>
                            <option value="staff">staff</option>
                            <option value="kitchen_manager">kitchen_manager</option>
                        </select>
                    </form>
                    <div class="card-container">
                        <br>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Mobile No</th>
                                    <th scope="col">Type</th>
                                </tr>
                            </thead>

                            <?php
                            include '../include/config.php';
                            if (isset($_POST['user'])) {
                                $i = 0;
                                $user = $_POST['user'];
                                $sql = "SELECT * FROM users Where type='$user'";
                                $result = mysqli_query($conn, $sql);
                                $count = mysqli_num_rows($result);
                                if ($count > 0) {


                                    while ($row = mysqli_fetch_assoc($result)) {

                                        $i++
                            ?>
                                        <tbody>
                                            <tr>
                                                <th scope="row"><?php echo "$i"; ?></th>
                                                <td><?php echo  $row['first_name'] . " ".$row['last_name'] ?></td>
                                                <td><?php echo $row['email'] ?></td>
                                                <td><?php echo $row['mobile_no'] ?></td>
                                                <td><?php echo $row['type'] ?></td>
                                            </tr>
                                        <?php
                                    } ?>
                                        </tbody>
                                <?php


                                } else {
                                    echo " No data Found";
                                }
                            }  ?>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>
    <script src="../vendor/chart.js/Chart.min.js"></script>
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>
</body>

</html>