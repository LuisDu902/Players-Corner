<?php function drawLogin()
{ ?>
  <div class="vert-flex center">
    <div class="gradient round-border">
      <img class="login-logo block" src="../images/icons/logo.png" alt="logo"></span>
      <h2 id="login-text" class="auth-text center"> The adventure awaits!<br> Sign in now to continue your<br> journey on <span
          class="highlight">Player's Corner</span>.</h2>
      <form action="../actions/user_actions/action_login.php" method="post" class="authentication-form vert-flex">
        <div class="input-box round-border">
          <input type="email" name="email" required="required" placeholder="Email">
          <img src="../images/icons/email.png" class="icon" alt="email">
        </div>
        <div class="input-box round-border">
          <input type="password" name="password" required="required" placeholder="Password">
          <img src="../images/icons/password.png" class="icon" alt="password">
        </div>
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <div class="button-wrap gradient round-border auth-button"> <button type="submit">Sign In</button> </div>
      </form>
    </div>
  </div>
<?php } ?>

<?php function drawRegister()
{ ?>
  <div class="vert-flex center">
    <div class="gradient round-border">
      <h2 class="auth-text center">Welcome to <span class="highlight">Player's Corner</span>! <br>Let's begin the adventure.
      </h2>
      <form action="../actions/user_actions/action_register.php" method="post" class="authentication-form vert-flex">

        <div class="input-box round-border">
          <input type="text" name="name" required="required" placeholder="Name">
          <img src="../images/icons/user.png" class="icon" alt="user">
        </div>

        <div class="input-box round-border">
          <input type="email" name="email" required="required" placeholder="Email">
          <img src="../images/icons/email.png" class="icon" alt="email">
        </div>

        <div class="input-box round-border">
          <input type="password" name="password" required="required" placeholder="Password">
          <img src="../images/icons/password.png" class="icon" alt="password">
        </div>

        <div class="input-box round-border">
          <input type="username" name="username" required="required" placeholder="Username">
          <img src="../images/icons/username.png" class="icon" alt="username">
        </div>
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <div class="button-wrap gradient round-border auth-button"> <button type="submit">Register</button> </div>
      </form>
    </div>
  </div>
<?php }