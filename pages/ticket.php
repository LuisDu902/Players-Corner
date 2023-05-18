<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../classes/session.class.php');
    require_once(__DIR__ . '/../classes/change.class.php');
    require_once(__DIR__ . '/../classes/ticket.class.php');
    require_once(__DIR__ . '/../classes/department.class.php');
    $session = new Session();

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/ticket.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    $db= getDatabaseConnection();
    $ticket = Ticket::getTicket($db, intval($_GET['id']));
    
    $messages = $ticket->getMessages($db);
    $history = $ticket->getTicketHistory($db);
    $attachedFiles = $ticket->getAttachedFiles();
    $departments = Department::getDepartments($db);
    $stats= ["new","open","closed","solved","assigned"];
    $priorities=['1-critical','2-high','3-medium','4-low'];
    $department=Department::getDepartment($db,$ticket->category);
    drawHeader($session);

    drawTicket($session,$ticket,$departments,$stats,$priorities,$department ,$messages, $history, $attachedFiles);
    drawFooter();
?>