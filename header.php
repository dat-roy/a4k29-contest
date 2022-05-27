<header class="main-header">
     <div class="header__left">
          <div class="links-container">
               <a href="index.php" class="links">Trang Chủ </a>
               <a href="practice_list.php" class="links">Học Tập</a>
               <a href="contest_list.php" class="links">Thi Thử</a>
          </div>
     </div>
     <div class="header__center">
          <div class="logo-container">
               <a href="index.php"><img src="./assets/img/logo_3.png" alt="" class="logo"></a>
          </div>
     </div>
    <div class="header__right">
     <?php 
          if (isset( $_SESSION['username']) && $_SESSION['username']) {
               echo "<span class='login-greetings'>Xin chào, <b> {$_SESSION['username'] }</b> </span>
                         <a role='button' href='./lib/null.php' class='btn-groups btn-info'>Thông Tin</a>
                         <a role='button' href='logout.php' class='btn-groups btn-logout'>Đăng Xuất</a>";
          }
          else {
			echo "<a role='button' href='login.php' class='btn-groups btn-login'>Đăng Nhập</a>";
          }
      ?>
    </div>
</header>
