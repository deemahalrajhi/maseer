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
            <input type="text" name="number_id_login" placeholder=" رقم الهوية" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password_login" placeholder=" كلمة المرور" />
          </div>
          <?php if(isset($_SESSION['err']) && $_SESSION['err']!=""){ ?>
          <div style="margin:7px 0 7px 0;clear: both; color:red"><?php print $_SESSION['err']; unset($_SESSION['err']); ?></div>
          <?php } ?>
          
          <input type="submit" value="تسجيل دخول" class="btn solid" name="login_user"required />

        </form>

      </div>
    </div>
    <div class="panels-container">

    </div>

    <script src="./app.js"></script>
</body>

</html>