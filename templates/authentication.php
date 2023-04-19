<?php function drawLogin()
{ ?>
  <div class="login">
    <span class="logo"><img src="../images/logo.png" alt=""></span>
    <h2> The adventure awaits!<br> Sign in now to continue your journey on <span class="highlight">Player's
        Corner</span>.</h2>
    <form action="../actions/action_login.php" method="post">
      <div class="input-box">
        <span class="icon"><img src="../images/email.png" alt=""></span>
        <input type="email" name="email" required="required" placeholder="Email">
      </div>
      <div class="input-box">
        <span class="icon"><img src="../images/password.png" alt=""></span>
        <input type="password" name="password" required="required" placeholder="Password">
      </div>
      <button type="submit" class="login-button"><span>Sign In</span></button>
    </form>

  </div>
<?php } ?>

<?php function drawRegister() { ?>
  <div class="register">
        <div class="register-wrap">
        <h2>Welcome to <span class="highlight">Player's Corner</span>! <br>Let's begin the adventure.</h2>
        <form action="../actions/action_register.php" method="post" class="register-form">
          
          <div class="input-box">
            <input type="text" name="name" required="required" placeholder="Name">
            <span class="icon"><img src="../images/user.png" alt=""></span>
          </div>
          
          <div class="input-box">
            <input type="email" name="email" required="required" placeholder="Email">
            <span class="icon"><img src="../images/email.png" alt=""></span> 
          </div>
          
          <div class="input-box">
            <input type="password" name="password" required="required" placeholder="Password">
            <span class="icon"><img src="../images/password.png" alt=""></span>
          </div>

          <div class="input-box">
            <input type="username" name="username" required="required" placeholder="Username">
            <span class="icon"><img src="../images/username.png" alt=""></span>
          </div>

           <button type="submit" class="register-button">Register</button>
        </form>
        </div>
      </div>
  <?php }