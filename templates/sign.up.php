<?php function drawSignUp()
{ ?>
  <div class="sign-up" id="sign-up">
    <div class="form-box sign-up">
      <h2> Welcome to Player's Corner! <br>Let's begin the adventure </h2>
      <form action="#">
        <div class="input-box">
        <span class="icon"><img src="../images/user.png" alt=""></span>
          <input type="text" placeholder="Name" required="required">
        </div>
        <div class="input-box">
          <span class="icon"><img src="../images/email4.png" alt=""></span>
          <input type="email" required="required" placeholder="Email">
        </div>
        <div class="input-box">
          <span class="icon"><img src="../images/password.png" alt=""></span>
          <input type="password" required="required" placeholder="Password">

        </div>
        <div class="input-box">
          <span class="icon"><img src="../images/username.png" alt=""></span>
          <input type="username" required="required" placeholder="Username">
        </div>

        <button type="submit" class="register"><span>Register</span></button>

    </div>
  <?php }