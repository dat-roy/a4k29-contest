<?php require_once './lib/config.php'; ?>
<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Bảng xếp hạng cuộc thi</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="main.css">
	<style>
		.rank-container {
            width: 90%;
            text-align: center;
            background-color: white;
			margin: 40px auto;
			border-radius: 30px;
			border: 1px solid #ffffff;
		}
		table { 
			width: 80%; 
			max-width: 900px;
			border-collapse: collapse; 
			table-layout: auto;
			margin: 50px auto;
			border-radius: 20px;
			box-shadow: rgb(188 188 188 / 60%) 0px 0px 12px;
		}
		th { 
			background-color: #3e9aff;
			color: white; 
			font-weight: bold; 
		}
		td {
			background-color: rgb(255, 255, 255);
		}
		td, th { 
			padding: 20px; 
			text-align: left; 
			font-size: 18px;
		}
		tr {
			border-bottom: 1px dotted #ccc; 
        }
        .in-top3 {
            width: 60px;
        }
		.out-top3 {
			font-size: 16px;
			font-weight: 600;
			margin: 0 12px;
			border-radius: 30px;
			padding: 8px;
			border: 1px solid;
		}
		/*
		________________________
					Popup modal box
		*/
		.body-blackout {
			position: absolute;
			z-index: 1010;
			left: 0;
			top: 0;
			width: 100%;
			min-height: 100%;
			height: var(--contest-container__height);
			margin-top: var(--header-height);
			background-color: rgba(0, 0, 0, 0.65);
			display: none;
		}
		.body-blackout.is-blacked-out {
			display: block;
		}

		.popup-trigger {
			display: inline-block;
			padding: .4rem 1.2rem;
			background-color: #fff;
			color: #39c148;
			border: 2px solid;
			font-size: 14px;
			font-weight: 600;
			border-radius: 30px;
			cursor: pointer;
			text-transform: uppercase;
		}
		
		.popup-modal {
			height: 600px;
			width: 680px;
			background-color: #fff;
			position: absolute;
			left: 50%;
			top: 50%;
			transform: translate(-50%, -50%);
			padding: 45px;
			margin-top: var(--header-height);
			opacity: 0;
			pointer-events: none;
			transition: all 300ms ease-in-out;
			z-index: 1011;
			border-radius: 30px;
			font-size: 18px;
		}
		.popup-modal.is--visible {
			opacity: 1;
			pointer-events: auto;
		}
		.modal-title {
			font-size: 20px;
			text-align: center;
			line-height: 60px;
		}
		.modal-col-wrap {
			display: table; 
			width: 100%; 
			text-align: center;
		}
		.col {
			display: table-cell;
			line-height: 40px;
		}
		.modal-confirm {
			margin-top: 20px;
			line-height: 60px;

			margin: 0 auto;
			text-align: center;
		}
		.confirm-close {
			color: white;
			padding: .6rem 1.7rem;
			border-radius: 30px;
			cursor: pointer;	
			font-size: 18px;
			border: 1px solid var(--warning);
			background-color: var(--warning);
		}
		.total {
			font-size: 20px;
			margin: 15px;
			font-weight: 600;
		}
	</style>
</head>
<body>
	<?php require 'header.php'; ?>    
	<?php 
		/* Kiểm tra kỳ thi đã kết thúc hay chưa */

		$c = $_GET['c'];
		$query = mysqli_query($conn,"SELECT ngay,giobatdau,gioketthuc FROM danhsach_cuocthi WHERE idcuocthi=$c");
		if (mysqli_num_rows($query) > 0) {
		      $row = mysqli_fetch_assoc($query);
			  $date = $row['ngay'];
			  $endTime = $row['gioketthuc'];
		}
		 date_default_timezone_set('Asia/Ho_Chi_Minh');
		 $now = time();

		 $time = $date.' '.$endTime;
		 $time = date_parse_from_format('Y-m-d H:i:s', $time);
		 $end_time_stamp = mktime($time['hour'],$time['minute'],$time['second'],$time['month'],$time['day'],$time['year']);
	 
		 if (($now - $end_time_stamp) < 0){
			echo "<span style='margin-top: 80px; font-size: 20px; font-weight: 600; text-align: center'> BXH chưa được cập nhật do kỳ thi chưa kết thúc. </span>";
		 }
		 else {
			require 'leaderboard_C_inner.php';
		 }
	?>
	<?php //require 'footer.php'; ?>
</body>
</html>