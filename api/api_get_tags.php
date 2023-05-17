<?php
  declare(strict_type = 1);

  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  $db = getDatabaseConnection();

  $stmt = $db->prepare('SELECT tag FROM TicketTag GROUP BY tag');
  $stmt->execute();
  
  $tags = $stmt->fetchAll(PDO::FETCH_COLUMN);

  echo json_encode($tags);

?>