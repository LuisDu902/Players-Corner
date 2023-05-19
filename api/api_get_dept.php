<?php
  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../classes/department.class.php');
  $db = getDatabaseConnection();
  $department = Department::getDepartment($db,$_GET['category']);

  echo json_encode($department);

?>