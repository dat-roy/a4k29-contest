<?php require_once './lib/config.php'; ?>
<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Chức Năng Thi Thử (by levietdat)</title>
    <meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="main.css">
	<link rel="stylesheet" type="text/css" href="contest.css">
</head>
<body>
	<?php require './header.php'; ?>    
    <?php 
            /* Kiểm tra thời gian của kỳ thi */

            $c = $_GET['c'];
            $query = mysqli_query($conn,"SELECT ngay,giobatdau,gioketthuc FROM danhsach_cuocthi WHERE idcuocthi=$c");
            if (mysqli_num_rows($query) > 0) {
               while ($row = mysqli_fetch_assoc($query)) {
                  $date = $row['ngay'];
                  $beginTime = $row['giobatdau'];
                  $endTime = $row['gioketthuc'];
               }
            }
             date_default_timezone_set('Asia/Ho_Chi_Minh');
             $now = time();
            
             $time = $date.' '.$beginTime;
             $time = date_parse_from_format('Y-m-d H:i:s', $time);
             $begin_time_stamp = mktime($time['hour'],$time['minute'],$time['second'],$time['month'],$time['day'],$time['year']);

             $time = $date.' '.$endTime;
             $time = date_parse_from_format('Y-m-d H:i:s', $time);
             $end_time_stamp = mktime($time['hour'],$time['minute'],$time['second'],$time['month'],$time['day'],$time['year']);
         
             if (($now - $begin_time_stamp) < 0){
                echo "<span style='margin-top: 80px; font-size: 20px; font-weight: 600; text-align: center'>Cuộc thi này chưa diễn ra. Vui lòng quay lại sau. </span>";
             }
             elseif (($now - $end_time_stamp) > 0) {
                 echo  
                    "<span style='margin-top: 80px; font-size: 20px; font-weight: 600; text-align: center'>Cuộc thi này đã kết thúc. Bạn không thể nộp bài. </span>";
             }
             else {
                /* Kiểm tra đăng nhập */                
                if (isset($_SESSION['username']) && $_SESSION['username']) {
                    require 'contest_inner.php';
                }
                else 
                    require './lib/login_require.php';
             }
    ?>

	<?php //require 'footer.php'; ?>
</body>
</html>