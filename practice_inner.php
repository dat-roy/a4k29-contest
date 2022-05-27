<main class="contest-container">
	<div class="column column-left">
		<span class="column-left--top">
				Đáp Án Lựa Chọn
		</span>
		<div class="column-left--center">
			<form class="js-answer-form">
				<table>
					<thead>
						<tr>
							<th>Câu</th>
							<th>A</th>
							<th>B</th>
							<th>C</th>
							<th>D</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$query = mysqli_query($conn,"SELECT socauhoi FROM danhsach_luyentap WHERE idluyentap=$p");
							$row = mysqli_fetch_assoc($query);

							for ($index=1; $index<=$row['socauhoi']; $index++) {
								echo <<<EOD
													<tr>
													<td> $index </td>
													<td ><input type="radio" class="answer-radio" value="A" name="$index"></td>
													<td><input type="radio" class="answer-radio" value="B" name="$index"></td>
													<td><input type="radio" class="answer-radio" value="C" name="$index"></td>
													<td><input type="radio" class="answer-radio" value="D" name="$index"></td>
													</tr>
										EOD;
							}
						?>
					</tbody>
				</table>
			</form>
		</div>
		<div class="column-left--bottom">
				<button class="btn-submit popup-trigger <?php if ($STATUS == 2) echo 'btn-disabled' ?>" onclick="confirmAnswer(<?php echo $STATUS ?>)">Nộp Bài</button>
				<script>
					function confirmAnswer(status) {
						if (status == 1) {                  // status == 1 (đang diễn ra)
                            var index, htmlCode = '';
                            for (index=1; index<=50; index++) {
                                var checkedChoice =  (document.querySelector("input[name='"+ index + "']:checked")||{});
                                var userAnswer = checkedChoice.value;
                                if (!userAnswer) htmlCode += index + '.? <br>'
                                else 
                                    htmlCode += '<b class="b-color">' + index + '.' + userAnswer  + '</b>' + '<br>';

                                if (index == 10) {
                                    document.querySelector('.col-1').innerHTML = htmlCode;
                                    htmlCode = '';
                                }
                                else
                                    if (index ==20) {
                                        document.querySelector('.col-2').innerHTML = htmlCode;
                                        htmlCode = '';
                                    }
                                    else
                                        if (index ==30) {
                                            document.querySelector('.col-3').innerHTML = htmlCode;
                                            htmlCode = '';
                                        }
                                        else	
                                            if (index ==40) {
                                                document.querySelector('.col-4').innerHTML = htmlCode;
                                                htmlCode = '';
                                            }
                                            else 
                                                if (index == 50) {
                                                document.querySelector('.col-5').innerHTML = htmlCode;
                                                htmlCode = '';
                                            }
                            }
                        }
                        else {                      // status == 2 (đã kết thúc)
                            document.querySelector('.modal-title').style.display = 'none';
                            document.querySelector('.modal-col-wrap').style.display = 'none';
                            document.querySelector('.modal-confirm').style.display = 'none';
                            document.querySelector('.popup-modal').innerHTML = "<span style='color: #ff9f42; font-size: 22px;'>Đã hết thời gian quy định. Bạn không thể nộp bài!</span>";
                            document.querySelector('.popup-modal').style.height = '120px';
                        }
					}
				</script>
		</div>

		<!--	
		_______________________________
					 Modal   
		-->
		<div class="body-blackout"></div>

		 <div class="popup-modal shadow">
				<h4 class="modal-title">Kiểm tra lại đáp án:</h4>
				<div class="modal-col-wrap">
						<div class="col col-1"></div>
						<div class="col col-2"></div>
						<div class="col col-3"></div>
						<div class="col col-4"></div>
						<div class="col col-5"></div>
				</div>
				<div class="modal-confirm">
					<button class="confirm-correct">Sửa lại</button>
					<button class="confirm-submit">Ok, nộp</button>
				</div>
				<div class="js-note" style='margin-top: 10px;'></div>
		  </div>
		  
			<script>
				const modalTriggers = document.querySelector('.popup-trigger')
				const modalCloseTrigger = document.querySelector('.confirm-correct')
				const bodyBlackout = document.querySelector('.body-blackout')
				const note = document.querySelector('.js-note');

				modalTriggers.addEventListener('click', () => {
					const popupModal = document.querySelector(".popup-modal");
					popupModal.classList.add('is--visible');
					bodyBlackout.classList.add('is-blacked-out');

					modalCloseTrigger.addEventListener('click', () => {
						popupModal.classList.remove('is--visible')
						bodyBlackout.classList.remove('is-blacked-out')
						note.innerHTML = ''
					})

					bodyBlackout.addEventListener('click', () => {
						popupModal.classList.remove('is--visible')
						bodyBlackout.classList.remove('is-blacked-out')
						note.innerHTML = ''
					})
				})

			</script>
	</div>
	<!--_____________________________-->
	<?php $p = $_GET['p']; ?>
	<div class="column column-right" data-p = "<?php echo $p; ?>">
		<div class="column-right--top">
				<span>
					Thời gian: 
					<?php
						$query = mysqli_query($conn,"SELECT * FROM danhsach_luyentap WHERE idluyentap=$p");
						$row = mysqli_fetch_assoc($query);
						$date = date_format(date_create($row['ngay']),"d/m/Y");
						echo $row['giobatdau'].' - '. $row['gioketthuc'].' ('.$date.')';
					?>
				</span>
		</div>
		<div class="column-right--center">
			<div class="showimage">
				<?php 
					$query = mysqli_query($conn,"SELECT * FROM danhsach_luyentap WHERE idluyentap=$p");
					$row = mysqli_fetch_assoc($query);
					for ($i = 1; $i <= $row['sotrang']; $i++) {
						?>
						<img src="./assets/practice/practice_<?php echo $p.'/'.'('.$i.').jpg'?>" alt="" class="image">
						<?php
					}
				?>
			</div>
		</div>		
		<div class="column-right--bottom">
		</div>
	</div>
</main>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
	$(".confirm-submit").click(function(){
		$.ajax({
							type: "POST",
							url: "submit_P.php?p=" + $(".column-right").attr("data-p"),
							data: $('.js-answer-form').serialize(),
							success: function(response) {
								$('.js-note').html(response);
							}
			});
	});
</script>
