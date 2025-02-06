<?php
session_start();
if (!isset($_SESSION['first_name'])) {
    header('Location: ../login.php');
    exit();
}

include '../include/config.php';

if (isset($_GET['action']) && $_GET['action'] == 'get_new_order_count') {
    $sql = "SELECT COUNT(*) AS new_count FROM `order` WHERE status = 'new'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    echo json_encode(['new_count' => $row['new_count']]);
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
    <title>Kitchen-Manager Dashboard</title>
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

        .card-content h1 {
            margin: 0;
            font-size: 1.5em;
        }

        .card-content h2 {
            margin: 0.5em 0;
        }

        .new-status {
            color: green;
        }

        .processed-status {
            color: blue;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include '../include/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include '../include/navbar.php'; ?>
                <div class="container-fluid">
                    <div class="card-container">
                        <?php
                        include '../include/config.php';
                        $sql = "SELECT table_no, 
                                       SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) AS new_count,
                                       SUM(CASE WHEN status = 'processed' THEN 1 ELSE 0 END) AS processed_count
                                FROM `order` 
                                WHERE status IN ('new', 'processed') 
                                GROUP BY table_no";
                        $result = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($result);

                        if ($count > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <a href="update_orders.php?id_table=<?php echo $row['table_no'] ?>" class="card">
                                    <div class="card-content">
                                        <h1>Table NO <?php echo $row['table_no'] ?></h1>
                                        <h2 class="<?php echo $row['new_count'] > 0 ? 'new-status' : ''; ?>">
                                            <?php echo "New: {$row['new_count']}"; ?>
                                        </h2>
                                        <h2 class="<?php echo $row['processed_count'] > 0 ? 'processed-status' : ''; ?>">
                                            <?php echo "Processed: {$row['processed_count']}"; ?>
                                        </h2>
                                    </div>
                                </a>
                        <?php
                            }
                        } else {
                            echo "<p>No orders found.</p>";
                        }
                        ?>
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

    <script>
        setInterval(function() {
            location.reload();
        }, 5000); 
    </script>
</body>

</html>
