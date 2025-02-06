<?php
session_start();
if (!isset($_SESSION['first_name'])) {
    // If the session variable 'first_name' is not set, redirect to login page
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

    <title>Report</title>

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">

    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        .scrollable-table {
            height: 70vh;
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
                <form style="padding:10px" action="" method="post">
                    <label for="date">Table No : <span class="text-danger">*</span></label>
                    <input type="text" name="table_no" id="table_no" value="<?php echo isset($_POST['table_no']) ? htmlspecialchars($_POST['table_no']) : ''; ?>" placeholder="Enter Table No" required>
                    <label for="date">Select Date <span class="text-danger">*</span></label>
                    <input  required type="date" class="form-input" name="date" value="<?php echo isset($_POST['date']) ? htmlspecialchars($_POST['date']) : ''; ?>">
                    <button type="submit" name="submit" class="btn btn-primary">Search Orders </button>
                </form>
                <br>
                <div class="container-fluid">
                    <!-- <div class="mydiv">
                        <div class="mydiv2"> -->
                    <div class="scrollable-table">
                        <?php
                        include '../include/config.php';
                        if (isset($_POST['submit'])) {
                        ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Table No</th>
                                        <th scope="col">Bill Amount</th>
                                        <th scope="col">Order Type</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Table Order No</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php
                                    // $bill_amount = 0;
                                    $table_no = $_POST['table_no'];
                                    $date = $_POST['date'];
                                    $i = 0;
                                    $sql = "SELECT * FROM bill WHERE table_no=$table_no and DATE(date) ='$date'";
                                    $result = mysqli_query($conn, $sql);
                                    $count = mysqli_num_rows($result);
                                    if ($count > 0) {


                                        while ($row = mysqli_fetch_assoc($result)) {

                                            $i++
                                    ?>
                                            <!-- <tbody> -->
                                            <tr>
                                                <th scope="row"><?php echo "$i"; ?></th>
                                                <td><?php echo $row['table_no'] ?></td>
                                                <td><b style="color: red;"><?php echo number_format($row['bill_amount'],2) ?></b></td>
                                                <td><?php echo $row['order_type'] ?></td>
                                                <td><?php echo $row['date'] ?></td>
                                                <td style="text-align: center;"><b style="color: green;"><?php echo $row['order_no'] ?></b></td>

                                                <td>
                                                    <a href="order_info_detail.php?id=<?php echo $row['bil_id'] ?>"><button type="button" class="btn btn-info">Detail</button></a>
                                                    <!-- <a onclick="return confirm('Are you sure?')" href=""><button type="button" class="btn btn-danger">Delete</button></a> -->
                                                </td>
                                            </tr>
                                        <?php
                                        } ?>
                                </tbody>
                        <?php


                                    } else {
                                        echo " no data Found";
                                    }
                                }
                        ?>
                            </table>
                    </div>
                    <!-- <h2>Total Bill Of <b style="color:crimson;"><?php echo $_GET['id_table'] ?></b> : <span style="color: Green; style:bold;"><?php echo number_format($bill_amount, 2); ?></span></h2> -->
                    <!-- </div> -->

                    <!-- <div class="mydiv3">
                            <form action="update_order_status.php?id_table=<?php echo $_GET['id_table'] ?>" method="post">
                                <label for="ordertype" class="form-label">Select Order type <span class="text-danger">*</span></label>
                                <select class="form-select" id="ordertype" name="ordertype" aria-label=".form-select-lg example" required>
                                    <option value="">Select Order type</option>
                                    <option value="at hotel">At hotel</option>
                                    <option value="take away">Take away</option>
                                </select>
                                <label for="type" class="form-label">Select Payment type <span class="text-danger">*</span></label>
                                <select class="form-select" id="paymentType" name="type" aria-label=".form-select-lg example" required>
                                    <option value="">Select Payment type</option>
                                    <option value="cash">Cash</option>
                                    <option value="online">Online</option>
                                    <option value="card">Card</option>
                                </select>

                                <div id="cashInputs" class="cash-inputs">
                                    <label for="cashReceived" class="form-label">Cash Received</label>
                                    <input type="number" value="0" class="form-control" id="cashReceived" name="cashReceived" placeholder="Enter amount received">
                                    <label for="changeDue" class="form-label">Change Due</label>
                                    <input type="number" value="0" class="form-control" id="changeDue" name="changeDue" placeholder="Enter change due">
                                </div>
                                <label for="discount" class="form-label">Discount</label>
                                <input type="number" class="form-control" id="discount" name="discount" value="0" placeholder="Enter discount amount">
                                <br>
                                <button type="submit" name="submit" id="addButton" class="btn btn-primary">Add</button>
                            </form>
                            <a type="hidden" href="bill.php?id_table=<?php echo $_GET['id_table'] ?>"><button type="button" id="printButton" name="submit1" class="btn btn-success">Print</button></a>
                        </div>
                    </div> -->
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
    <!-- <script>
        document.getElementById('paymentType').addEventListener('change', function() {
            var cashInputs = document.getElementById('cashInputs');
            if (this.value === 'cash') {
                cashInputs.style.display = 'block';
            } else {
                cashInputs.style.display = 'none';
            }
        });
        document.addEventListener('keydown', function(event) {
            if (event.key === 'F6') {
                event.preventDefault();
                document.getElementById('printButton').click();
            }
        });
        document.addEventListener('keydown', function(event) {
            if (event.key === 'F9') {
                event.preventDefault();
                document.getElementById('addButton').click();
            }
        });
    </script> -->
</body>

</html>