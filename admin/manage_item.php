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

    <title>Manage Items</title>

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <div id="wrapper">
        <?php include '../include/sidebar.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php include '../include/navbar.php' ?>

                <div class="container-fluid">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Item Code</th>
                                <th scope="col">Item Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Category</th>
                                <th scope="col">Order Type</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>

                        <?php
                        include '../include/config.php';
                        $i = 0;
                        $sql = "SELECT * FROM items";
                        $result = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($result);
                        if ($count > 0) {


                            while ($row = mysqli_fetch_assoc($result)) {

                                $i++
                        ?>
                                <tbody>
                                    <tr>
                                        <th scope="row"><?php echo "$i"; ?></th>
                                        <td><?php echo $row['item_code'] ?></td>
                                        <td><?php echo $row['item_name'] ?></td>
                                        <td><?php echo $row['price'] ?></td>
                                        <td><?php echo $row['category'] ?></td>
                                        <td><?php echo $row['o_type'] ?></td>

                                        <td>
                                            <a href=""><button type="button" class="btn btn-info">Edit</button></a>
                                            <a onclick="return confirm('Are you sure?')" href="manage_item.php?id=<?php echo $row['item_code'] ?>"><button type="button" class="btn btn-danger">Delete</button></a>
                                        </td>
                                    </tr>
                                <?php
                            } ?>
                                </tbody>
                            <?php


                        } else {
                            echo " no data Found";
                        }
                            ?>

                    </table>
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

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $sql = "DELETE FROM items WHERE item_code = '$id'";
    $result2 = mysqli_query($conn, $sql);
    if ($result2) {
        echo "<script>alert('Item Deleted')</script>";
    }
    echo "<script>window.location.href='manage_item.php'</script>";
}
?>