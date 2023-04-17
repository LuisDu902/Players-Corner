<?php function drawHeader(Session $session)
{ ?>
<!DOCTYPE html>
<html>

<head>
    <title>Player's Corner</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sign.up.css">
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
                drawAuthForms();
            ?>
            </ul>
    </div>
    
<?php } ?>

<?php function drawFooter()
    { ?>



    </body>

    </html>
<?php } ?>


<?php function drawAuthForms(){ ?>
    
    <li><a href="../pages/login.php" class="login-button"><span>Sign In</span></a></li>
    <li><a href="../pages/sign.up.php" class="sign-button"><span>Sign Up</span></a></li>
<?php } ?>     