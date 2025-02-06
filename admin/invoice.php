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
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include '../include/config.php';
                                        $total_price1 = 0;
                                        if (isset($_GET['id_table'])) {
                                            $bill_amount = 0;
                                            $id = $_GET['id_table'];
                                            $sql = "SELECT SUM(quantity) as quantity, item_name, price, id FROM `order` WHERE table_no = $id AND status != 'paid' GROUP BY item_name;";
                                            $result = mysqli_query($conn, $sql);
                                            if ($result && mysqli_num_rows($result) > 0) {
                                                $sql = "UPDATE tables SET status = 'reserved' WHERE table_no = $id";
                                                $result1 = mysqli_query($conn, $sql);
                                                if (!$result1) {
                                                    echo "Failed: " . mysqli_error($conn);
                                                }
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $total_price1 = $row['price'] * $row['quantity'];
                                                    $bill_amount += $total_price1;
                                                    $sql = "UPDATE tables SET bill_amount = $bill_amount WHERE table_no = $id";
                                                    $result1 = mysqli_query($conn, $sql);
                                                    if (!$result1) {
                                                        echo "Failed: " . mysqli_error($conn);
                                                    }
                                        ?>
                                                    <tr>
                                                        <td><?php echo $row['item_name']; ?></td>
                                                        <td><?php echo $row['quantity']; ?></td>
                                                        <td><?php echo $row['price']; ?></td>
                                                        <td><?php echo $total_price1; ?></td>
                                                        <td>
                                                            <a onclick="return confirm('Are you sure?')" href="invoice.php?o_id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-danger">Delete</button></a>
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

                                        if (isset($_GET['o_id'])) {
                                            $id = $_GET['o_id'];
                                            $sq = "SELECT table_no FROM `order` WHERE id = $id";
                                            $result3 = mysqli_query($conn, $sq);
                                            $row = mysqli_fetch_assoc($result3);
                                            $sql = "UPDATE `order` SET quantity = quantity - 1 WHERE id = $id";
                                            $result1 = mysqli_query($conn, $sql);
                                            if (!$result1) {
                                                echo "Failed: " . mysqli_error($conn);
                                            }
                                            $sql = "DELETE FROM `order` WHERE id = $id AND quantity = 0";
                                            $result = mysqli_query($conn, $sql);
                                            if (!$result) {
                                                echo "Failed: " . mysqli_error($conn);
                                            }
                                            header("Location: orders.php?id_table=" . $row['table_no']);
                                            $tableNo = $row['table_no'];
                                            if ($tableNo !== '') {
                                                echo '<script type="text/javascript">';
                                                echo 'window.location.href="invoice.php?id_table=' . urlencode($tableNo) . '";';
                                                echo '</script>';
                                                exit(); // Stop script execution
                                            } else {
                                                echo "Error: Table number not specified.";
                                                exit(); // Stop script execution
                                            }
                                            ?>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <h2>Total Bill Of <b style="color:crimson;"><?php echo $_GET['id_table'] ?></b> : <span style="color: Green; style:bold;"><?php echo number_format($bill_amount, 2); ?></span></h2>
                        </div>

                        <div class="mydiv3">
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    const orderTypeSelect = document.querySelector("select[name='ordertype']");
                                    const paymentTypeSelect = document.querySelector("select[name='type']");
                                    const cashReceivedInput = document.getElementById("cashReceived");
                                    const changeDueInput = document.getElementById("changeDue");
                                    const discountInput = document.getElementById("discount");

                                  
                                      document.getElementById('paymentType').focus();
                              

                                    // orderTypeSelect.addEventListener("change", function() {
                                    //     if (this.value !== "") {
                                    //         paymentTypeSelect.focus();
                                    //     }
                                    // });

                                    paymentTypeSelect.addEventListener("change", function() {
                                        if (this.value === "cash") {
                                            document.getElementById("cashInputs").style.display = 'block';
                                            cashReceivedInput.focus();
                                        } else {
                                            document.getElementById("cashInputs").style.display = 'none';
                                            discountInput.focus();
                                        }
                                    });

                                    function handleEnterKey(event, nextElement) {
                                        if (event.key === 'Enter') {
                                            event.preventDefault();
                                            nextElement.focus();
                                        }
                                    }

                                    cashReceivedInput.addEventListener("keydown", function(event) {
                                        handleEnterKey(event, changeDueInput);
                                    });

                                    changeDueInput.addEventListener("keydown", function(event) {
                                        handleEnterKey(event, discountInput);
                                    });

                                    discountInput.addEventListener("keydown", function(event) {
                                        if (event.key === 'Enter') {
                                            event.preventDefault();
                                            document.querySelector("button[type='submit']").focus(); // Focus the submit button or another target element
                                        }
                                    });

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
                                });
                            </script>
                            <form action="update_order_status.php?id_table=<?php echo $_GET['id_table'] ?>" method="post">
                                <label for="ordertype"  class="form-label">Select Order type <span class="text-danger">*</span></label>
                                <select class="form-select"  id="ordertype" name="ordertype" aria-label=".form-select-lg example" required>
                                    <!-- <option value="">Select Order type</option> -->
                                    <option value="At hotel">At hotel</option>
                                    <option value="Take away">Take away</option>
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
    <script>
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
    </script>
</body>

</html>