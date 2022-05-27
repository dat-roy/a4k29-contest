<?php
$server_username = "epiz_27899825";
$server_password = "lgRehHCDXO";
$server_host = "sql210.epizy.com";
$database = "epiz_27899825_a4k29";

$conn = mysqli_connect($server_host,$server_username,$server_password,$database) or die("Không thể kết nối tới database");
mysqli_query($conn,"SET NAMES 'UTF8'");
?>