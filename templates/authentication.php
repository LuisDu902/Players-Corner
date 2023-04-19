<?php function drawLogin()
{ ?>
  <div class="authentication">
        <div class="authentication-wrap">
        <img class="login-logo" src="../images/logo.png" alt="logo"></span>
        <h2 class="login-text"> The adventure awaits!<br> Sign in now to continue your<br> journey on <span class="highlight">Player's
            Corner</span>.</h2>
        <form action="../actions/action_login.php" method="post" class="authentication-form">
          <div class="input-box">
            <input type="email" name="email" required="required" placeholder="Email">
            <img src="../images/email.png" class="icon" alt="email">
          </div>
          <div class="input-box">
            <input type="password" name="password" required="required" placeholder="Password">
            <img src="../images/password.png" class="icon" alt="password">
          </div>
          <button type="submit" class="authentication-button">Sign In</button>
        </form>
        </div>
      </div>
<?php } ?>

<?php function drawRegister() { ?>
  <div class="authentication">
    <div class="authentication-wrap">
        <h2 class="register-text">Welcome to <span class="highlight">Player's Corner</span>! <br>Let's begin the adventure.</h2>
        <form action="../actions/action_register.php" method="post" class="authentication-form">
          
          <div class="input-box">
            <input type="text" name="name" required="required" placeholder="Name">
            <img src="../images/user.png" class="icon" alt="user">
          </div>
          
          <div class="input-box">
            <input type="email" name="email" required="required" placeholder="Email">
           <img src="../images/email.png" class="icon" alt="email">
          </div>
          
          <div class="input-box">
            <input type="password" name="password" required="required" placeholder="Password">
            <img src="../images/password.png"class="icon" alt="password">
          </div>

          <div class="input-box">
            <input type="username" name="username" required="required" placeholder="Username">
            <img src="../images/username.png" class="icon" alt="username">
          </div>
           <button type="submit" class="authentication-button">Register</button>
        </form>
        </div>
      </div>
  <?php }