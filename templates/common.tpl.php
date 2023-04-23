<?php function drawHeader(Session $session){ ?>
<!DOCTYPE html>
<html>

<head>
    <title>Player's Corner</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/authentication.css">
    <link rel="stylesheet" href="../css/profile.css">
</head>

<body>
    <div class="menu">
        <ul>
            <li class="logo"><a href="../pages/index.php"><img src="../images/logo.png" alt=""></a></li>
            <li class="active"> <a href="../pages/index.php">Home</a></li>
            <li class="forum"><a href="../pages/forum.php">Forum</a></li>
            <li>FAQ</li>
            <li>Help</li>
            <?php
             if ($session->isLoggedIn()) {
              ?>
              <li class="create"><a href="../pages/ticket.php"> Create Ticket </a> </li>
              <?php
              drawLogoutForm($session);
              drawProfileIcon($session);
              ?> 
          <?php
             }
             else drawAuthForms();;
            ?>
            </ul>
    </div>
    <section id="messages">
      <?php foreach ($session->getMessages() as $messsage) { ?>
        <article class="<?=$messsage['type']?>">
          <?=$messsage['text']?>
        </article>
      <?php } ?>
    </section>

    
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