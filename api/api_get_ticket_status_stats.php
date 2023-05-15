<?php
  declare(strict_type = 1);

  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../classes/ticket.class.php');
  $db = getDatabaseConnection();

  $statusStats = Ticket::getFieldStats($db, 'status');

  echo json_encode($statusStats);

?>