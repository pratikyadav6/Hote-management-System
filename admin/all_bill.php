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

    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .div1 {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            padding: 16px;
        }

        .card {
            display: block;
            text-decoration: none;
            color: inherit;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* cursor: pointer; */
            width: 50vh;
            overflow: hidden;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        /* .card-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        } */

        .card-content {
            padding: 16px;
        }

        .card-content h2 {
            margin: 0;
            font-size: 1.5em;
        }

        .card-content p {
            color: #666;
            margin-top: 8px;
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

                    <form action="" method="post"> <input type="number" name="table_no" placeholder="Enter Table No "></form>
                    <?php

                    if (isset($_POST['table_no'])) {
                        $id = $_POST['table_no'];
                        $sql = "SELECT DISTINCT table_no from `order` WHERE table_no=$id and status!='paid' ";
                        $result = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($result);
                        if ($count > 0) {

                            echo "<script>window.location.href='invoice.php?id_table=$id'</script>";
                        } else { ?>
                            <P style="color: red;"> Table not Found</P>
                    <?php
                        }
                    }
                    ?>

                    <div class="card-container">
                        <?php
                        $s ="UPDATE tables SET status='unreserved',bill_amount =0  WHERE table_no Not In (Select DISTINCT table_no from `order` where status !='paid' )";
                        $result3 = mysqli_query($conn,$s);
                        if (!$result3) {
                            echo "Failed: " . mysqli_error($conn);
                        }
                        $i = 0;
                        $sql = "SELECT * FROM tables Where status='reserved' ";
                        $result = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($result);
                        if ($count > 0) {


                            while ($row = mysqli_fetch_assoc($result)) {

                                $i++
                        ?>

                                <a href="../admin/invoice.php?id_table=<?php echo $row['table_no'] ?>" class="card">
                                    <div class="card-content">
                                        <h2>Table NO <b><?php echo $row['table_no'] ?></b> </h2>
                                        <!--  -->
                                        <h1 style="color: green;"> Bill : <span style="color: red;"><?php echo  number_format($row['bill_amount'], 2) ?></span></h1>
                                    </div>
                                </a>
                        <?php
                            }
                        } ?>
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
</body>

</html>