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

    <title>Staff-Dashboard</title>

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
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
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
            overflow: hidden;
            transition: transform 0.2s;
            width: 100%;
        }

        .card:hover {
            transform: scale(1.05);
        }

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

        .reserved {
            color: red;
        }

        .unreserved {
            color: green;
        }
    </style>
</head>

<body id="page-top">
    <?php include '../include/navbar.php' ?>
    <div id="wrapper">
        <?php
        // include '../include/sidebar.php'
        ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <form action="" method="post">
                        <select class="form-select" aria-label="Default select example" name="floor" onchange="this.form.submit()" required>
                            <option value="<?php echo isset($_POST['floor']) ? htmlspecialchars($_POST['floor']) : ''; ?>">
                                <?php echo isset($_POST['floor']) ? htmlspecialchars($_POST['floor']) : 'Select Floor'; ?>
                            </option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </form>
                    <div class="card-container">
                        <?php
                        include '../include/config.php';
                        $s = "UPDATE tables SET status = 'unreserved'  WHERE table_no Not In (Select DISTINCT table_no from `order` where status !='paid' )";
                        $result3 = mysqli_query($conn, $s);
                        if (!$result3) {
                            echo "Failed: " . mysqli_error($conn);
                        }
                        ?>
                        <?php
                        if (isset($_POST['floor'])) {
                            $i = 0;
                            $floor = $_POST['floor'];
                            $sql = "SELECT * FROM tables where floor= $floor";
                            $result = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($result);
                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $i++;
                        ?>
                                    <a href="../staff/orders.php?id_table=<?php echo $row['table_no'] ?>" class="card">
                                        <div class="card-content">
                                            <h2>Table NO <?php echo $row['table_no'] ?> </h2>
                                            <h2 class="<?php echo $row['status'] ?>">
                                                <?php echo  $row['status']; ?>
                                            </h2>
                                        </div>
                                    </a>
                        <?php
                                }
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