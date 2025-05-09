<?php

   $server = "localhost"; 
   $username = "root";
   $password = "";
   $database = "quanlydongho";  

   $conn = new mysqli($server, $username, $password, $database);

   if ($conn->connect_error) {
       die("Kết nối thất bại: " . $conn->connect_error);  
   }

   $kq = "Đã kết nối thành công vào cơ sở dữ liệu";  
  

?>