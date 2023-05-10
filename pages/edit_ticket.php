<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../classes/session.class.php');
    require_once(__DIR__ . '/../classes/user.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');
 
    $session = new Session();

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/authentication.tpl.php');
    require_once(__DIR__ . '/../templates/ticket.tpl.php');
    
    $db = getDatabaseConnection();

    $ticket = Ticket::getTicket($db, intval($_GET['id']));
    drawHeader($session);
    drawTicket($ticket);
    drawFooter();
?>
