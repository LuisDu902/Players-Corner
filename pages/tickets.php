<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../classes/session.class.php');
    require_once(__DIR__ . '/../classes/ticket.class.php');
    $session = new Session();

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/ticket.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    $db= getDatabaseConnection();
   
    $tickets = Ticket::searchTickets($db);
  
    drawHeader($session);
    drawTicketSearchBar();
    drawTickets($tickets);
    drawFooter();
?>