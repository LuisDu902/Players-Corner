<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../classes/session.class.php');

  $session = new Session();
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../classes/ticket.class.php');
  require_once(__DIR__ . '/../classes/faq.class.php');
  require_once(__DIR__ . '/../classes/department.class.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/faq.tpl.php');
  require_once(__DIR__ . '/../templates/ticket.tpl.php');

    $db= getDatabaseConnection();
    $ticket = Ticket::getTicket($db, intval($_GET['id']));
    
    $messages = $ticket->getMessages($db);
    $history = $ticket->getTicketHistory($db);
    $attachedFiles = $ticket->getAttachedFiles();
    $departments = Department::getDepartments($db);
    $stats= ["new","open","closed","solved","assigned"];
    $priorities=["  critical","  high","  medium","  low"];
    $department=Department::getDepartment($db,$ticket->category);
    $faqs = FAQ::getFAQs($db);
    drawHeader($session);

    drawTicket($session,$ticket,$departments,$stats,$priorities,$department ,$messages, $history, $attachedFiles,$faqs);
    drawFooter();
?>