<?php
  declare(strict_type = 1);

  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  $db = getDatabaseConnection();

  $stmt = $db->prepare('SELECT status, COUNT(*) as count FROM Ticket WHERE category = ? GROUP BY status;');
  $stmt->execute(array($_GET['department']));
  
  $statuses = array();
  while ($status = $stmt->fetch()) {
   $statuses[] = array($status['status'], $status['count']);
  }

  echo json_encode($statuses);

?>