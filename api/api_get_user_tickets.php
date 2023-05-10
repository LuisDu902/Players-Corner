<?php
  declare(strict_type = 1);

  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  $db = getDatabaseConnection();

  $stmt = $db->prepare('SELECT DATE(createDate) AS createDay, COUNT(*) AS numTickets FROM Ticket WHERE creator = ? GROUP BY createDay');
  $stmt->execute(array($session->getId()));
  
  $tickets = array();
  while ($day = $stmt->fetch()) {
   $tickets[] = array($day['createDay'], $day['numTickets']);
  }

  echo json_encode($tickets);

?>