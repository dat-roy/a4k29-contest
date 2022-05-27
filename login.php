<?php 
	session_start();
	require_once("./lib/config.php");

	if (isset($_POST["btn_submit"])) {	
		$username = $_POST["username"];
		$password = $_POST["password"];

		// làm sạch thông tin, xóa bỏ các tag html, ký tự đặc biệt 
		$username = strip_tags($username);
		$username = addslashes($username);
		$password = strip_tags($password);
		$password = addslashes($password);

		if ($username == "" || $password =="") {
			echo "Username hoặc password bạn không được để trống!";
		}
		else {
			$query = mysqli_query($conn,"SELECT * FROM user WHERE username = '$username' AND password = '$password' ");
			if (mysqli_num_rows($query)==0) {
				echo "Tên đăng nhập hoặc mật khẩu không chính xác!";
			}
			else {
				// Lưu info vào session
				$_SESSION['username'] = $username;
				$row = mysqli_fetch_assoc($query);
				$_SESSION['admin'] = $row['isadmin'];
				
				header('Location: index.php');
    			die();	
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Đăng Nhập</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="main.css">
	<style>
		body {
			background: #beffff;
			display: flex;
			justify-content: center;
			align-items: center;
			flex-direction: column;
			height: 100vh;
		}
		.container{
			width: 450px;
			background-color: white;
			border-radius: 10px;
			box-shadow: 0 0 15px 0 rgba(0,0,0,.1);
			display: flex;
			justify-content: center;
			align-items: center;
			flex-direction: column;
		}
		form {
			width: 350px;
		}
		h2 {
			font-weight: bold;
			color: #03c0c0;
			text-transform: uppercase;
		}
		input[type='text'],
		input[type='password']
		{
			background-color: #eee;
			border: none;
			padding: 14px 30px;
			margin: 8px 0;
			width: 100%;
			border-radius: 20px;
			font-size: 16px;
		}
		input::placeholder {
			color: #adaaaa;
			font-size: 16px;
		}
		.login-header,
		.inp-submit {
			text-align: center;
		}
		.login-header,
		.inp-submit {
			padding: 50px 0;
		}
		.inp-username,
		.inp-password {
			padding: 10px 0;
		}
		span {
			font-weight: 300;
			color: #343a40;
		}
		.btn-login {
			border-radius: 20px;
			border: 1px solid  #56c6c6;
			background-color:  #56c6c6;
			color: #FFFFFF;
			font-size: 12px;
			font-weight: bold;
			padding: 12px 50px;
			letter-spacing: 1px;
			text-transform: uppercase;
			cursor: pointer;
		}

	</style>
</head>

<body>
<div class="container">
<form action='login.php' method='POST'>
		<div class="login-header">
			<h2>Đăng Nhập</h2>
		</div>

		<div class="inp-username">
			<input type="text" name="username" placeholder="username" required>
		</div>

		<div class="inp-password">
			<input type="password" name="password" placeholder="password" required>
		</div>

		<div class="inp-submit">
			<input type="submit" name="btn_submit" value="Login" class="btn-login" style="font-size: 16px;">
		</div>
<form> 
</div>

</body>
</html>