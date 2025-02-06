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
    <title>Add Item</title>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    
</head>

<body id="page-top">
    <div id="wrapper">

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php include '../include/navbar.php' ?>


                <div class="container-fluid">

                    <div class=" col-12 col-md-6 bsb-tpl-bg-lotion">
                        <div class="p-3 p-md-4 p-xl-5">

                            <form action="" method="post">
                                <div class="d-flex p-2 bd-highlight">
                                    <div class="col-12">
                                        <label for="itemName" class="form-label">Item Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="itemName" id="itemName" placeholder="item Name" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="itemcode" class="form-label">Item Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="itemcode" id="itemcode" placeholder="Enter Item code" required>
                                    </div>
                                </div>
                                <div class="d-flex p-2 bd-highlight">

                                    <div class="col-12">
                                        <label for="description" class="form-label">description <span class="text-danger">*</span></label>
                                        <input type="textbox" class="form-control" name="description" id="description" placeholder="Enter a description" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="price" id="price" value="" required>
                                    </div>
                                </div>
                                <div class="d-flex p-2 bd-highlight">

                                    <div class="col-12">
                                        <label for="catagory" class="form-label">Select Category <span class="text-danger">*</span></label>
                                        <select class="form-select" name="category" aria-label=".form-select-lg example" required>
                                            <option value="">Select Type</option>
                                            <?php
                                            include '../include/config.php';
                                            $i = 0;
                                            $sql = "SELECT * FROM categories";
                                            $result = mysqli_query($conn, $sql);
                                            $count = mysqli_num_rows($result);
                                            if ($count > 0) {


                                                while ($row = mysqli_fetch_assoc($result)) {

                                                    $i++
                                            ?>
                                                    <option value="<?php echo $row['category'] ?>"><?php echo $row['category'] ?></option>
                                            <?php
                                                }
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                    <label for="catagory" class="form-label">Select Order Type <span class="text-danger">*</span></label>
                                        <select class="form-select" name="o_type" aria-label=".form-select-lg example" required>
                                            <option value="">Select Type</option>
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
                                                    <option value="<?php echo $row['o_type'] ?>"><?php echo $row['o_type'] ?></option>
                                            <?php
                                                }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn bsb-btn-xl btn-primary" name="submit" type="submit">Add Item</button>
                                    </div>
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
    $itemName = $_POST['itemName'];
    $itemcode = $_POST['itemcode'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $o_type = $_POST['o_type'];

    $sql = "SELECT * FROM items WHERE item_code = '$itemcode' ";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);


    if ($count == 0) {
        echo '<script>alert("  item Added in system");</script>';
        $sql = "INSERT INTO items(item_code,item_name,description,price,category,o_type) values ('$itemcode','$itemName','$description','$price','$category','$o_type')";
        $result = mysqli_query($conn, $sql);
    } else {

        echo '<script>alert(" item exist")</script> ';
        // $count = mysqli_num_rows($result1);
    }
}
