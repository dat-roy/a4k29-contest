<?php require_once './lib/config.php'; ?>
<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tạo Bài Luyện Tập Mới</title>
    <link rel="stylesheet" href="main.css">
    <style>
            * {
                color: #333;
                font-size: 20px;
                margin: 10px;

            }
            h1 {
                font-size: 30px;
                padding: 20px;
            }
            h2 {
                font-size: 24px;
                padding: 20px;
            }
            form {
                margin: 0 auto;
                width: 680px;
                border: 1px dotted #333;
                border-radius: 20px;
                padding: 20px;
            }
            input[type='text'],
            input[type='date'],
            input[type='time'],
            input[type='number'] {
                width: 400px;
                margin: 0;
            }
            label {
                width: 200px;
                display: inline-block;
            }
            input[type='button'],
            input[type='submit'] {
                padding: 6px 30px;
                border-radius: 10px;
                display: inline-block;
                margin: 20px 10px;
                cursor: pointer;
            }
            p,
            input[type='file'] {
                display: inline-block;
                margin: 0px;
            }
            input[type='radio'] {
                width: 20px;
                height: 20px;
                margin: 10px 25px;
            }
    </style>
</head>
<body>
    <?php
        if (isset($_SESSION['username']) && $_SESSION['username'] && isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
            require 'create_P_inner.php';
        }
        else 
            echo 'CẢNH BÁO: BẠN KHÔNG CÓ QUYỀN TRUY CẬP TỪ ADMIN'
    ?>

</body>
</html>