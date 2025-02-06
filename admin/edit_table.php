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
    <title>Add Table </title>
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
                            <?php
                            include '../include/config.php';
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                                $sql = "SELECT * FROM tables WHERE table_no=$id";
                                $result = mysqli_query($conn, $sql);
                                $row=mysqli_fetch_assoc($result);
                                if ($count = mysqli_num_rows($result) == 1) {
                            ?>
                                    <form action="" method="post">
                                        <div class="d-flex p-2 bd-highlight">
                                            <div class="col-12">
                                                <label for="firstName" class="form-label">Table No<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="tableno" id="tableno" placeholder="Table No" value="<?php echo $row['table_no'] ?>" required>
                                            </div>
                                            <div class="col-12">
                                                <!-- <label for="lastName" class="form-label">Table Strength <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="table_strength" id="table_strength" placeholder="Enter Table strength" required> -->
                                                <div class="col-12">
                                                    <label for="type" class="form-label">Select Strength of Table <span class="text-danger">*</span></label>
                                                    <select class="form-select" name="table_strength" aria-label=".form-select-lg example" required>
                                                        <option value="<?php echo $row['table_strength'] ?>"><?php echo $row['table_strength'] ?></option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex p-2 bd-highlight">

                                            <div class="col-12">
                                                <label for="type" class="form-label">Select Floor <span class="text-danger">*</span></label>
                                                <select required class="form-select" name="floor" aria-label=".form-select-lg example">
                                                    <option value="<?php echo $row['floor'] ?>"><?php echo $row['floor'] ?></option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button class="btn bsb-btn-xl btn-primary" name="submit" type="submit">Add Table</button>
                                            </div>
                                        </div>
                                    </form>
                            <?php

                                }
                            }
                            ?>
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
    $table_no = $_POST['tableno'];
    $table_strength = $_POST['table_strength'];
    $floor = $_POST['floor'];
    echo $table_no;

    $check_table = "SELECT * FROM tables where table_no = $table_no ";
    $result = mysqli_query($conn, $check_table);
    $count = mysqli_num_rows($result);

    if ($count == 1) {

        echo '<script>alert("Table Edited succesfully ");</script>';
        $sql="UPDATE tables SET table_no= '$table_no',table_strength='$table_strength',floor='$floor' Where table_no=$table_no";
        // $sql = "INSERT INTO tables (table_no,table_strength,floor,status) values ('$table_no','$table_strength','$floor','unreserved')";
        $result1 = mysqli_query($conn, $sql);
        // $count = mysqli_num_rows($result1);
        
    } else {
        
        echo "<script>alert('table aready exist')</script> ";
    }
    echo "<script>window.location.href='manage_table.php'</script>";
    // header('location:manage_table.php');
}
?>