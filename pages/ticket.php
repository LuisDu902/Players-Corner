<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../classes/session.class.php');
    require_once(__DIR__ . '/../classes/ticket.class.php');
    require_once(__DIR__ . '/../classes/message.class.php');
    $session = new Session();

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/ticket.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    $db= getDatabaseConnection();
    $ticket = Ticket::getTicket($db, intval($_GET['id']));
    $messages = $ticket->getMessages($db);


    drawHeader($session);
    drawTicket($ticket, $messages);
    drawFooter();
?>