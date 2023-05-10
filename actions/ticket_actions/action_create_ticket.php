<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../../database/connection.db.php');
  require_once(__DIR__ . '/../../classes/ticket.class.php');
  require_once(__DIR__ . '/../../utils/validation.php');

  $db = getDatabaseConnection();
  
  if (!valid_token($_POST['csrf'])){
    die(header("Location: ../../pages/create_ticket.php"));
  }

  $tags = explode(',' , $_POST['chosen_tags']);
  Ticket::registerTicket($db, $tags, $_POST['title'], $_POST['text'], "4-low", $_POST['category'], "public", $session->getId());
  $session->addMessage('success', 'Ticket successfully created!');
  header("Location: ../../pages/tickets.php");
?>