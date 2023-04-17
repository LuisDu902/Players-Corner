<?php function drawLogin()
{ ?>
  <div class="sign-in">
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
      <button type="submit" class="login"><span>Sign In</span></button>
    </form>

  </div>
<?php }