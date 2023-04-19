<?php function drawHeader(Session $session){ ?>
  <!DOCTYPE html>
<head>
    <title>Navbar</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/authentication.css">
</head>
<body>
    <header>
        <a href = "../pages/index.php"><img class="logo" src="../images/logo.png" alt="logo"> </a>
        <nav>
          <ul class="nav_links">
            <li class="active"> <a href="../pages/index.php">Home</a></li>
            <li class="forum"><a href="#">Forum</a></li>
            <li class="FAQ"><a href="#">FAQ</a></li>
            <li class="Help"><a href="#">Help</a></li>
          </ul>
        </nav>
        <div class="buttons">
          <div class="button-border-wrap">
            <a href="../pages/register.php"><button class="sign-in">Sign In</button></a>
          </div>
          <div class="button-border-wrap">
          <a href="../pages/register.php"><button class="sign-up">Sign Up</button></a>
        </div>
        </div>
        
      </header>
    
<?php } ?>

<?php function drawFooter()
    { ?>

    </body>

    </html>
<?php } ?>


<?php function drawAuthForms(){ ?>
    <li><a href="../pages/login.php" class="sign-in-button"><span>Sign In</span></a></li>
    <li><a href="../pages/register.php" class="sign-up-button"><span>Sign Up</span></a></li>
<?php } ?>     


<?php function drawProfileIcon(Session $session) { ?>
  
  <li><a href="../pages/profile.php">
    <img src="../images/profile.png" alt="" id="profile-img"></img>
    <span id="username"><?=$session->getName()?></span>
  </a></li>

<?php } ?>

<?php function drawLogoutForm(Session $session) { ?>
  <li> <form action="../actions/action_logout.php" >
    <button type="submit" class="sign-out-button"><span>Sign Out </span></button></form></li>
<?php } ?>