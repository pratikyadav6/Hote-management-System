<?php
// session_start();
if (!isset($_SESSION['first_name'])) {
    // If the session variable 'first_name' is not set, redirect to login page
    header('Location: ../login.php');
    exit(); // Stop further script execution
}
?>
<?php
include '../include/config.php';
$total_bill_amount = 0;
$date = $_GET['date'];
$sql = "SELECT SUM(quantity) as quantity, table_no, item_name, price, id FROM `order` WHERE DATE(date) = ? GROUP BY item_name;";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 's', $date);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<style>
    .flex {
        display: inline-flex;
        width: 100%;
    }

    .w-50 {
        width: 50%;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    table.wborder {
        width: 100%;
        border-collapse: collapse;
    }

    table.wborder>tbody>tr,
    table.wborder>tbody>tr>td {
        border: 1px solid;
    }

    p {
        margin: unset;
    }
</style>
<div class="container-fluid">
    <b style="align-items: center;"><?php echo "HOTEL Sales Report of : " ?> <?php echo $date ?> </b>
    <hr>
    <div class="flex">
        <div class="w-100">
            <p>Invoice Number: <b><?php echo "1__" ?></b></p>
            <p>Date: <b><?php echo date("M d, Y"); ?></b></p>
        </div>
    </div>
    <hr>
    <p><b>Order List</b></p>
    <table width="100%">
        <thead>
            <tr>
                <td><b>Item</b></td>
                <td><b>QTY</b></td>
                <td><b>Price</b></td>
                <td class="text-right"><b>Amount</b></td>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) :
                $t_amount = $row['price'] * $row['quantity'];
                $total_bill_amount += $t_amount;
            ?>
                <tr>
                    <td><?php echo $row['item_name'] ?></td>
                    <td><?php echo $row['quantity'] ?></td>
                    <td><?php echo $row['price'] ?></td>
                    <td class="text-right"><?php echo number_format($t_amount, 2) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <hr>
    <table width="100%">
        <tbody>
            <tr>
                <td>Total Bill Amount</td>
                <td class="text-right"><b><?php echo number_format($total_bill_amount, 2) ?></b></td>
            </tr>
        </tbody>
    </table>
    <hr>
    <br> 
    <br>
    <br>

    <p>This Software is created By Pratik Yadav YP </p><br>
    <p>Contact - +91 9172350209</p>
</div>
<!-- <script>
    window.onload = function() {
        window.print();
    };

    window.onafterprint = function() {
        // Optionally close the window after printing
        window.close();
    };
</script> -->
