<?php function drawHeader(Session $session)
{ ?>
<!DOCTYPE html>
<html>

<head>
    <title>Player's Corner</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/authentication.css">
</head>

<body>
    <div class="menu">
        <ul>
            <li class="logo"><a href="../pages/index.php"><img src="../images/logo.png" alt=""></a></li>
            <li class="active"> <a href="../pages/index.php">Home</a></li>
            <li>Forum</li>
            <li>FAQ</li>
            <li>Help</li>
            <?php
             if ($session->isLoggedIn()) drawLogoutForm($session);
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


<?php function drawLogoutForm(Session $session) { ?>
  <form action="../actions/action_logout.php" method="post" class="logout">
    <a href="../pages/profile.php"><?=$session->getName()?></a>
    <button type="submit">Logout</button>
  </form>
<?php } ?>