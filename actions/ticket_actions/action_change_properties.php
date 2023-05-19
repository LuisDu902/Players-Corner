<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../../classes/session.class.php');
  $session = new Session();
  use PDOException;
  require_once(__DIR__ . '/../../database/connection.db.php');
  require_once(__DIR__ . '/../../classes/ticket.class.php');
  require_once(__DIR__ . '/../../utils/validation.php');

  $db = getDatabaseConnection();
  
  if (!valid_token($_POST['csrf'])){
    die(header("Location: ../../pages/index.php"));
  }
  try {
    $ticket = Ticket::getTicket($db, intval($_POST['id']));
    $ticket->changeProperties($db, $session->getId(), array(), htmlentities($_POST['category']), htmlentities($_POST['priority']), htmlentities($_POST['status']));
    $session->addMessage('success', 'Ticket properties changed!');
    header("Location: ../../pages/ticket.php?id=" . $_POST['id']);
  } catch (PDOException $e) {
    $session->addMessage('error', 'Failed to change ticket properties due to foreign key constraint violation.');
    header("Location: ../../pages/index.php");
  }
?>