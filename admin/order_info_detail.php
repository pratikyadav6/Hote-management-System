<?php
session_start();
if (!isset($_SESSION['first_name'])) {
    // If the session variable 'first_name' is not set, redirect to login page
    header('Location: ../login.php');
    exit();
}
include '../include/config.php';
$bill_amount = 0;
$table_no = 0;
$staff_id = 0;
$order_type = '';
$payment_type = '';
$cash_received = 0;
$change_due = 0;
$discount = 0;
$date = 0;
$order_no = 0;


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">

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
            width: 75vh;
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
                    <?php
                    if (isset($_GET['id'])) {
                        $bill_id = $_GET['id'];

                        $sql = "SELECT * From bill Where bil_id=$bill_id";
                        $bill = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($bill);
                        if ($count == 1) {
                            $row = mysqli_fetch_assoc($bill);
                            $table_no = $row['table_no'];
                            $bill_amount = $row['bill_amount'];

                            $staff_id = $row['staff_id'];
                            $order_type = $row['order_type'];
                            $payment_type = $row['payment_type'];
                            $cash_received = $row['cash_received'];
                            $change_due = $row['change_due'];
                            $discount = $row['discount'];
                            $date = $row['date'];
                            $order_no = $row['order_no'];
                        }

                    ?>
                        <div class="mydiv">
                            <div class="mydiv2">
                                <div class="scrollable-table">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Item Name</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Total Price</th>
                                                <!-- <th scope="col">Action</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total_price1 = 0;
                                            $bill_amount = 0;
                                            $sql = "SELECT SUM(quantity) as quantity, item_name, price, id FROM `order` WHERE order_no= $order_no AND table_no=$table_no GROUP BY item_name;";
                                            $result = mysqli_query($conn, $sql);
                                            if ($result && mysqli_num_rows($result) > 0) {
                                                // $sql = "UPDATE tables SET status = 'reserved' WHERE table_no = $id";
                                                // $result1 = mysqli_query($conn, $sql);
                                                // if (!$result1) {
                                                //     echo "Failed: " . mysqli_error($conn);
                                                // }
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $total_price1 = $row['price'] * $row['quantity'];
                                                    $bill_amount += $total_price1;
                                                    // $sql = "UPDATE tables SET bill_amount = $bill_amount WHERE table_no = $id";
                                                    // $result1 = mysqli_query($conn, $sql);
                                                    // if (!$result1) {
                                                    //     echo "Failed: " . mysqli_error($conn);
                                                    // }
                                            ?>
                                                    <tr>
                                                        <td><?php echo $row['item_name']; ?></td>
                                                        <td><?php echo $row['quantity']; ?></td>
                                                        <td><?php echo $row['price']; ?></td>
                                                        <td><?php echo $total_price1; ?></td>

                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='6'>No data found.</td></tr>";
                                            }


                                            // if (isset($_GET['o_id'])) {
                                            //     $id = $_GET['o_id'];
                                            //     $sq = "SELECT table_no FROM `order` WHERE id = $id";
                                            //     $result3 = mysqli_query($conn, $sq);
                                            //     $row = mysqli_fetch_assoc($result3);
                                            //     $sql = "UPDATE `order` SET quantity = quantity - 1 WHERE id = $id";
                                            //     $result1 = mysqli_query($conn, $sql);
                                            //     if (!$result1) {
                                            //         echo "Failed: " . mysqli_error($conn);
                                            //     }
                                            //     $sql = "DELETE FROM `order` WHERE id = $id AND quantity = 0";
                                            //     $result = mysqli_query($conn, $sql);
                                            //     if (!$result) {
                                            //         echo "Failed: " . mysqli_error($conn);
                                            //     }
                                            //     header("Location: orders.php?id_table=" . $row['table_no']);
                                            //     $tableNo = $row['table_no'];
                                            //     if ($tableNo !== '') {
                                            //         echo '<script type="text/javascript">';
                                            //         echo 'window.location.href="invoice.php?id_table=' . urlencode($tableNo) . '";';
                                            //         echo '</script>';
                                            //         exit(); // Stop script execution
                                            //     } else {
                                            //         echo "Error: Table number not specified.";
                                            //         exit(); // Stop script execution
                                            //     }
                                            //     
                                            ?>
                                            <?php
                                            // }
                                            // 
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <h2>Total Bill : <span style="color: Green; style:bold;"><?php echo number_format($bill_amount, 2); ?></span></h2>

                                <?php
                                $sql = "SELECT * from users where id=$staff_id";
                                $staff = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($staff);
                                ?>
                                 
                                 <h4>Order Taken By <b style="color:slateblue;"><?php echo $row['first_name']." ". $row['last_name']." (".$row['type'].")"?></b> </h4>
                                 <h5>Mobile No :  <b style="color:brown"><?php echo $row['mobile_no']?></b></h5>
                               
                                 <!-- <h5>Date  :  <b style="color:brown"><?php echo $row['date']?></b></h5> -->


                                <?php
                                ?>
                            </div>

                            <div class="mydiv3">
                                <form>
                                    <label for="order type" class="form-label">Order type <span class="text-danger">*</span></label> <br>
                                    <input style="background-color: transparent; " class="form-control" type="text" name="itemname" value="<?php echo $order_type ?>" placeholder="Item Name" required readonly>
                                    <label for="type" class="form-label">Payment type <span class="text-danger">*</span></label>
                                    <input style="background-color: transparent; " class="form-control" type="text" name="itemname" value="<?php echo $payment_type ?>" placeholder="Item Name" required readonly>
                                    <br>
                                    <label for="cashReceived" class="form-label">Cash Received</label>
                                    <input style="background-color: transparent; " class="form-control" type="text" name="itemname" value="<?php echo $cash_received ?>" placeholder="Item Name" required readonly>
                                    <label for="changeDue" class="form-label">Change Due</label>
                                    <input style="background-color: transparent; " class="form-control" type="text" name="itemname" value="<?php echo $change_due ?>" placeholder="Item Name" required readonly>
                                    <label for="discount" class="form-label">Discount</label>
                                    <input style="background-color: transparent; " class="form-control" type="text" name="itemname" value="<?php echo $discount ?>" placeholder="Item Name" required readonly>
                                    <br>
                                    <!-- <button type="submit" name="submit" id="addButton" class="btn btn-primary">Add</button> -->
                                </form>
                                <!-- <a type="hidden" href="bill.php?id_table=<?php echo $_GET['id_table'] ?>"><button type="button" id="printButton" name="submit1" class="btn btn-success">Print</button></a> -->
                            </div>
                        </div>
                    <?php
                    } else {
                        echo "Not Finding Records";
                    }
                    ?>
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