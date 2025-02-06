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
    <title>Orders</title>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .scrollable-table {
            height: 55vh;
            overflow-y: auto;
        }

        .form-container {
            align-items: center;
            display: flex;
            gap: 1rem;
            /* Space between the select boxes */
            /* margin-bottom: 2rem; */
        }

        .form-container form {
            margin: 0;
            /* Remove default margin */
        }

        .btn-custom {
            margin-right: 0.5rem;
        }

        .total-bill {
            color: green;
            font-weight: bold;
            margin-top: 1rem;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php
        //  include '../include/sidebar.php'; 
        ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include '../include/navbar.php'; ?>
                <div class="container-fluid">
                    <div class="container">
                        <a href="../staff/dashbord.php"><button type="submit" name="add_item" class="btn btn-primary">Back</button></a>
                        <div class="form-container">
                            <br>
                            <form action="" method="post" class="mb-3">
                                <br>
                                <select class="form-select" name="o_type" aria-label=".form-select-lg example" onchange="this.form.submit()" required>
                                    <option value="">Select Order Type</option>
                                    <?php
                                    include '../include/config.php';
                                    $bill_amount = 0;
                                    $selected_o_type = isset($_POST['o_type']) ? $_POST['o_type'] : '';
                                    $sql = "SELECT * FROM order_type";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $selected = $selected_o_type == $row['o_type'] ? 'selected' : '';
                                        echo "<option value='{$row['o_type']}' {$selected}>{$row['o_type']}</option>";
                                    }
                                    ?>
                                </select>
                            </form>


                            <?php if (isset($_POST['o_type'])) : ?>
                                <?php
                                $o_type = $_POST['o_type'];
                                ?>
                                <form action="" method="post" class="mb-3">
                                    <br>
                                    <input type="hidden" name="o_type" value="<?php echo htmlspecialchars($o_type); ?>">
                                    <select class="form-select" name="item" aria-label=".form-select-lg example" onchange="this.form.submit()" required>
                                        <option value="">Select Item</option>
                                        <?php
                                        $selected_item = isset($_POST['item']) ? $_POST['item'] : '';
                                        $sql = "SELECT item_name FROM items WHERE o_type = '$o_type'";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $selected = $selected_item == $row['item_name'] ? 'selected' : '';
                                            echo "<option value='{$row['item_name']}' {$selected}>{$row['item_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </form>
                            <?php endif; ?>
                        </div>

                        <?php
                        if (isset($_POST['item'])) {
                            $item_code = $_POST['item'];
                            $sql = "SELECT * FROM items WHERE item_name = '$item_code'";
                            $result = mysqli_query($conn, $sql);
                            if ($result && mysqli_num_rows($result) == 1) {
                                $row = mysqli_fetch_assoc($result);
                        ?>
                                <form action="" method="post" id="addItemForm" class="mb-3">
                                    <input type="hidden" name="o_type" value="<?php echo htmlspecialchars($o_type); ?>">
                                    <input type="hidden" name="itemcode" value="<?php echo $row['item_code']; ?>">
                                    <input type="text" name="itemname" value="<?php echo $row['item_name']; ?>" placeholder="Item Name" required readonly>
                                    <input type="number" name="itemquantity" id="itemquantity" placeholder="Enter Quantity" required>
                                    <input type="text" name="itemPrice" value="<?php echo $row['price']; ?>" placeholder="Item Price" required readonly>
                                    <a href="orders.php?id_table=<?php echo isset($_GET['id_table']) ? htmlspecialchars($_GET['id_table']) : '' ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
                                    <button type="submit" name="add_item" class="btn btn-primary">Add</button>
                                </form>
                                <script>
                                    document.getElementById('itemquantity').focus();
                                </script>
                                <?php
                            } else {
                                echo "Item not found.";
                            }
                        }

                        if (isset($_POST['add_item'])) {
                            $id = $_GET['id_table'];
                            $itemcode = $_POST['itemcode'];
                            $itemname = $_POST['itemname'];
                            $itemquantity = $_POST['itemquantity'];
                            $itemPrice = $_POST['itemPrice'];

                            $sql = "SELECT category FROM items WHERE item_code = '$itemcode'";
                            $result = mysqli_query($conn, $sql);
                            if ($result && mysqli_num_rows($result) == 1) {
                                $row = mysqli_fetch_assoc($result);
                                $category = $row['category'];
                                $u_id = $_SESSION['id'];
                                date_default_timezone_set('Asia/Kolkata');
                                $date =  date("Y-m-d H:i:s");
                                $sql1 = "INSERT INTO `order` (table_no, category, item_name, item_code, quantity, price, status, date,s_id) VALUES ('$id', '$category', '$itemname', '$itemcode', '$itemquantity', '$itemPrice', 'new', '$date','$u_id')";
                                $result1 = mysqli_query($conn, $sql1);
                                if ($result1) {
                                    $id_table = urlencode($_GET['id_table']);
                                ?>
                                    <script type="text/javascript">
                                        var idTable = <?php echo json_encode($id_table); ?>;
                                        var url = 'orders.php?id_table=' + encodeURIComponent(idTable);
                                        window.location.href = url;
                                    </script>
                        <?php
                                    exit;
                                } else {
                                    echo "Failed to insert order: " . mysqli_error($conn);
                                }
                            } else {
                                echo "Failed to fetch category: " . mysqli_error($conn);
                            }
                        }
                        ?>

                        <div class="scrollable-table">
                            <table class="table table-striped" id="orderTable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Table No</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Total Price</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($_GET['id_table'])) {
                                        $id = $_GET['id_table'];
                                        $sql = "SELECT * FROM `order` WHERE table_no = $id AND status != 'paid'";
                                        $result = mysqli_query($conn, $sql);
                                        if ($result && mysqli_num_rows($result) > 0) {

                                            $sql = "UPDATE tables SET status = 'reserved' WHERE table_no = $id";
                                            $result1 = mysqli_query($conn, $sql);
                                            if (!$result1) {
                                                echo "Failed: " . mysqli_error($conn);
                                            }

                                            $i = 1;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $total_price = $row['price'] * $row['quantity'];
                                                $bill_amount += $total_price;
                                                $sql = "UPDATE tables SET bill_amount = $bill_amount WHERE table_no = $id";
                                                $result1 = mysqli_query($conn, $sql);
                                                if (!$result1) {
                                                    echo "Failed: " . mysqli_error($conn);
                                                }
                                    ?>
                                                <tr>
                                                    <th scope="row"><?php echo $i++; ?></th>
                                                    <td><?php echo $row['table_no']; ?></td>
                                                    <td><?php echo $row['item_name']; ?></td>
                                                    <td><?php echo $row['quantity']; ?></td>
                                                    <td><?php echo $row['price']; ?></td>
                                                    <td><?php echo $total_price; ?></td>
                                                    <td>
                                                        <a href=""><button type="button" class="btn btn-info">Edit</button></a>
                                                        <a onclick="return confirm('Are you sure?')" href="orders.php?o_id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-danger">Delete</button></a>
                                                    </td>
                                                </tr>
                                    <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='7'>No data found.</td></tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7'>Table ID is missing in the URL.</td></tr>";
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
                                        $id = $row['table_no'];
                                        echo "<script>window.location.href='orders.php?id_table=$id'</script>";
                                        exit(); // Stop script execution
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <h1 class="total-bill">Total Bill Amount = <label class="form-label"><?php echo $bill_amount ?></label></h1>
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
        window.onload = function() {
            var orderTable = document.getElementById('orderTable');
            if (orderTable) {
                orderTable.scrollTop = orderTable.scrollHeight;
            }
        };
    </script>
</body>

</html>