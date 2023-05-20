<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../classes/session.class.php');
  require_once(__DIR__ . '/../utils/validation.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../classes/department.class.php');
  require_once(__DIR__ . '/../classes/user.class.php');
  require_once(__DIR__ . '/../classes/ticket.class.php');

  $db = getDatabaseConnection();

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $ticket = Ticket::getTicket($db, intval($_POST['ticketId']));
    $agent = User::getUser($db, intval($_POST['agentId']));

    if ($agent) {
      $agent->updateReputation($db, $agent->reputation + intval($_POST['value']));
      $ticket->updateFeedback($db, intval($_POST['value']));
      $message = ['status' => 'success'];
    } else {
      $message = ['status' => 'error'];
    }

    echo json_encode($message);
  }
?>