<?php function drawLogin() { ?>
  <section class="vert-flex center">
    <div class="gradient round-border">
      <img class="login-logo block" src="../images/icons/logo.png" alt="logo"></span>
      <h2 id="login-text" class="auth-text center"> The adventure awaits!<br> Sign in now to continue your<br> journey on
        <strong class="highlight">Player's Corner</strong>.
      </h2>
      <form action="../actions/user_actions/action_login.php" method="post" class="authentication-form vert-flex">
        <label class="input-box round-border">
          <input type="email" name="email" required="required" placeholder="Email">
          <img src="../images/icons/email.png" class="icon" alt="email">
        </label>
        <label class="input-box round-border">
          <input type="password" name="password" required="required" placeholder="Password">
          <img src="../images/icons/password.png" class="icon" alt="password">
        </label>
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
        <div class="button-wrap gradient round-border auth-button"> <button type="submit">Sign In</button> </div>
      </form>
    </div>
  </section>
<?php } ?>

<?php function drawRegister()
{ ?>
  <section class="vert-flex center">
    <div class="gradient round-border">
      <h2 class="auth-text center">Welcome to <strong class="highlight">Player's Corner</strong>! <br>Let's begin the adventure. </h2>
      <form action="../actions/user_actions/action_register.php" method="post" class="authentication-form vert-flex">
        <label class="input-box round-border">
          <input type="text" name="name" required="required" placeholder="Name">
          <img src="../images/icons/user.png" class="icon" alt="user">
        </label>
        <label class="input-box round-border">
          <input type="username" name="username" required="required" placeholder="Username">
          <img src="../images/icons/username.png" class="icon" alt="username">
        </label>
        <label class="input-box round-border">
          <input type="email" name="email" required="required" placeholder="Email">
          <img src="../images/icons/email.png" class="icon" alt="email">
        </label>
        <label class="input-box round-border">
          <input type="password" name="password" required="required" placeholder="Password">
          <img src="../images/icons/password.png" class="icon" alt="password">
        </label>
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
        <div class="button-wrap gradient round-border auth-button"> <button type="submit">Register</button> </div>
      </form>
    </div>
  </section>
<?php }