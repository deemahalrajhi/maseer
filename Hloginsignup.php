<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SignIn&SignUp</title>
  <link rel="stylesheet" type="text/css" href="./style.css" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        
        <form method="post" action="login_request.php" class="sign-in-form">
          <h2 class="title">أهلا بك</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="number_id_login" placeholder="رقم الحاج" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password_login" placeholder="كلمة المرور" required />
            
          </div>
          <?php if(isset($_SESSION['err']) && $_SESSION['err']!=""){ ?>
          <div style="margin:7px 0 7px 0;clear: both; color:red"><?php print $_SESSION['err']; unset($_SESSION['err']); ?></div>
          <?php } ?>
          <input type="submit" value="تسجيل دخول" class="btn solid" name="login_user" />
        </form>

        <form method="post" action="register_request.php" class="sign-up-form">
          <h2 class="title">إنشاء حساب</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="number_id" placeholder="رقم الحاج" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="كلمة المرور" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="confirm_password" placeholder="تأكيد كلمة المرور" required />
          </div>
          <div class="input-field">
            <i class="fas fa-phone"></i>
            <input type="text" name="phone" placeholder="رقم الجوال" required />
          </div>
          <input type="submit" value="إنشاء الحساب" name="create_user" class="btn solid" />

        </form>
      </div>
    </div>
    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <p>ليس لديك حساب؟</p>
          <button class="btn transparent" id="sign-up-btn">إنشاء حساب</button>
        </div>
        <img src="./img/log.svg" class="image" alt="">
      </div>

      <div class="panel right-panel">
        <div class="content">
          <p>منا و�?ينا</p>
          <button class="btn transparent" id="sign-in-btn">تسجيل دخول</button>
        </div>
        <img src="./img/register.svg" class="image" alt="">
      </div>
    </div>
  </div>
  </div>

  <script src="./app.js"></script>
</body>

</html>