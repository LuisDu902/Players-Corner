<?php function drawLogin()
{ ?>
  <div class="login">
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
      <h2>Welcome to <span class="highlight">Player's Corner</span>! <br>Let's begin the adventure.</h2>
      <form action="../actions/action_register.php">
        <div class="input-box">
        <span class="icon"><img src="../images/user.png" alt=""></span>
          <input type="text" name="name" required="required" placeholder="Name">
        </div>
        <div class="input-box">
          <span class="icon"><img src="../images/email.png" alt=""></span>
          <input type="email" name="email" required="required" placeholder="Email">
        </div>
        <div class="input-box">
          <span class="icon"><img src="../images/password.png" alt=""></span>
          <input type="password" name="password" required="required" placeholder="Password">

        </div>
        <div class="input-box">
          <span class="icon"><img src="../images/username.png" alt=""></span>
          <input type="username" name="username" required="required" placeholder="Username">
        </div>

        <button type="submit" class="register-button"><span>Register</span></button>

    </div>
  <?php }