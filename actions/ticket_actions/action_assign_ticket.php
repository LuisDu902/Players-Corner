<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../../database/connection.db.php');
  require_once(__DIR__ . '/../../classes/ticket.class.php');

  if (!valid_token($_POST['csrf'])){
    die(header("Location: ../../pages/create_ticket.php"));
  }

  $db = getDatabaseConnection();

  $ticket = Ticket::getTicket($db, $_POST['id']);
  $ticket->assignTicket($db, $_POST['department']);

  $session->addMessage('success', 'Ticket assigned!');
  header("Location: ../../pages/tickets.php");
?>