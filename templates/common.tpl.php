<?php function drawHeader(Session $session)
{ ?>
  <!DOCTYPE html>

  <head>
    <title>Player's Corner</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/authentication.css">
    <link rel="stylesheet" href="../css/profile.css">
  </head>

  <body>
    <header>
      <a href="../pages/index.php"><img class="logo" src="../images/logo.png" alt="logo"> </a>
      <nav>
        <ul class="nav_links">
          <li class="active"> <a href="../pages/index.php">Home</a></li>
          <li class="forum"><a href="#">Forum</a></li>
          <li class="FAQ"><a href="#">FAQ</a></li>
          <li class="Help"><a href="#">Help</a></li>
        </ul>
      </nav>
      <?php
      if ($session->isLoggedIn()) {
        drawProfileIcon($session);
      } else
        drawAuthForms(); ?>
    </header>

  <?php } ?>

  <?php function drawFooter()
  { ?>

  </body>

  </html>
<?php } ?>


<?php function drawAuthForms()
{ ?>
  <div class="buttons">
    <div class="button-wrap">
      <a href="../pages/login.php"><button class="sign-in">Sign In</button></a>
    </div>
    <div class="button-wrap">
      <a href="../pages/register.php"><button class="sign-up">Sign Up</button></a>
    </div>
  </div>
<?php } ?>


<?php function drawProfileIcon(Session $session){ ?>
  
  <div class="dropdown">
  <button class="dropbtn"><a href="../pages/profile.php" class="buttons round-wrap">
    <img src="../images/profile.png" alt="profile"></img>
  </a></button>
  <div class="dropdown-content">
    <a href="../pages/profile.php">Profile</a>
    <a href="../actions/action_logout.php">Sign out</a>
  </div>
</div>
<?php } ?>