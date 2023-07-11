<?php
// Thông tin kết nối đến database
$host = "localhost";
$dbname = "db_trochoiviet";
$dsn = "mysql:host=$host;dbname=$dbname";
$username = "root";
$password = "";

// Tạo kết nối
$connection = new PDO($dsn, $username, $password);