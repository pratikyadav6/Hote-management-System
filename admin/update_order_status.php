<?php
include '../include/config.php';

if (isset($_POST['submit'])) {
    if (isset($_GET['id_table'])) {
        $id = $_GET['id_table'];
        $bill_amount = 0;
        $staff_id = 0;
        $order_no = 0;

        // Fetch bill amount from tables
        $table = "SELECT * FROM tables WHERE table_no = $id";
        $t_result = mysqli_query($conn, $table);
        if ($t_result && mysqli_num_rows($t_result) == 1) {
            $row = mysqli_fetch_assoc($t_result);
            $bill_amount = $row['bill_amount'];
        }

        // Fetch staff ID from orders
        $bill = "SELECT DISTINCT s_id FROM `order` WHERE table_no = $id AND status != 'paid'";
        $b_result = mysqli_query($conn, $bill);
        if ($b_result && mysqli_num_rows($b_result) > 0) {
            $row = mysqli_fetch_assoc($b_result);
            $staff_id = $row['s_id'];
        }

        // Get order details from POST request
        $order_type = mysqli_real_escape_string($conn, $_POST['ordertype']);
        $payment_type = mysqli_real_escape_string($conn, $_POST['type']);
        $cash_received = isset($_POST['cashReceived']) ? mysqli_real_escape_string($conn, $_POST['cashReceived']) : 0;
        $changeDue = isset($_POST['changeDue']) ? mysqli_real_escape_string($conn, $_POST['changeDue']) : 0;
        $discount = isset($_POST['discount']) ? mysqli_real_escape_string($conn, $_POST['discount']) : 0;

        $sql = "SELECT order_no From tables WHERE table_no = $id";
        $table = mysqli_query($conn, $sql);

        if ($table) {
            $row = mysqli_fetch_assoc($table);
            $order_no = $row['order_no'] + 1;
        } else {
            echo "Failed: " . mysqli_error($conn);
        }


        // Insert into bill table
        $bill_query = "INSERT INTO bill (table_no, bill_amount, staff_id, order_type, payment_type, cash_received, change_due, discount,order_no) VALUES ($id, $bill_amount, $staff_id, '$order_type', '$payment_type', $cash_received, $changeDue, $discount,$order_no)";
        $bill_result = mysqli_query($conn, $bill_query);
        if (!$bill_result) {
            echo "ERROR WHILE INSERTING RECORDS: " . mysqli_error($conn);
            echo $order_no;
            exit;
        }


        // Update order status to 'paid'
        $sql = "UPDATE `order` SET status = 'paid',order_no= $order_no WHERE table_no = $id and status!='paid'";
        $result1 = mysqli_query($conn, $sql);
        if (!$result1) {
            echo "Failed: " . mysqli_error($conn);
            exit;
        }

        // Update table status to 'unreserved' and reset bill amount
        $sql = "UPDATE tables SET bill_amount = 0, status = 'unreserved',order_no=$order_no WHERE table_no = $id";
        $result1 = mysqli_query($conn, $sql);
        if (!$result1) {
            echo "Failed: " . mysqli_error($conn);
            exit;
        }

        // header("Location: invoice.php?id_table=" . $id); 
        header("Location:all_bill.php"); 

        exit;
    }
}
