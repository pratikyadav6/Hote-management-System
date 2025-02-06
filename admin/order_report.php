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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Report</title>

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include '../include/sidebar.php';
           $total_eraning=0;
        ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include '../include/navbar.php'; ?>
                <div class="container-fluid">
                    <form action="" method="post">
                        <label for="date">Select Date <span class="text-danger">*</span></label> <br>
                        <input type="date" class="form-input" name="date" value="<?php echo isset($_POST['date']) ? htmlspecialchars($_POST['date']) : ''; ?>">
                        <button type="submit">Submit</button>
                    </form>

                    <div class="card-container">
                        <br>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <!-- <th scope="col">Table No</th> -->
                                    <th scope="col">Item Name </th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                include '../include/config.php';
                                if (isset($_POST['date'])) {
                                    $i = 0;
                                    $date = $_POST['date'];
                                    $sql = "SELECT SUM(quantity) as quantity, table_no, item_name, price, id FROM `order` WHERE DATE(date) = ? GROUP BY item_name;";
                                    $stmt = mysqli_prepare($conn, $sql);
                                    mysqli_stmt_bind_param($stmt, 's', $date);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                    $count = mysqli_num_rows($result);
                                    if ($count > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $i++;
                                ?>
                                            <tr>
                                                <th scope="row"><?php echo $i; ?></th>
                                                
                                                <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                                <td><?php echo htmlspecialchars($row['price']); ?></td>
                                                <?php
                                                $total_eraning+=$row['quantity']*$row['price'];

                                                htmlspecialchars($total_eraning);
                                                ?>

                                            </tr>
                                             
                                        <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'>No data found</td></tr>";
                                    }
                                    mysqli_stmt_close($stmt);
                                }
                                ?>
                            </tbody>
                        </table>
                        <label for="date"> Total Earning  of <b><?php echo isset($_POST['date']) ? htmlspecialchars($_POST['date']) : ''; ?> =  <b style="color: red;"><?php echo $total_eraning  ?></b> </b></label> <br>

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
