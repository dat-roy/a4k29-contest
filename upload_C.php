<?php require_once './lib/config.php'; ?>
<?php session_start(); ?>
<?php
	if (isset($_POST["btn_submit"])) {	

        $tencuocthi = $_POST['tencuocthi'];
        $ngay = $_POST['ngay'];
        $giobatdau = $_POST['giobatdau'].':00';
        $gioketthuc = $_POST['gioketthuc'].':00';
        $sotrang = $_POST['sotrang'];
        $socauhoi = $_POST['socauhoi'];
        $dapan = '';

        $query = mysqli_query($conn,"SELECT * FROM danhsach_cuocthi");
        $stt = mysqli_num_rows($query) + 1;

        $dir = "assets/contest/contest_".$stt;
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        for ($i=1; $i<=$sotrang; $i++) {
            $target_dir = $dir."/";
            if ($_FILES['trang_'.$i]['error'] > 0)
            {
                $fileError = 1;
            }
            else{
                move_uploaded_file($_FILES['trang_'.$i]['tmp_name'], $target_dir. '(' . $i .').jpg');
                $fileError = 0;
            }
        }
        
        for ($i = 1; $i <= $socauhoi; $i++) {
            $dapan .= $_POST["$i"];
        }

        $query = " INSERT INTO danhsach_cuocthi (idcuocthi, tencuocthi, ngay, giobatdau, gioketthuc, sotrang, socauhoi, dapan) 
                        VALUES ($stt, '$tencuocthi', '$ngay', '$giobatdau', '$gioketthuc', $sotrang, $socauhoi, '$dapan') ";
        if (mysqli_query($conn, $query)) {

            $sql = "CREATE TABLE ketqua_cuocthi_$stt ( 
                            idthisinh INT(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                            bailam VARCHAR(100) NULL,
                            thoigiannop TIME NULL,
                            ketquacham VARCHAR(100) NULL,
                            socaudung INT(100) NULL
                        ) ENGINE = MyISAM";

            if (mysqli_query($conn, $sql)) {
                $sqlError = 0;
            }
            else { 
                $sqlError = 1;
                echo mysqli_error($conn);
            }

        }
        else {
            $sqlError = 1;
        }

        if ($fileError == 0 && $sqlError == 0) {
            echo "ĐÃ UPLOAD THÀNH CÔNG. <a href='index.php'>TRỞ VỀ </a>";
        }
        elseif ($fileError == 1) {
            echo 'Lỗi Upload File!';
        }
        elseif ($sqlError == 1) {
            echo 'Lỗi Kết Nối Tới Database!';
        }
	}
?>