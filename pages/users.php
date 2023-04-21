<?php
    
    require_once(__DIR__ . '/../classes/session.class.php');
    require_once(__DIR__ . '/../classes/user.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');
 
    $session = new Session();

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/authentication.php');
    require_once(__DIR__ . '/../templates/client.php');
    
    $db = getDatabaseConnection();

    $clients = User::getClients($db);
   
    drawHeader($session);
    drawClients($clients);
    drawFooter();
?>