<?php
require_once './lib/config.php';
session_start();

$p = $_GET['p'];
/*--------------------*/

$query = mysqli_query($conn,"SELECT socauhoi,dapan FROM danhsach_luyentap WHERE idluyentap=$p");
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
$query = mysqli_query($conn,"SELECT * FROM ketqua_luyentap_$p WHERE idthisinh=$userid");
if (mysqli_num_rows($query) == 0) {

    $sql = " INSERT INTO ketqua_luyentap_$p (idthisinh, bailam, thoigiannop)
            VALUES ($userid,'$res_str', '$time') ";
    executeSQL($conn,$sql);
}
else {
    $sql = " UPDATE ketqua_luyentap_$p
                SET bailam='$res_str', thoigiannop='$time'
                WHERE idthisinh=$userid ";
    executeSQL($conn,$sql);
}

?>