<?php
    declare(strict_type = 1);

    require_once(__DIR__ . '/../classes/session.class.php');
    $session = new Session();


    require_once(__DIR__ . '/../classes/user.class.php');
    require_once(__DIR__ . '/../classes/admin.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/authentication.php');
    require_once(__DIR__ . '/../templates/control.php');
    
    $db = getDatabaseConnection();

    $users = Admin::searchUsers($db);
   
    drawHeader($session);
    drawAllUsers($users);
    drawFooter();
?>