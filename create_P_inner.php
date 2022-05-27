<h1 style='text-align: center;'>Tạo Bài Luyện Tập Mới:</h1>
<form action="upload_P.php" method = "POST" enctype="multipart/form-data">
        <h2 id='buoc1'> Bước 1: </h2>
        <label for="tenbailuyentap">Nhập tên bài: </label><input type="text" placeholder = "Tên bài" name="tenbailuyentap" id="tenbailuyentap" required>
        <br>
        <label for="ngay">Chọn ngày diễn ra: </label><input type="date" name="ngay" id="ngay" required>
        <br>
        <label for="giobatdau">Giờ bắt đầu: </label><input type="time" name="giobatdau" id="giobatdau" required>
        <br>
        <label for="gioketthuc">Giờ kết thúc: </label><input type="time" name="gioketthuc" id="gioketthuc" required>
        <br>
        <label for="sotrang">Số trang đề bài: </label><input type="text" name="sotrang" id="sotrang" required> 
        <br>
        <label for="socauhoi">Số câu hỏi: </label><input type="number" name="socauhoi" id="socauhoi" required>
        <input type="button" value="OK" onclick="xongbuoc1()">
        <br>
        <div id="baoloi"></div>

        <h2 id='buoc2' style='display: none;'>Bước 2:</h2>
        <div id="chonfileanh"></div><br>
        <div id="chondapan"></div>
        <input type="submit" name="btn_submit" value="Xác nhận" id='btn_submit' style='display: none;'/>
</form>

<script>
        function xongbuoc1() {
            var sotrang = document.getElementById('sotrang').value;
            var socauhoi = document.getElementById('socauhoi').value;
            if  (sotrang == 0 ) {
                document.getElementById('baoloi').innerHTML =  "Phải nhập số trang!";
                document.getElementById('chonfileanh').innerHTML =  "";
                return;
            }
            else if (socauhoi == 0) {
                document.getElementById('baoloi').innerHTML =  "Số câu hỏi phải lớn hơn 0!";
                document.getElementById('chondapan').innerHTML =  "";
                return;
            }
            document.getElementById('baoloi').innerHTML = '';
            document.getElementById('buoc2').style.display = 'block';
            document.getElementById('btn_submit').style.display = 'block';


            var i, htmlCode = '<p>Chọn file ảnh: (Chỉ chấp nhận định dạng .jpg) </p><br><br>';
            for (i=1; i<=sotrang; i++) {
                htmlCode +=  "<input type='file' name='trang_" + i.toString() + "' required><br>";
            }
            document.getElementById('chonfileanh').innerHTML = htmlCode;

            var i, htmlCode = '<p>Nhập đáp án cho từng câu: </p><br><br>';
            for (i=1; i<=socauhoi; i++) {
                j =  i.toString();
                if (i < 10) k = '0' + j; else k = j;
                htmlCode +=  "<span style='font-size: 22px; margin-right: 20px;'>" + k + ".</span>"
                    + "<input type='radio' value='A' onclick='hienThiDapAn(this.value," + j + ")' name='" + j + "' required>"
                    + "<input type='radio' value='B' onclick='hienThiDapAn(this.value," + j + ")' name='" + j + "' required>"
                    + "<input type='radio' value='C' onclick='hienThiDapAn(this.value," + j + ")' name='" + j + "' required>"
                    + "<input type='radio' value='D' onclick='hienThiDapAn(this.value," + j + ")' name='" + j + "' required>" 
                    + " <span id='dapancau_" + j + "'> </span><br>";
            }
            document.getElementById('chondapan').innerHTML = htmlCode;
        };

        function hienThiDapAn(giatri, sothutu) {
            document.getElementById("dapancau_" + sothutu).innerHTML = giatri;
        }
</script>