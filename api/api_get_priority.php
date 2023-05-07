<?php
  declare(strict_type = 1);

  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  $db = getDatabaseConnection();

  $stmt = $db->prepare('SELECT priority, COUNT(*) as count FROM Ticket WHERE category = ? GROUP BY priority;');
  $stmt->execute(array($_GET['department']));
  
  $priorities = array();
  while ($priority = $stmt->fetch()) {
   $priorities[] = array(substr($priority['priority'],2), $priority['count']);
  }

  echo json_encode($priorities);

?>