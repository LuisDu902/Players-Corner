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

  Ticket::registerTicket($db, $_POST['tags'], $_POST['title'], $_POST['text'], $_POST['priority'], $_POST['category'], $_POST['date'], $_POST['visibility'], $_POST['userId']);
  $session->addMessage('success', 'Ticket successfully created!');
  header("Location: ../../pages/tickets.php");
?>