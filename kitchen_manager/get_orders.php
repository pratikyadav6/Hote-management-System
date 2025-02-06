<?php
include '../include/config.php';

if (isset($_GET['id_table'])) {
    $tableId = $_GET['id_table'];
    $sql = "SELECT * FROM `order` WHERE table_no = $tableId and status != 'paid'";
    $result = mysqli_query($conn, $sql);

    $orders = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $orders[] = $row;
        }
    }
    echo json_encode($orders);
} else {
    echo json_encode(['success' => false, 'message' => 'Table ID is missing']);
}

mysqli_close($conn);
?>
