<div class="rank-container">
    <h1 style='font-weight:500; margin-top:50px; color: #ffb332;'>Bảng xếp hạng </h1>
    <table>
        <thead>
            <tr>
                <th>Xếp hạng</th>
                <th>Tên thí sinh</th>
                <th>Số điểm</th>
                <th>Thời gian nộp</th>
                <th>Chi tiết</th>
            </tr>
        </thead>
        <tbody>

            <?php 
                /* PHẦN CHẤM THI */
                $c = $_GET['c'];

                /* Lấy đáp án */
                $query = mysqli_query($conn,"SELECT socauhoi,dapan FROM danhsach_cuocthi WHERE idcuocthi=$c");
                $row = mysqli_fetch_assoc($query);
                $NUMBER = $row['socauhoi'];
                $KEY = $row['dapan'];

                /* Lấy bài làm thí sinh và bắt đầu chấm */
                $query = mysqli_query($conn,"SELECT * FROM ketqua_cuocthi_$c");
                while ($row = mysqli_fetch_array($query)) { 

                    $id_contestant = $row['idthisinh'];
                    $submission = $row['bailam'];
                    $result = '';
                    $right_ans = 0;

                    for ($index = 1; $index <= $NUMBER; $index++) {
                        if ( $submission[$index - 1] == $KEY[$index - 1] ) {
                            $result .= '1';
                            $right_ans++;
                        }
                        else
                            $result .= '0';
                    }
                    
                    $sql = " UPDATE ketqua_cuocthi_$c
                                SET ketquacham = '$result' ,socaudung = $right_ans
                                WHERE idthisinh=$id_contestant ";
                    mysqli_query($conn,$sql );
                    
                }
                
            ?>

            <?php 
                $c = $_GET['c'];
                $query = mysqli_query($conn,"SELECT * FROM ketqua_cuocthi_$c ORDER BY socaudung DESC, thoigiannop ASC");
            
                $index = 0;
                while ($row = mysqli_fetch_array($query)){ 

                    $time = $row['thoigiannop'];
                    $number = $row['socaudung'];
                    $submission = $row['bailam'];
                    $result = $row['ketquacham'];

                    $id_contestant = $row['idthisinh'];
                    $sql_select = mysqli_query($conn,"SELECT * FROM user WHERE id = $id_contestant");
                    $sql_result = mysqli_fetch_assoc($sql_select);
                    $name = $sql_result['realname'];
                    if ($name == '(unknown)') $name = $sql_result['username'];

                    $index++;
                    
                    if ($index == 1) {
                        $rank = 1;
                        $number_before = $number;
                        $rank_before = 1;
                    }
                    
                    if  ($number == $number_before) $rank = $rank_before;
                    else $rank = $index;

                    $score = $number * 0.2;
                    if ($rank <= 3) {
                        switch ($rank) {
                            case 1:
                                $str = '1st';
                                break;
                            case 2:
                                $str = '2nd';
                                break;
                            case 3:
                                $str = '3rd';
                                break;
                        }
                        echo <<< EOD
                                <tr>
                                    <td><img src='./assets/img/{$str}.png' alt='{$str}' class='in-top3'></td>
                                    <td>{$name}</td>
                                    <td> {$score}</td>
                                    <td> {$time}</td>
                                    <td><button class='popup-trigger' onclick="echoDetails('{$submission}','{$result}')"> Click </button></td>
                                </tr>
                            EOD;
                    }
                    
                    if (($rank >= 4) && ($rank <= 9))
                            echo <<< EOD
                                <tr>
                                    <td><span class="out-top3">0{$rank}</span></td>
                                    <td>{$name}</td>
                                    <td> {$score}</td>
                                    <td> {$time}</td>
                                    <td><button class='popup-trigger' onclick="echoDetails('{$submission}','{$result}')"> Click </button></td>
                                </tr>
                            EOD;

                    if ($rank >= 10)
                            echo <<< EOD
                                <tr>
                                    <td><span class="out-top3">{$rank}</span></td>
                                    <td>{$name}</td>
                                    <td> {$score}</td>
                                    <td> {$time}</td>
                                    <td><button class='popup-trigger' onclick="echoDetails('{$submission}','{$result}')"> Click </button></td>
                                </tr>
                            EOD;
                    
                    $rank_before = $rank;
                    $number_before = $number;
                }
                $GLOBALS['total'] = $index;
            ?>
        </tbody>
    </table>

    <div class="total">
            Tổng số thí sinh: <?php echo $GLOBALS['total']; ?>
    </div>
</div>

<!--	
_______________________________
                Modal   
-->
<div class="body-blackout"></div>

    <div class="popup-modal shadow">
        <h4 class="modal-title">Bài nộp thí sinh: </h4>
        <div class="modal-col-wrap">
                <div class="col col-1"></div>
                <div class="col col-2"></div>
                <div class="col col-3"></div>
                <div class="col col-4"></div>
                <div class="col col-5"></div>
        </div>
        <div class="modal-confirm">
            <button class="confirm-close">Đóng</button>
        </div>
    </div>
        

        <script>
            function echoDetails(submission, result) {

                const popupModal = document.querySelector(".popup-modal");
                const modalCloseTrigger = document.querySelector('.confirm-close');
                const bodyBlackout = document.querySelector('.body-blackout');
                modalCloseTrigger.addEventListener('click', () => {
                    popupModal.classList.remove('is--visible')
                    bodyBlackout.classList.remove('is-blacked-out')
                })
                bodyBlackout.addEventListener('click', () => {
                    popupModal.classList.remove('is--visible')
                    bodyBlackout.classList.remove('is-blacked-out')
                })

                popupModal.classList.add('is--visible');
                bodyBlackout.classList.add('is-blacked-out');

                var htmlCode = color = '';
                var index;
                for (index = 0; index < submission.length; index ++) {

                    if (result[index] == '1') color = '#0ece4b'; else color = '#dc3545';
                    order = index + 1;
                    htmlCode += "<b style='color: " + color + " '> " + order + '.' + submission[index]  + '</b>' + '<br>';

                    if (order == 10) {
                        document.querySelector('.col-1').innerHTML = htmlCode;
                        htmlCode = '';
                    }
                    else if (order == 20) {
                            document.querySelector('.col-2').innerHTML = htmlCode;
                            htmlCode = '';
                        }
                        else if (order == 30) {
                                document.querySelector('.col-3').innerHTML = htmlCode;
                                htmlCode = '';
                            }
                            else if (order == 40) {
                                    document.querySelector('.col-4').innerHTML = htmlCode;
                                    htmlCode = '';
                                }
                                else if (order == 50) {
                                    document.querySelector('.col-5').innerHTML = htmlCode;
                                    htmlCode = '';
                                };
                }
            }
        </script>