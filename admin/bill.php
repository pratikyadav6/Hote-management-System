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
$table_bill_no=0;
$id = $_GET['id_table'];
$items = $conn->query("SELECT SUM(quantity) as quantity, item_name, price FROM `order` WHERE table_no = $id AND status != 'paid' GROUP BY item_name;");
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
<?php
   if(isset($_GET['id_table'])){

        $id=$_GET['id_table'];
        $sql="SELECT order_no from tables where table_no=$id";
        $result=mysqli_query($conn,$sql);
        $count=mysqli_num_rows($result);
        if($count==1)
        {
            $row=mysqli_fetch_assoc($result);
            $table_bill_no=$row['order_no']+1;

        }

   }
?>
<div class="container-fluid">
    <p class="text-center"><b><?php echo "HOTEL " ?></b></p>
    <hr>
    <div class="flex">
        <div class="w-100">
            <p>Invoice Number: <b><?php echo "1__" ?></b></p>
            <p>Table No.: <b><?php echo $_GET['id_table'] ?></b></p>
            <p>Table Order No.: <b><?php echo $table_bill_no ?></b></p>
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
            $total_amount = 0;
            $t_amount = 0;
            $tax_amt = 0;
            $total_bill_amount = 0;

            while ($row = $items->fetch_assoc()) :
            ?>
                <tr>
                    <td><?php echo $row['item_name'] ?></td>
                    <td>
                        <p><?php echo $row['quantity'] ?></p>
                    </td>
                    <td><?php echo $row['price'] ?></td>
                    <?php $t_amount = 0;
                    $t_amount = $row['price'] * $row['quantity'];
                    ?>
                    <td class="text-right"><?php echo number_format($t_amount, 2) ?></td>
                    <?php $total_amount = $total_amount +  $t_amount;
                    ?>
                </tr>
            <?php endwhile;
            $tax_amt = $total_amount * (5 / 100) ?>
        </tbody>
    </table>
    <hr>
    <table width="100%">
        <tbody>
            <tr>
                <td>Total Amount</td>
                <td class="text-right"><b><?php echo number_format($total_amount, 2) ?></b></td> <br>
            </tr>
            <tr>
                <td>Total Amount Tax (%)</td>
                <?php
                $total_bill_amount = $total_amount + $tax_amt;
                ?>
                <td class="text-right"><b><?php echo number_format($tax_amt, 2) ?></b></td>
            </tr>

        </tbody>
    </table>
    <hr>
    <table width="100%">
        <tbody>
            <tr>
                <td>Total Bill Amount</td>
                <td class="text-right"><b><?php echo number_format($total_bill_amount, 2) ?></b></td> <br>
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
<script>
    window.onload = function() {
        window.print();
    };

    window.onafterprint = function() {
        // Make an AJAX call to update the order status and bill amount
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "invoice.php?id_table=<?php echo $id; ?>", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                window.location.href = "invoice.php?id_table=<?php echo $id; ?>";
            }
        };
        xhr.send();
    };
</script>