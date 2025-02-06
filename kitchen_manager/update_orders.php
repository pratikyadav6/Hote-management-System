<?php
session_start();
if (!isset($_SESSION['first_name'])) {
    
    header('Location: ../login.php');
    exit(); 
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

    <title>Dashboard</title>

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .scrollable-table {
            height: 55vh;

            overflow-y: auto;
        }

        .mydiv {
            display: flex;
        }

        .mydiv2 {
            margin: 2px;
            width: 90vh;
        }

        .mydiv3 {
            margin-left: 10px;
            width: 50vh;
        }

        .cash-inputs {
            display: none;
        }
    </style>

</head>

<body id="page-top">
    <div id="wrapper">
        <?php include '../include/sidebar.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php include '../include/navbar.php' ?>


                <div class="container-fluid">
                    <a href="../kitchen_manager/dashbord.php"><button type="submit" name="add_item" class="btn btn-primary">Back</button></a>
                    <div class="mydiv">
                        <div class="mydiv2">

                            <div class="scrollable-table">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Item Name</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include '../include/config.php';
                                        if (isset($_GET['id_table'])) {
                                            $bill_amount = 0;
                                            $id = $_GET['id_table'];
                                            $sql = "SELECT * FROM `order` WHERE table_no = $id and status!='paid' ";
                                            $result = mysqli_query($conn, $sql);
                                            if ($result && mysqli_num_rows($result) > 0) {
                                                // $sql = "UPDATE tables SET status = 'reserved' WHERE table_no = $id";
                                                // $result1 = mysqli_query($conn, $sql);

                                                while ($row = mysqli_fetch_assoc($result)) {

                                        ?>
                                                    <tr>
                                                        <td><?php echo $row['item_name']; ?></td>
                                                        <td><?php echo $row['quantity']; ?></td>
                                                        <td><?php echo $row['status']; ?></td>
                                                        <td>
                                                            <a onclick="return confirm('Are you sure?')" href="update_orders.php?o_id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-success">Call</button></a>
                                                            <a href="update_orders.php?processed=<?php echo $row['id']; ?>"><button type="button" class="btn btn-warning">processed</button></a>

                                                        </td>
                                                    </tr>
                                        <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='6'>No data found.</td></tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='6'>Table ID is missing in the URL.</td></tr>";
                                        }

                                        ?>
                                        <?php
                                        if (isset($_GET['o_id'])) {
                                            $id = $_GET['o_id'];
                                            $sq = "SELECT table_no FROM `order` WHERE id = $id";
                                            $result3 = mysqli_query($conn, $sq);
                                            $row = mysqli_fetch_assoc($result3);
                                            $sql = "UPDATE `order` SET status = 'ready' WHERE id = $id";
                                            $result1 = mysqli_query($conn, $sql);
                                            if (!$result1) {
                                                echo "Failed: " . mysqli_error($conn);
                                            }
                                            $tableNo = $row['table_no'];
                                            if ($tableNo !== '') {
                                                echo '<script type="text/javascript">';
                                                echo 'window.location.href="update_orders.php?id_table=' . urlencode($tableNo) . '";';
                                                echo '</script>';
                                                exit(); // Stop script execution
                                            } else {
                                                echo "Error: Table number not specified.";
                                                exit(); // Stop script execution
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
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
<?php
include '../include/config.php';

if (isset($_GET['processed'])) {
    $id = $_GET['processed'];
    $sq = "SELECT table_no FROM `order` WHERE id = $id";
    $result3 = mysqli_query($conn, $sq);
    $row = mysqli_fetch_assoc($result3);
    // Update the order status to 'processed' for the clicked table
    $sql = "UPDATE `order` SET status='processed' WHERE id=$id AND status='new'";
    if (mysqli_query($conn, $sql)) {
        $tableNo = $row['table_no'];
        if ($tableNo !== '') {
            echo '<script type="text/javascript">';
            echo 'window.location.href="update_orders.php?id_table=' . urlencode($tableNo) . '";';
            echo '</script>';
            exit(); // Stop script execution
        }
    } else {
        echo "Error updating order status: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>