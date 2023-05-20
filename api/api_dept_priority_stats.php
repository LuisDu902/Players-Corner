<?php
  declare(strict_type = 1);

  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../classes/department.class.php');
  $db = getDatabaseConnection();

  $department = Department::getDepartment($db, $_GET['department']);
  $priority_stats = $department->getPriorityStats($db);
 
  echo json_encode($priority_stats);
?>