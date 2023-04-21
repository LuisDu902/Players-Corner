<?php
    
    require_once(__DIR__ . '/../classes/session.class.php');
    require_once(__DIR__ . '/../classes/user.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');
 
    $session = new Session();

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/authentication.php');
    require_once(__DIR__ . '/../templates/control.php');
    
    $db = getDatabaseConnection();

    $users = User::getAllUsers($db);
   
    drawHeader($session);
    drawAllUsers($users);
    drawFooter();
?>