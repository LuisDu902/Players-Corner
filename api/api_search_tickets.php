<?php
  declare(strict_type = 1);

  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../classes/ticket.class.php');
  require_once(__DIR__ . '/../classes/user.class.php');

  $db = getDatabaseConnection();

  $tickets = Ticket::searchTickets($db, $_GET['search'], $_GET['filter'], $_GET['order']);

  echo json_encode($tickets);

?>