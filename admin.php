<?php session_start() ?>
<html>

<head>
   <title>Admin Page</title>
   <style type="text/css">
      body {
         font-family: Arial, Helvetica, sans-serif;
         font-size: 14px;
      }

      label {
         font-weight: bold;
         width: 100px;
         font-size: 14px;
      }

      .box {
         border: #666666 solid 1px;
      }
   </style>
</head>

<body bgcolor="#FFFFFF">
   <div align="center">
      <div style="width:300px; border: solid 1px #333333; " align="left">
         <div style="background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
         <div style="margin:30px">
            <form action="" method="post">
               <label>UserName :</label><input type="text" name="username" class="box" /><br /><br />
               <label>Password :</label><input type="text" name="password" class="box" /><br /><br />
               <input type="submit" value=" Submit " name="submit" /><br />
            </form>
            <div style="font-size:11px; color:#cc0000; margin-top:10px"></div>
         </div>
      </div>
   </div>
</body>

</html>
<?php
include 'config.php';
$conn = new mysqli("localhost", "root", "", "practice");
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['submit'])) {
   $email = $_POST['username'];
   $password = $_POST['password'];
   $enc = md5($password);
   $sql = "SELECT * FROM login WHERE Email = '$email' and Password = '$enc'";
   //echo $sql; exit;
   $resutl = mysqli_query($conn, $sql);
   $ro = mysqli_num_rows($resutl);
   if ($ro == 1) {
      $row = mysqli_fetch_assoc($resutl);

      $_SESSION['user_email'] = $row['Email'];
      $_SESSION['user_address'] = $row['Address'];
      $_SESSION['user_id'] = $row['id'];
      echo "login completes";
      echo "welcome" . $row['Email'];
      header('location:dash.php');
   } else {
      echo "invalid input";
   }
}

?>