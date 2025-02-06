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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Order Type</title>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include '../include/sidebar.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php include '../include/navbar.php' ?>


                <div class="container-fluid">

                    <div class=" col-12 col-md-6 bsb-tpl-bg-lotion">
                        <div class="p-3 p-md-4 p-xl-5">

                            <form action="" method="post">

                                <div class="d-flex p-2 bd-highlight">

                                    <label for="category" class="form-label"> Order Type Name<span class="text-danger">*</span></label>
                                </div>
                                <div class="d-flex p-2 bd-highlight">
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="o_type" id="o_type" placeholder="category Name" required>
                                    </div>

                                    <div class="col-12">
                                        <div>
                                            <button class="btn bsb-btn-xl btn-primary" name="submit" type="submit">Add Order Type</button>
                                        </div>
                                    </div>

                                </div>
                                <div class="d-flex p-2 bd-highlight">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Order Type Name</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>

                                        <?php
                                        include '../include/config.php';
                                        $i = 0;
                                        $sql = "SELECT * FROM order_type";
                                        $result = mysqli_query($conn, $sql);
                                        $count = mysqli_num_rows($result);
                                        if ($count > 0) {


                                            while ($row = mysqli_fetch_assoc($result)) {

                                                $i++
                                        ?>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row"><?php echo "$i"; ?></th>
                                                        <td><?php echo $row['o_type'] ?></td>
                                                        <td>
                                                            <a onclick="return confirm('Are you sure?')" href="add_order_type.php?id=<?php echo $row['id'] ?>"><button type="button" class="btn btn-danger">Delete</button></a>
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

                                    <!-- <div class="col-12">
                                        <label for="description" class="form-label">description <span class="text-danger">*</span></label>
                                        <input type="textbox" class="form-control" name="description" id="description" placeholder="Enter a description" required>
                                    </div>-->
                                    <!-- <div style="align-items: center;">

                                        <div class="col-12">
                                            <label for="price" class="form-label">Price </label><br>
                                            <label for="price" class="form-label">Price </label><br>
                                            <label for="price" class="form-label">Price </label><br>
                                            <label for="price" class="form-label">Price </label><br>
                                            <label for="price" class="form-label">Price </label><br>
                                            <label for="price" class="form-label">Price </label><br>

                                        </div>
                                    </div> -->
                                </div>


                            </form>

                        </div>
                    </div>

                </div>




            </div>

        </div>

    </div>



    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>
</body>

</html>
<?php

include '../include/config.php';

if (isset($_POST['submit'])) {
    $category = $_POST['o_type'];

    $sql = "SELECT * FROM order_type WHERE o_type = '$category' ";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);


    if ($count == 0) {
        echo '<script>alert(" Type Added ");</script>';
        $sql = "INSERT INTO order_type values (null,'$category')";
        $result = mysqli_query($conn, $sql);
        echo "<script>window.location.href='add_order_type.php'</script>";

    } else {

        echo '<script>alert(" Type exist")</script> ';
        // $count = mysqli_num_rows($result1);
    }
}
if(isset($_GET['id'])){

    $id=$_GET['id'];
    $sql="DELETE FROM order_type WHERE id= '$id'  ";
    $result2 = mysqli_query($conn, $sql);
    if ($result2) {
        echo "<script>alert('Type Deleted')</script>";
    }
    echo "<script>window.location.href='add_order_type.php'</script>";
}

