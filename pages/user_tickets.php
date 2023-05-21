<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../classes/user.class.php');
  require_once(__DIR__ . '/../classes/ticket.class.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/ticket.tpl.php');

  $db = getDatabaseConnection();

  $user = User::getUser($db, intval($_GET['userId']));
  $tickets = Ticket::searchTickets($db, $user->userId, $user->name, 'creator', 'title');

  drawHeader($session);
  drawUserTickets($session, $user, $tickets);
  drawFooter();
?>