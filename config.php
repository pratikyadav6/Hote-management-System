<?php

 $conn= mysqli_connect('localhost','root','','rms');
 if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
  
?>