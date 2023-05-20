<?php

  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../classes/ticket.class.php');
  $db = getDatabaseConnection();

  $ticket=Ticket::getTicket($db,$_GET['id']);
  $ticket->changeProperties($db,$session->getId(),json_decode($_GET['tags']),$_GET['category'],$_GET['priority'],$_GET['status'],$_GET['visibility']);
  $ticket->assignTicket($db,$session->getId(),$_GET['replierName']);
  $ticket->setTicketTags($db,$_GET['id'],json_decode($_GET['tags']));
  $edit=Ticket::getTicket($db,$_GET['id']);

  echo json_encode($edit);
?>