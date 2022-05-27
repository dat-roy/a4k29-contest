<?php require_once './lib/config.php'; ?>
<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Chức Năng Học Tập (by levietdat)</title>
    <meta charset="UTF-8">
    
	<link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" type="text/css" href="contest.css">
</head>
<body>
	<?php require './header.php'; ?>    
    <?php 
            /* Kiểm tra thời gian của bài luyện tập */

            $p = $_GET['p'];
            $query = mysqli_query($conn,"SELECT ngay,giobatdau,gioketthuc FROM danhsach_luyentap WHERE idluyentap=$p");
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
         
            /*---- Quy Ước: 0 (chưa diễn ra); 1 (đang diễn ra); 2 (đã kết thúc) ----*/
            $STATUS = 0;        

             if (($now - $begin_time_stamp) < 0) 
                $STATUS = 0;
             elseif (($now - $end_time_stamp) > 0)
                $STATUS = 2;     
             else
                $STATUS = 1;

            if ($STATUS == 0) 
                echo "<span style='margin-top: 80px; font-size: 20px; font-weight: 600; text-align: center'>Bài này chưa mở bạn nhé. Vui lòng quay lại sau. </span>";
            else {
                /* Kiểm tra đăng nhập */                
                if (isset($_SESSION['username']) && $_SESSION['username']) {
                    require 'practice_inner.php';
                }
                else 
                    require './lib/login_require.php';
            }        
    ?>

	<?php //require 'footer.php'; ?>
</body>
</html>