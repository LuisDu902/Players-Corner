<?php
    declare(strict_type = 1);

    require_once(__DIR__ . '/../classes/session.class.php');
    $session = new Session();


    require_once(__DIR__ . '/../classes/user.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    require_once(__DIR__ . '/../templates/authentication.tpl.php');
    require_once(__DIR__ . '/../templates/user.tpl.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    $db = getDatabaseConnection();

    $users = User::searchUsers($db);
    
    drawHeader($session);
    drawUsers($users);
    drawFooter();
?>