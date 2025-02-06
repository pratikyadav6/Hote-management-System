<?php
session_start();
if (!isset($_SESSION['first_name'])) {
    // If the session variable 'first_name' is not set, redirect to login page
    header('Location: ../login.php');
    exit(); // Stop further script execution
}
?>

<?php
include '../include/config.php';
$total_tables = 0;
$reserved_tables = 0;
$unreserved_tables = 0;
$today_bill = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <div id="wrapper">
        <?php include '../include/sidebar.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php include '../include/navbar.php' ?>


                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <h1 class="h3 mb-0 text-gray-800">
                            Date : <b style="color: red;"><?php echo date('d-m-y') ?></b>
                        </h1>
                    </div>
                    <div class="row">


                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Tables</div>
                                            <?php
                                            $sql = "SELECT table_no from tables";
                                            $result = mysqli_query($conn, $sql);
                                            $total_tables = mysqli_num_rows($result);
                                            ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_tables ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-border-all"></i>
                                        </div>
                                        <a href="add_Table.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"> Add table</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Reserved Tables</div>
                                            <?php
                                            $sql = "SELECT table_no from tables where status='reserved'";
                                            $result = mysqli_query($conn, $sql);
                                            $reserved_tables = mysqli_num_rows($result);
                                            $unreserved_tables = $total_tables - $reserved_tables;
                                            ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $reserved_tables ?></div>
                                        </div>
                                        <div class="col-auto">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Unreserved Tables
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $unreserved_tables ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pending Requests</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <?php
                            $date = date('d'); // Get the current day of the month
                            $sql1 = "SELECT SUM(bill_amount) as bill, COUNT(bil_id) as id, date 
         FROM bill 
         WHERE DATE_FORMAT(date, '%d') = '$date' 
         GROUP BY DATE_FORMAT(date, '%d');";
                            $result1 = mysqli_query($conn, $sql1);

                            if ($result1) {
                                $row1 = mysqli_fetch_assoc($result1);
                                if ($row1) {
                                    $today_bill = $row1['bill'];
                                    $total_bills = $row1['id'];
                                } else {
                                    $today_bill = 0;
                                    $total_bills = 0;
                                }
                            } else {
                                echo "Error: " . mysqli_error($conn);
                            }
                            ?>

                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Today Earning </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($today_bill, 2) ?></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total No's Orders (Today's)
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_bills ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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