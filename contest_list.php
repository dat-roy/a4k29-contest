<?php require_once './lib/config.php'; ?>
<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Danh Sách Cuộc Thi</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="main.css">
	<style>
		.list-container {
			text-align: center;
		}
		table { 
			width: 90%; 
			max-width: 1100px;
			border-collapse: collapse; 
			table-layout: auto;
			margin: 50px auto;
			/*box-shadow: rgba(188, 188, 188, 0.25) 0px 0px 12px;*/
		}
		th {
			background-color: rgb(255, 255, 255);
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
			border: 1px solid #ccc;
		}
		a {
			color: #0068e0d3;
		}
	</style>
</head>
<body>
	<?php require 'header.php'; ?>    
	<div class="list-container">
		<h1 style='font-weight:500; margin-top:50px;'>Danh Sách Cuộc Thi </h1>
		<?php
			if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
				echo "<br><a href='create_C.php' style='padding: 8px 24px; background-color: #2dcf56; color: white; border-radius: 30px; font-size: 14px; font-weight: 500; text-transform: uppercase;'><i style='font-size:20px;'>+</i/> Tạo mới</a>";
			}
		?>
		<table>
			<thead>
 				<tr>
					<th style='color: rgba(0,0,0,0.8)';>Tên kỳ thi</th>
					<th style='color: rgba(0,0,0,0.8)';>Ngày</th>
					<th style='color: rgba(0,0,0,0.8)';>Thời gian</th>
					<th style='color: rgba(0,0,0,0.8)';>Trạng thái</th>
					<th style='color: rgba(0,0,0,0.8)';>Bảng xếp hạng</th>
				</tr>
			</thead>
			<tbody>
					<?php 
						$query = mysqli_query($conn,"SELECT * FROM danhsach_cuocthi ORDER BY idcuocthi DESC");
						while ($row = mysqli_fetch_array($query)){ 
					?>
					<tr>
						<td><a href="contest.php?c=<?php echo $row['idcuocthi']?>"> <?php echo $row['tencuocthi']?></a></td>
						<td><?php echo date_format(date_create($row['ngay']),"d/m/Y"); ?></td>
						<td><?php echo $row['giobatdau']. ' - ' . $row['gioketthuc']?></td>
						<td>
							<?php 
								$date = $row['ngay'];
								$beginTime = $row['giobatdau'];
								$endTime = $row['gioketthuc'];
								 date_default_timezone_set('Asia/Ho_Chi_Minh');
								 $now = time();
								
								 $time = $date.' '.$beginTime;
								 $time = date_parse_from_format('Y-m-d H:i:s', $time);
								 $begin_time_stamp = mktime($time['hour'],$time['minute'],$time['second'],$time['month'],$time['day'],$time['year']);
					
								 $time = $date.' '.$endTime;
								 $time = date_parse_from_format('Y-m-d H:i:s', $time);
								 $end_time_stamp = mktime($time['hour'],$time['minute'],$time['second'],$time['month'],$time['day'],$time['year']);
							 
								 if (($now - $begin_time_stamp) < 0){
									echo "<span style='color:#fb9902; font-weight: 600;'>Sắp diễn ra </span>";
								 }
								 elseif (($now - $end_time_stamp) > 0) {
									 echo "<span style='font-weight: 600;'>Đã kết thúc</span>";
								 }
								 else {
									 echo "<span style='color:#0bde3f; font-weight: 600;'>Đang diễn ra</span>";
								 }
							?>
						</td>
						<td><a href="leaderboard_C.php?c=<?php echo $row['idcuocthi']?>">Click</a></td>
					<?php } ?>
					</tr>
			</tbody>
		</table>
	</div>
	<?php //require 'footer.php'; ?>
</body>
</html>
