<?php
  declare(strict_type = 1);

  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../classes/user.class.php');
  $db = getDatabaseConnection();

  $user = User::getUser($db, $session->getId());
  $ticket_stats = $user->getTicketStats($db);

  echo json_encode($ticket_stats);

?>