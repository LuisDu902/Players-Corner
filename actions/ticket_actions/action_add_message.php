<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../../database/connection.db.php');
  require_once(__DIR__ . '/../../classes/ticket.class.php');

  $db = getDatabaseConnection();
  
  if (!valid_token($_POST['csrf'])){
    die(header("Location: ../../pages/create_ticket.php"));
  }

  $ticket = Ticket::getTicket($db, $_POST['id']);
  $ticket->addMessage($db, $_POST['userId'],$_POST['text']);

  $session->addMessage('success', 'Message added!');
  header("Location: ../../pages/tickets.php");
?>