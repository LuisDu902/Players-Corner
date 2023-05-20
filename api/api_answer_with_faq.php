<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../classes/ticket.class.php');
  require_once(__DIR__ . '/../utils/validation.php');

  $db = getDatabaseConnection();

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $ticket = Ticket::getTicket($db, intval($_POST['ticketId']));
    $ticket->answerWithFAQ($db, $session->getId(), intval($_POST['faqId']));

    $message = $ticket->getLastMessage($db);

    echo json_encode($message);
  }

?>