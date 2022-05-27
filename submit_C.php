<?php
require_once './lib/config.php';
session_start();

$c = $_GET['c'];
/*----------------------*/
function isTimeOut ($conn,$c) {
   $query = mysqli_query($conn,"SELECT ngay,gioketthuc FROM danhsach_cuocthi WHERE idcuocthi=$c");
   if (mysqli_num_rows($query) > 0) {
      while ($row = mysqli_fetch_assoc($query)) {
         $date = $row['ngay'];
         $endTime = $row['gioketthuc'];
      }
   }
   date_default_timezone_set('Asia/Ho_Chi_Minh');
   $now = time();

   $time = $date.' '.$endTime;
   $time = date_parse_from_format('Y-m-d H:i:s', $time);
   $end_time_stamp = mktime($time['hour'],$time['minute'],$time['second'],$time['month'],$time['day'],$time['year']);

   if (($now - $end_time_stamp) > 0) 
      return true;
   else return false;
}
/*--------------------*/

function completeSubmit($conn,$c) {

   $query = mysqli_query($conn,"SELECT socauhoi,dapan FROM danhsach_cuocthi WHERE idcuocthi=$c");
   $res_str = '';

   if (mysqli_num_rows($query) > 0) {

      $row = mysqli_fetch_assoc($query);
      for ($i = 1; $i <= $row['socauhoi']; $i++) {

         if (isset($_POST["$i"])) {
            $res_str .= $_POST["$i"];
         }
         else $res_str .= '?';

      }
   }          

   function getUserID($conn, $username) {
      $sql_select = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' ");
      $sql_result = mysqli_fetch_assoc($sql_select);
      return $sql_result['id'];
   }

   function executeSQL($conn,$sql) {
      if (mysqli_query($conn, $sql)) {
         echo <<<EOD
            <div style="color:#28a745;"><b>Nộp bài thành công!</b></div>
         EOD;
      }
      else {
            echo <<<EOD
            <div style="color:#dc3545;"><b>Có lỗi đã xảy ra! Hãy thử nộp lại!</b></div>
            EOD;
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
   }

   $username = mysqli_real_escape_string($conn,stripslashes($_SESSION['username']));
   $userid = getUserID($conn, $username);
   date_default_timezone_set('Asia/Ho_Chi_Minh');
   $time =  date("H:i:s");

   $query = mysqli_query($conn,"SELECT * FROM ketqua_cuocthi_$c WHERE idthisinh=$userid");
   if (mysqli_num_rows($query) == 0) {

      $sql = " INSERT INTO ketqua_cuocthi_$c (idthisinh, bailam, thoigiannop)
               VALUES ($userid,'$res_str', '$time') ";
      executeSQL($conn,$sql);
   }
   else {
      $sql = " UPDATE ketqua_cuocthi_$c
                  SET bailam='$res_str', thoigiannop='$time'
                  WHERE idthisinh=$userid ";
      executeSQL($conn,$sql);
   }
}


if (isTimeOut($conn,$c)) {
   echo "<div style='color:#dc3545;'><b>Thời gian đã hết. Bạn không thể nộp bài!</b></div>";
}
else
   completeSubmit($conn,$c);
?>