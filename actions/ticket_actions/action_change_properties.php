<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../../database/connection.db.php');
  require_once(__DIR__ . '/../../classes/ticket.class.php');
  require_once(__DIR__ . '/../../utils/validation.php');

  $db = getDatabaseConnection();
  
  if (!valid_token($_POST['csrf'])){
    die(header("Location: ../../pages/index.php"));
  }

  $ticket = Ticket::getTicket($db,intval($_POST['id']));
  $ticket->changeProperties($db, $session->getId(), array(), $_POST['category'], $_POST['priority'], $_POST['status']);
  $session->addMessage('success', 'Ticket properties changed!');
  header("Location: ../../pages/ticket.php?id=" . $_POST['id']);
?>