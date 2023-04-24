<?php function drawHeader(Session $session)
{ ?>
  <!DOCTYPE html>

  <head>
    <title>Player's Corner</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/authentication.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/user.css">
    <link rel="stylesheet" href="../css/department.css">
    <link href='https://unpkg.com/css.gg@2.0.0/icons/css/search.css' rel='stylesheet'>
    <script src="../javascript/script.js" defer></script>
    <script src="../javascript/pop_up_windows.js" defer></script>
    <script src="../javascript/preview_image.js" defer></script>
  </head>

  <body>
    <header>
      <a href="../pages/index.php"><img class="logo" src="../images/icons/logo.png" alt="logo"> </a>
      <nav>
        <ul class="nav_links">
          <li class="active"> <a href="../pages/index.php">Home</a></li>
          <li class="forum"><a href="#">Forum</a></li>
          <li class="FAQ"><a href="#">FAQ</a></li>
          <li class="Help"><a href="#">Help</a></li>
          <?php if ($session->isLoggedIn() && $session->getRole() === "admin") {
            drawAdminButtons();
          } ?>

        </ul>
      </nav>
      <?php
      if ($session->isLoggedIn()) {
        drawProfileIcon($session);
      } else
        drawAuthForms(); ?>
    </header>
    <section id="messages">
      <?php foreach ($session->getMessages() as $messsage) { ?>
        <article class="<?= $messsage['type'] ?>">
          <?= $messsage['text'] ?>
        </article>
      <?php } ?>
    </section>
    <main>
    <?php } ?>

    <?php function drawFooter()
    { ?>
    </main>
  </body>

  </html>
<?php } ?>


<?php function drawAdminButtons()
{ ?>
  <li class="Users"><a href="../pages/users.php">Users</a></li>
  <li class="Users"><a href="../pages/departments.php">Departments</a></li>
<?php } ?>

<?php function drawAuthForms()
{ ?>
  <div class="buttons">
    <div class="two-button-wrap button-wrap">
      <a href="../pages/login.php"><button class="sign-in">Sign In</button></a>
    </div>
    <div class="two-button-wrap button-wrap">
      <a href="../pages/register.php"><button class="sign-up">Sign Up</button></a>
    </div>
  </div>
<?php } ?>


<?php function drawProfileIcon(Session $session)
{ ?>

  <div class="dropdown">
    <button class="dropbtn">
      <a href="../pages/profile.php" class="buttons">
        <img src=<?=$session->getPhoto() ?> alt="user-profile">
        <span class="username"><?= $session->getName() ?></span>
      </a></button>
    <div class="dropdown-content">
      <a href="../pages/profile.php">Profile</a>
      <a href="../actions/action_logout.php">Sign out</a>
    </div>
  </div>
<?php } ?>